<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SellerMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

        // درگاه پرداخت محلی (local) فرم خود را بدون توکن CSRF به این مسیر ارسال می‌کند
        $middleware->validateCsrfTokens(except: ['callback']);

        // important: do NOT remove/override default middleware.
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
