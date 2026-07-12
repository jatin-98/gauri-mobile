<?php

namespace App\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;

class DatabaseManager
{
    /**
     * Boot the Eloquent Capsule and register database facades in the container.
     */
    public static function boot(Container $app): void
    {
        $config = require __DIR__ . '/../../config/database.php';
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

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // Bind DB into the container
        $app->instance('db', $capsule->getDatabaseManager());

        // Alias \Illuminate\Support\Facades\DB to 'DB' (if not already aliased by composer)
        if (!class_exists('DB', false)) {
            class_alias(\Illuminate\Support\Facades\DB::class, 'DB');
        }
    }
}
