<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isSuperAdmin()) {
            return $next($request);
        }

        if ($user && (! $user->tenant || ! $user->tenant->is_active)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'حسابك موقوف أو غير مرتبط بحساب فعّال. تواصل مع الدعم.',
            ]);
        }

        return $next($request);
    }
}
