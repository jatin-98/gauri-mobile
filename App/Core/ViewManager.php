<?php

namespace App\Core;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

class ViewManager
{
    /**
     * Boot the Blade view engine and bind it into the application container.
     */
    public static function boot(Application $app, string $viewPath, string $cachePath): void
    {
        $filesystem = new Filesystem;
        
        // Ensure the cache directory exists
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0777, true);
        }

        $bladeCompiler = new BladeCompiler($filesystem, $cachePath);

        $engineResolver = new EngineResolver;
        $engineResolver->register('blade', fn() => new CompilerEngine($bladeCompiler));

        $viewFinder = new FileViewFinder($filesystem, [$viewPath]);

        $viewFactory = new Factory($engineResolver, $viewFinder, $app->events);

        // Bind Blade factory to the container (important!)
        $app->instance('view', $viewFactory);
    }
}
