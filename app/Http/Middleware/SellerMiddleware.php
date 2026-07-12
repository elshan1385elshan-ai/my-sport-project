<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->guard('seller')->check() || ! auth()->guard('seller')->user()->isApprovedSeller()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'دسترسی غیرمجاز'], 403);
            }

            return redirect()->route('seller.login')->with('error', 'شما باید به عنوان فروشنده تأیید شده وارد شوید');
        }

        return $next($request);
    }
}
