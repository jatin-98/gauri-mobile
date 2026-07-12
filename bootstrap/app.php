<?php

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Facade;
use Illuminate\Routing\Contracts\CallableDispatcher as CallableDispatcherContract;
use Illuminate\Routing\CallableDispatcher;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;
use App\Http\Kernel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

// ------------------------------------------------------
// Load .env file into $_ENV (no package needed)
// ------------------------------------------------------
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key]    = $value;
            putenv("$key=$value");
        }
    }
}


// ------------------------------------------------------
// 1️⃣ Container, Events & Facades Setup
// ------------------------------------------------------
$container = new Container;
$events = new Dispatcher($container);

// Callable Dispatcher Binding (Fixes routing closure resolution)
$container->bind(CallableDispatcherContract::class, fn($app) => new CallableDispatcher($app));

// Set Facade application context
Facade::setFacadeApplication($container);

// ------------------------------------------------------
// 2️⃣ Router Setup
// ------------------------------------------------------
$router = new Router($events, $container);
$container->instance('router', $router);

// Register middleware from your Kernel
Kernel::registerMiddleware($router);

// ------------------------------------------------------
// 3️⃣ DB connection
// ------------------------------------------------------


$config = require __DIR__ . '/../config/database.php';

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => $config['driver'],
    'host'      => $config['host'],
    'database'  => $config['database'],
    'username'  => $config['username'],
    'password'  => $config['password'],
    'charset'   => $config['charset'],
    'collation' => $config['collation'],
    'prefix'    => $config['prefix'],
]);

// Make this Capsule instance available globally.
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Optionally bind it into your container
$container->instance('db', $capsule);

// ------------------------------------------------------
// Register DB Facade (like Laravel does)
// ------------------------------------------------------
Facade::setFacadeApplication($container);

// Make the Capsule Manager act as the DB instance
$container->instance('db', $capsule->getDatabaseManager());

// Optionally register Facade alias (so DB::table() works)
class_alias(\Illuminate\Support\Facades\DB::class, 'DB');

// ------------------------------------------------------
// 3️⃣ Blade (View) Setup
// ------------------------------------------------------
$filesystem = new Filesystem;
$viewPaths = [__DIR__ . '/../views'];
$cachePath = __DIR__ . '/../storage/cache/views';

// Ensure the cache directory exists
if (!is_dir($cachePath)) {
    mkdir($cachePath, 0777, true);
}

$bladeCompiler = new BladeCompiler($filesystem, $cachePath);

$engineResolver = new EngineResolver;
$engineResolver->register('blade', fn() => new CompilerEngine($bladeCompiler));

$viewFinder = new FileViewFinder($filesystem, $viewPaths);

$viewFactory = new Factory($engineResolver, $viewFinder, $events);

// Bind Blade factory to the container (important!)
$container->instance('view', $viewFactory);

// ------------------------------------------------------
// 4️⃣ Load Routes
// ------------------------------------------------------
require __DIR__ . '/../routes/web.php';

// ------------------------------------------------------
// 5️⃣ Handle Request
// ------------------------------------------------------
$request = Request::capture();

try {
    $response = $router->dispatch($request);
} catch (NotFoundHttpException $e) {
    $response = '404 | Page Not Found';
} catch (HttpException $e) {
    $response = $e->getMessage() . $e->getStatusCode();
} catch (Throwable $e) {
    dump($e);
    $response = '500 | Internal Server Error: ' . $e->getMessage();
}

// ------------------------------------------------------
// 6️⃣ Send Response
// ------------------------------------------------------
if (is_string($response)) {
    echo $response;
} else {
    $response->send();
}
