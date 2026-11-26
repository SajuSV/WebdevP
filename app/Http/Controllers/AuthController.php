<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->is_admin
                ? redirect()->route('admin.site.edit')
                : redirect()->route('home');
        }

        return view('auth.user-login');
    }

    public function showAdminLogin()
    {
        // Already logged in as admin? Skip the login page.
        if (Auth::user()?->is_admin) {
            return redirect()->route('admin.site.edit');
        }

        return view('auth.admin-login');
    }

    // Login for normal users only (admin accounts are rejected here)
    public function login(Request $request)
    {
        if (! $this->attempt($request, ['is_admin' => false], allowPlainId: true)) {
            return back()->withErrors(['auth' => 'Invalid user ID or password.'])->onlyInput('email');
        }

        return redirect()->intended(route('home'));
    }

    // Login for the admin panel: only admin accounts are accepted
    public function adminLogin(Request $request)
    {
        // The extra "is_admin" rule rejects normal users.
        if (! $this->attempt($request, ['is_admin' => true])) {
            return back()->withErrors(['auth' => 'Invalid login ID or password.'])->onlyInput('email');
        }

        return redirect()->route('admin.site.edit');
    }

    public function logout(Request $request)
    {
        $wasAdmin = (bool) $request->user()?->is_admin;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (! $wasAdmin) {
            return SiteSetting::current()->require_user_login
                ? redirect()->route('login')
                : redirect()->route('home');
        }

        return redirect()->route('admin.login');
    }

    // Shared helper: check the email/user ID + password against the users table
    private function attempt(Request $request, array $extraRules = [], bool $allowPlainId = false): bool
    {
        $credentials = $request->validate([
            'email' => ['required', $allowPlainId ? 'string' : 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials + $extraRules)) {
            return false;
        }

        // New session id after login (security best practice)
        $request->session()->regenerate();

        return true;
    }
}
