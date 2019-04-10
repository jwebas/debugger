<?php declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Jwebas\Config\Config;
use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Profiler\Profile;

//Unset Slim phpErrorHandler and errorHandler
unset($container['phpErrorHandler'], $container['errorHandler']);

//Jwebas Config
$container['config'] = static function (): Config {
    $config = include __DIR__ . '/config.php';

    return new Config($config);
};

//Illuminate database
$container['database'] = static function (ContainerInterface $c): Capsule {
    $capsule = new Capsule;
    $capsule->addConnection($c->get('config')->get('settings.database'));
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    $capsule::connection()->enableQueryLog();

    return $capsule;
};
$capsule = $container['database'];

//Twig template engine
$container['twigProfile'] = static function () {
    return new Profile();
};

$container['twig'] = static function (ContainerInterface $c): Twig {

    $settings = $c->get('settings')['view'];

    $view = new Twig($settings['template_path'], $settings['twig']);

    $router = $c->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new TwigExtension($router, $uri));

    return $view;
};
