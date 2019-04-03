<?php declare(strict_types=1);

namespace PHPSTORM_META {

    override(\Psr\Container\ContainerInterface::get('0'), map([
        '' => '@',

        'config'      => \Jwebas\Config\Config::class,
        'database'    => \Illuminate\Database\Capsule\Manager::class,
        'twig'        => \Slim\Views\Twig::class,
        'twigProfile' => \Twig\Profiler\Profile::class,
    ]));
}
