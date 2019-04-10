<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */
declare(strict_types=1);

return [
    'settings' => [
        'displayErrorDetails'               => true,
        'determineRouteBeforeAppMiddleware' => true,
        'addContentLengthHeader'            => false,// if true = Unexpected data in output buffer
        'routerCacheFile'                   => false,

        'database' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'db_name',
            'username'  => 'db_username',
            'password'  => 'db_password',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => '',
        ],

        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig'          => [
                'cache' => false, //'path/to/cache',
                'debug' => true,
            ],
        ],

        'debugger' => [
            'debug'        => true,
            'logDirectory' => __DIR__ . '/logs',
            'panels'       => [
                \Jwebas\Debugger\Panels\JwebasConfigPanel::class,
                \Jwebas\Debugger\Panels\PsrContainerPanel::class,
                \Jwebas\Debugger\Panels\EloquentOrmPanel::class,
                \Jwebas\Debugger\Bundles\PhpBundle::class,
                \Jwebas\Debugger\Bundles\SlimFrameworkBundle::class,
                \Jwebas\Debugger\Bundles\SymfonyFrameworkBundle::class,
            ],
        ],
    ],
];
