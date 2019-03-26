<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */
declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | @var bool
    |
    */

    'debug' => false,

    /*
    |--------------------------------------------------------------------------
    | Allowed IP addresses
    |--------------------------------------------------------------------------
    |
    | Allowed IP address to enable debugger
    | localhost === 127.0.0.1 or ::1
    |
    | @var array
    |
    */

    'ip_addresses' => [
        'localhost',
    ],

    /*
    |--------------------------------------------------------------------------
    | Show debug bar
    |--------------------------------------------------------------------------
    |
    | Whether to display debug bar in development mode
    |
    | @var bool
    |
    */

    'showBar' => true,

    /********************* errors and exceptions reporting *******************/

    /*
    |--------------------------------------------------------------------------
    | FireLogger
    |--------------------------------------------------------------------------
    |
    | Whether to send data to FireLogger in development mode
    |
    | @var bool
    |
    */

    'showFireLogger' => false,

    /********************* errors and exceptions reporting *******************/

    /*
    |--------------------------------------------------------------------------
    | Strict mode
    |--------------------------------------------------------------------------
    |
    | Determines whether any error will cause immediate death in development mode;
    | if integer that it's matched against error severity
    |
    | @var bool|int
    |
    */

    'strictMode' => true,

    /*
    |--------------------------------------------------------------------------
    | @ (shut-up) operator
    |--------------------------------------------------------------------------
    |
    | Disables the @ (shut-up) operator so that notices and warnings are no longer hidden
    |
    | @var bool
    |
    */

    'scream' => false,

    /********************* Debugger::dump() *******************/

    /*
    |--------------------------------------------------------------------------
    | Dump level
    |--------------------------------------------------------------------------
    |
    | How many nested levels of array/object properties display by dump()
    |
    | @var int
    |
    */

    'maxDepth' => 10,

    /*
    |--------------------------------------------------------------------------
    | String length
    |--------------------------------------------------------------------------
    |
    | How long strings display by dump()
    |
    | @var int
    |
    */

    'maxLength' => 250,

    /*
    |--------------------------------------------------------------------------
    | Location
    |--------------------------------------------------------------------------
    |
    | Display location by dump()?
    |
    | @var bool
    |
    */

    'showLocation' => true,

    /********************* logging *******************/

    /*
    |--------------------------------------------------------------------------
    | Log directory
    |--------------------------------------------------------------------------
    |
    | Name of the directory where errors should be logged
    |
    | @var string|null
    |
    */

    'logDirectory' => null,

    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    |
    | Email(s) to which send error notifications
    |
    | @var string|array|null
    |
    */

    'email' => null,

    /********************* misc *******************/

    /*
    |--------------------------------------------------------------------------
    | Custom static error template
    |--------------------------------------------------------------------------
    |
    | @var string
    |
    */

    'errorTemplate' => '',

    /*
    |--------------------------------------------------------------------------
    | Custom css files
    |--------------------------------------------------------------------------
    |
    | @var array
    |
    */

    'customCssFiles' => [
        __DIR__ . '/../resources/css/tracy.css',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom js files
    |--------------------------------------------------------------------------
    |
    | @var array
    |
    */

    'customJsFiles' => [],

    /*
    |--------------------------------------------------------------------------
    | Debugger panels
    |--------------------------------------------------------------------------
    |
    | @var array
    |
    */

    'panels' => [

        'jwebasConfig' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\ConfigPanel::class,
            'title'   => 'Config',
        ],

        'container' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\ContainerPanel::class,
            'title'   => 'Container',
        ],

        'eloquentOrm' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\EloquentOrmPanel::class,
            'title'   => 'Eloquent ORM (database)',
        ],

        'slimRouter' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\SlimRouterPanel::class,
            'title'   => 'Slim Router',
        ],

        'slimRequest' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\SlimRequestPanel::class,
            'title'   => 'Slim Http Request',
        ],

        'slimResponse' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\SlimResponsePanel::class,
            'title'   => 'Slim Http Response',
        ],

        'slimEnvironment' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\SlimEnvironmentPanel::class,
            'title'   => 'Slim Http Environment',
        ],

        'twig' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\TwigPanel::class,
            'title'   => 'Twig Templates Engine',
        ],

        'phpSession' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\PhpSessionPanel::class,
            'title'   => 'PHP Session',
        ],

        'phpInfo' => [
            'enabled' => true,
            'class'   => \Jwebas\Debugger\Panels\PhpInfoPanel::class,
            'title'   => 'Php Info',
        ],
    ],
];
