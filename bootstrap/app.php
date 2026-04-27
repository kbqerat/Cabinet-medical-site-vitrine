<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__));

// Sur Vercel, /tmp est le seul répertoire writable
if (env('LARAVEL_STORAGE_PATH')) {
    $app->useStoragePath(env('LARAVEL_STORAGE_PATH'));
}
if (env('LARAVEL_BOOTSTRAP_CACHE')) {
    $app->useBootstrapPath(env('LARAVEL_BOOTSTRAP_CACHE'));
}

return $app
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin'  => \App\Http\Middleware\AdminMiddleware::class,
            'doctor' => \App\Http\Middleware\DoctorAuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
