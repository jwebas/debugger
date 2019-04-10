<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Support;


use Psr\Container\ContainerInterface;

abstract class Panel extends BasePanel implements PanelInterface
{
    /**
     * @var ContainerInterface|null
     */
    protected $container;

    /**
     * @var string|array|null
     */
    protected $containerKey;

    /**
     * Panel constructor.
     *
     * @param ContainerInterface|null $container
     */
    public function __construct($container = null)
    {
        $this->container = $container;
    }

    /**
     * Set container key
     *
     * @param string|array $key
     */
    public function setContainerKey($key)
    {
        $this->containerKey = $key;
    }

    /**
     * @inheritDoc
     */
    public function getPanel(): string
    {
        $title = $this->getIcon() . ' ' . $this->panelTitle;
        $className = '';
        if ($this->id) {
            $className = 'tracy-' . $this->id;
        }

        $t = '<h1>' . trim($title) . '</h1>';
        $t .= '<div class="tracy-inner ' . $className . '">';
        $t .= '<div class="tracy-inner-container">';
        $t .= $this->getContent();
        $t .= '</div>';
        $t .= '</div>';

        return $t;
    }

    /**
     * @inheritDoc
     */
    public function getContent(): string
    {
        ob_start();

        /** @noinspection PhpUnusedLocalVariableInspection */
        $data = $this->getData();

        /** @noinspection PhpIncludeInspection */
        require $this->panelTemplate;

        return ob_get_clean();
    }
}
