<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Http\Environment;

class SlimEnvironmentPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'slimEnvironment';

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
    public $panelTitle = 'Environment';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/slim_environment/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/slim_environment/panel.phtml';

    /**
     * @var string|array|null
     */
    protected $containerKey = 'environment';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return [
            'all' => $this->container->get($this->containerKey),
        ];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        if (null === $this->container || !class_exists(Environment::class)) {
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
