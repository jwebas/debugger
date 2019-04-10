# Jwebas Debugger

## Custom Tracy Debugger Bar

### Requirements
Debugger requires PHP 7.1.3+.

### Panels
* EloquentOrmPanel - Illuminate Database (Laravel) (https://github.com/illuminate/database)
* JwebasConfigPanel - Jwebas Config (https://github.com/jwebas/config)
* PhpDefinesPanel - PHP defined values
* PhpInfoPanel - phpinfo()
* PhpSessionPanel - PHP native  session
* PsrContainerPanel - Container that implements ContainerInterface (https://github.com/php-fig/container)
* SlimEnvironmentPanel - Slim Framework Http Environment (https://github.com/slimphp/Slim)
* SlimRequestPanel - Slim Framework Http Request (https://github.com/slimphp/Slim)
* SlimResponsePanel - Slim Framework Http Response (https://github.com/slimphp/Slim)
* SlimRouterPanel - Slim Framework Router (https://github.com/slimphp/Slim)
* SlimTwigPanel - Slim Framework Twig View (https://github.com/slimphp/Twig-View)

### Bundles
* PhpBundle
    * PhpSessionPanel
    * PhpDefinesPanel
    * PhpInfoPanel
* SlimFrameworkBundle
    * SlimEnvironmentPanel
    * SlimRequestPanel
    * SlimResponsePanel
    * SlimRouterPanel
    * SlimTwigPanel

### Special
* SlimCurrentRoutePanel - Slim Framework Current route panel (added with DebuggerSlimMiddleware)

### Usage
Please see [example/index.php](example/index.php) for details.
Please see [config/debugger.php](config/debugger.php) for config.

#### Links
* Tracy PHP debugger - https://github.com/nette/tracy

### License
The MIT License (MIT).
