<?php declare(strict_types=1);


namespace Jwebas\Debugger\Middlewares;


use Jwebas\Debugger\Debugger;
use Jwebas\Debugger\Special\SlimCurrentRoutePanel;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class DebuggerSlimMiddleware
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * DebuggerSlimMiddleware constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $resp = $next($request, $response);

        //Get current route
        $currentRoute = $request->getAttribute('route');

        //Add current route panel
        $slimCurrentRoutePanel = new SlimCurrentRoutePanel($currentRoute);
        Debugger::addPanel($slimCurrentRoutePanel, $slimCurrentRoutePanel->getId());

        //Enable debugger panels
        Debugger::renderPanels($this->container);

        return $resp;
    }
}
