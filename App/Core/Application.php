<?php

namespace App\Core;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Facade;
use Illuminate\Routing\Contracts\CallableDispatcher as CallableDispatcherContract;
use Illuminate\Routing\CallableDispatcher;
use App\Http\Kernel;

class Application extends Container
{
    /**
     * The application's event dispatcher.
     */
    public Dispatcher $events;

    /**
     * The application's router instance.
     */
    public Router $router;

    /**
     * Create a new application instance.
     */
    public function __construct()
    {
        // 0. Register Container Singleton
        static::setInstance($this);

        // 1. Initialize Event Dispatcher
        $this->events = new Dispatcher($this);
        
        // 2. Set up Facades
        Facade::setFacadeApplication($this);

        // 3. Bind Callable Dispatcher (fixes routing closure resolution)
        $this->bind(CallableDispatcherContract::class, fn($app) => new CallableDispatcher($app));

        // 4. Initialize Router
        $this->router = new Router($this->events, $this);
        $this->instance('router', $this->router);

        // 5. Register Middleware
        Kernel::registerMiddleware($this->router);
    }
}
