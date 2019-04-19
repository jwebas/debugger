<?php declare(strict_types=1);

use Slim\App;

return static function (App $app) {
    $app->add(new \Jwebas\Debugger\Middlewares\DebuggerSlimMiddleware($app->getContainer()));
};
