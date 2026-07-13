<?php

namespace App\Http;

use Illuminate\Routing\Router;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\VerifyCsrfToken;

class Kernel
{
    public static function registerMiddleware(Router $router)
    {
        $router->aliasMiddleware('auth', AuthMiddleware::class);
        $router->aliasMiddleware('csrf', VerifyCsrfToken::class);
    }
}
