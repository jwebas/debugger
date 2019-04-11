<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Router;

class SlimRouterPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'slimRouter';

    /**
     * Bar title
     *
     * @var string
     */
    public $barTitle;

    /**
     * Panel title
     *
     * @var string
     */
    public $panelTitle = 'Router';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/slim_router/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/slim_router/panel.phtml';

    /**
     * @var string|array|null
     */
    protected $containerKey = 'router';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Router $slimRouter */
        $slimRouter = $this->container->get($this->containerKey);

        return [
            'items'  => [
                'Base Path' => $slimRouter->getBasePath(),
            ],
            'routes' => $slimRouter->getRoutes(),
            'full'   => $slimRouter,
        ];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        if (null === $this->container || !class_exists(Router::class)) {
            return false;
        }

        try {
            $this->container->get($this->containerKey);
        } catch (NotFoundExceptionInterface $e) {
            return false;
        }

        return true;
    }
}
