<?php declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Jwebas\Config\Config;
use Jwebas\Config\Loaders\DirectoryLoader;
use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Profiler\Profile;

// Config
$container['config'] = static function (): Config {
    $configLoader = new DirectoryLoader();

    return $configLoader->load(__DIR__, 'config.php');
};

// Illuminate database
$container['db'] = static function (ContainerInterface $c): Capsule {
    $capsule = new Capsule;
    $capsule->addConnection($c->get('settings')['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    $capsule::connection()->enableQueryLog();

    return $capsule;
};
$capsule = $container['db'];

// Twig template engine
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
