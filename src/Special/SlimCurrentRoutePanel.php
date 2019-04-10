<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Special;


use Jwebas\Debugger\Support\SinglePanel;
use Slim\Route;

class SlimCurrentRoutePanel extends SinglePanel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'slimCurrentRoute';

    /**
     * Bar title
     *
     * @var string
     */
    public $barTitle = 'Route: ';

    /**
     * Panel title
     *
     * @var string
     */
    public $panelTitle = 'Route';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/slim_current_route/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/slim_current_route/panel.phtml';

    /**
     * @return string
     */
    public function getTabData(): string
    {
        /** @var Route|null $route */
        $route = $this->data;

        if (null === $route) {
            return 'not found';
        }

        return $route->getPattern();
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return class_exists(Route::class);
    }
}
