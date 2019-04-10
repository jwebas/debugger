<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;
use Psr\Container\ContainerInterface;

class PsrContainerPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'psrContainer';

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
    public $panelTitle = 'Psr Container';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/psr_container/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/psr_container/panel.phtml';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return [
            'all' => $this->container,
        ];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return null !== $this->container && $this->container instanceof ContainerInterface;
    }
}
