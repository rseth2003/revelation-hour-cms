<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\RejectOversizedRequests;
use App\Http\Middleware\RequireHttpsInProduction;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\ModuleRouteAccessMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append([
            RejectOversizedRequests::class,
            RequireHttpsInProduction::class,
            SecurityHeaders::class,
        ]);

        $middleware->appendToGroup('web', ModuleRouteAccessMiddleware::class);

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'module' => \App\Http\Middleware\ModuleAccessMiddleware::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
