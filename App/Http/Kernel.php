<?php

namespace App\Http;

use Illuminate\Routing\Router;
use App\Http\Middleware\AuthMiddleware;

class Kernel
{
    public static function registerMiddleware(Router $router)
    {
        $router->aliasMiddleware('auth', AuthMiddleware::class);
    }
}
