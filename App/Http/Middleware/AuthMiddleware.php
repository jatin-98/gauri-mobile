<?php

namespace App\Http\Middleware;

use App\Core\Session;
use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::get("user_id") == null) {
            redirect('/login');
        }

        return $next($request);
    }
}
