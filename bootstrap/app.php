<?php

use App\Core\Application;
use App\Core\Environment;
use App\Core\ViewManager;
use App\Database\DatabaseManager;

// Load custom helpers FIRST so they override Illuminate's default helpers (like env)
require __DIR__ . '/../app/Helpers/functions.php';

require __DIR__ . '/../vendor/autoload.php';

// ------------------------------------------------------
// Load Environment Variables
// ------------------------------------------------------
Environment::load(__DIR__ . '/../.env');

// ------------------------------------------------------
// Initialize Application Container
// ------------------------------------------------------
$app = new Application();

// ------------------------------------------------------
// Boot Services
// ------------------------------------------------------
DatabaseManager::boot($app);

ViewManager::boot(
    $app, 
    __DIR__ . '/../resources/views', 
    __DIR__ . '/../storage/cache/views'
);

// ------------------------------------------------------
// Load Routes
// ------------------------------------------------------
require __DIR__ . '/../routes/web.php';

// Return the application instance to the caller (e.g., index.php)
return $app;
