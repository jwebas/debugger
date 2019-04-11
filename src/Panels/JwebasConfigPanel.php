<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Config\Config;
use Jwebas\Debugger\Support\Panel;
use Psr\Container\NotFoundExceptionInterface;

class JwebasConfigPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'jwebasConfig';

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
    public $panelTitle = 'Config';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/jwebas_config/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/jwebas_config/panel.phtml';

    /**
     * @var string|array|null
     */
    protected $containerKey = 'config';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Config $config */
        $config = $this->container->get($this->containerKey);

        return $config->all();
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        if (null === $this->container || !class_exists(Config::class)) {
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
