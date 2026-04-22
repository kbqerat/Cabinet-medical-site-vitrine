<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DoctorAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('firebase_uid')) {
            return redirect('/login/doctor');
        }

        return $next($request);
    }
}
