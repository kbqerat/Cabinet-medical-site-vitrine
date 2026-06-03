<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DoctorAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/login/doctor');
        }

        if (auth()->user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        if (!auth()->user()->hasVerifiedEmail()) {
            return redirect('/email-verification');
        }

        if (auth()->user()->verification_status !== 'approved') {
            return redirect('/verification/en-attente');
        }

        return $next($request);
    }
}
