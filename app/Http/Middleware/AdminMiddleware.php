<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $adminEmail = env('ADMIN_EMAIL');

        if (!session('firebase_uid') || session('firebase_email') !== $adminEmail) {
            return redirect('/login/doctor')->with('error', 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}
