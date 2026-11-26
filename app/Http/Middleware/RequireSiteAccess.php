<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

// Restricts public pages when the admin enables user-side login protection.
class RequireSiteAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (SiteSetting::current()->require_user_login && ! Auth::check()) {
            return redirect()->guest(route('login'));
        }

        return $next($request);
    }
}
