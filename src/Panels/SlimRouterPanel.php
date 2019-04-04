<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;
use Slim\Router;

class SlimRouterPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Slim Router';

    /**
     * @var string
     */
    protected $template = __DIR__ . '/templates/slim_router/';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Router $slimRouter */
        $slimRouter = $this->container->get($this->getContainerKey());

        return [
            'items'  => [
                'Base Path' => $slimRouter->getBasePath(),
            ],
            'routes' => $slimRouter->getRoutes(),
            'full'   => $slimRouter,
        ];
    }
}
