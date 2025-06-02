<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckUserOrEmployer;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->appendToGroup('guest',[
             RedirectIfAuthenticated::class,
        
        ]);
        $middleware->appendToGroup('auth',[
             Authenticate::class,
        
        ]);
        $middleware->appendToGroup('checkRole',[
            CheckUserOrEmployer::class,
       
       ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
