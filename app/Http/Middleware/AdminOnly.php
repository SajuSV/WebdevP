<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// A "guard" for the admin pages. It runs before every admin controller.
class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        // Not logged in, or not an admin? Send to the admin login page.
        if (! $request->user() || ! $request->user()->is_admin) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
