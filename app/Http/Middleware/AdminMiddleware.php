<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // allow either a web user with role=admin, or an admin-guard login
        if (auth()->user()?->role !== 'admin' && ! Auth::guard('admin')->check()) {
            // abort(403, 'You do not have admin access.');
            return redirect('/');
        }

        return $next($request);
    }
}
