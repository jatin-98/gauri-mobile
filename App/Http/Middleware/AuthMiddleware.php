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

        $response = $next($request);

        // Prevent browser caching so the back button doesn't show protected pages after logout
        if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
        } else {
            header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: Sat, 01 Jan 1990 00:00:00 GMT');
        }

        return $response;
    }
}
