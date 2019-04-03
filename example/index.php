<?php declare(strict_types=1);

use Jwebas\Debugger\Debugger;
use Slim\App;

/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
require __DIR__ . '/../vendor/autoload.php';

/**
 * Step 2: Enable debugger with/without settings
 */

$config = include __DIR__ . '/config.php';
$config['settings']['debugger']['logDirectory'] = __DIR__ . '/logs';
Debugger::run($config['settings']['debugger']);

/**
 * Step 3: Init Slim application
 */

$app = new App($config);

/**
 * Step 4: Get container from Slim application
 */

$container = $app->getContainer();

/**
 * Step 5: Unset Slim phpErrorHandler and
 */

unset($container['phpErrorHandler'], $container['errorHandler']);

/**
 * Step 6 (optional): Add container dependencies
 */

require __DIR__ . '/dependencies.php';

/**
 * Step 7: Enable Debugger panels
 */

Debugger::addPanels($config['settings']['debugger']['panels'], $container);

/**
 * Step 8: Run Slim application
 */

$app->run();
