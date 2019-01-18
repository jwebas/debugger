<?php
declare(strict_types=1);


namespace Jwb;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DebuggerMiddleware
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * DebuggerMiddleware constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param callable          $next
     *
     * @return mixed
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, $next)
    {
        $response = $next($request, $response);

        $settings = $this->container->get('settings')['debugger'];
        Debugger::addPanels($settings, $this->container);

        return $response;
    }
}
