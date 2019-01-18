<?php
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

    'debug' => true,

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
    | Custom css files
    |--------------------------------------------------------------------------
    |
    | @var array
    |
    */

    'customCssFiles' => [],

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

        // Panels that requires Psr\Container\ContainerInterface
        'container'     => [
            'config' => [
                'enabled' => true,
                'title'   => 'Config',
            ],
            
            'eloquentOrm' => [
                'enabled' => true,
                'title'   => 'Eloquent ORM (database)',
            ],

            'slimContainer' => [
                'enabled' => true,
                'title'   => 'Slim Container',
            ],

            'slimEnvironment' => [
                'enabled' => true,
                'title'   => 'Slim Http Environment',
            ],

            'slimRequest' => [
                'enabled' => true,
                'title'   => 'Slim Http Request',
            ],

            'slimResponse' => [
                'enabled' => true,
                'title'   => 'Slim Http Response',
            ],

            'slimRouter' => [
                'enabled' => true,
                'title'   => 'Slim Router',
            ],

            'twig' => [
                'enabled' => true,
                'title'   => 'Twig',
            ],
        ],

        // Panels that NOT requires Psr\Container\ContainerInterface
        'non_container' => [
            'phpInfo' => [
                'enabled' => true,
                'title'   => 'Php Info',
            ],

            'phpSession' => [
                'enabled' => true,
                'title'   => 'PHP Session',
            ],
        ],
    ],
];
