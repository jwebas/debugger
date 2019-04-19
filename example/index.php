<?php declare(strict_types=1);

use Jwebas\Debugger\Debugger;
use Slim\App;

/**
 * Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
require __DIR__ . '/../vendor/autoload.php';

//Define some constants
define('START', microtime(true));
define('MY_CONSTANT', 1);

//Enable debugger with/without settings
$config = include __DIR__ . '/config.php';
$config['settings']['debugger']['logDirectory'] = __DIR__ . '/logs';
Debugger::run($config['settings']['debugger']);

//Init Slim application
$app = new App($config);

// Set up dependencies
$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($app);

// Register routes
$routes = require __DIR__ . '/routes.php';
$routes($app);

// Register middlewares
$middleware = require __DIR__ . '/middlewares.php';
$middleware($app);

//Enable Debugger panels
//Debugger::renderPanels($container);

//Run Slim application
$app->run();
