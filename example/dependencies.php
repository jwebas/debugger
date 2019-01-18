<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

// Config

$container['config'] = function () {
    $configLoader = new \Jwb\ConfigLoader();

    return $configLoader->load(__DIR__ . '/../config');
};

// Illuminate database

$container['database'] = function (ContainerInterface $c) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($c->get('settings')['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    $capsule::connection()->enableQueryLog();

    return $capsule;
};
$capsule = $container['database'];

// Twig template engine

$container['twigProfile'] = function () {
    return new Twig_Profiler_Profile();
};

$container['view'] = function (ContainerInterface $c) {

    $settings = $c->get('settings')['view'];

    $view = new \Slim\Views\Twig($settings['template_path'], $settings['twig']);

    $router = $c->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};
