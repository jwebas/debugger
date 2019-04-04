<?php /** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpIncludeInspection */
declare(strict_types=1);


namespace Jwebas\Debugger\Panels\Abstracts;


use Psr\Container\ContainerInterface;
use Tracy\Dumper;
use Tracy\IBarPanel;

abstract class AbstractPanel implements IBarPanel, PanelInterface
{
    /**
     * @var ContainerInterface|null
     */
    protected $container;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $template = '';

    /**
     * AbstractPanel constructor.
     *
     * @param ContainerInterface|null $container
     * @param array                   $params
     */
    public function __construct($container = null, array $params = [])
    {
        $this->container = $container;
        $this->params = $params;
    }

    /**
     * Renders HTML code for custom tab.
     *
     * @return string
     */
    public function getTab(): string
    {
        $icon = $this->getIcon();
        $barTitle = $this->getBarTitle($icon);

        if (method_exists($this, 'getTabData')) {
            $barTitle .= ' ' . $this->getTabData();
        }

        return '<span title="' . $this->getTitle() . '">' . trim($barTitle) . '</span>';
    }

    /**
     * Renders HTML code for custom panel.
     *
     * @return string
     */
    public function getPanel(): string
    {
        if (!$this->template) {
            return '';
        }

        ob_start();

        $icon = $this->getIcon();
        $panelTitle = $this->getPanelTitle($icon);
        $data = $this->getData();

        require $this->template . 'panel.phtml';

        return ob_get_clean();
    }

    /**
     * @param mixed $item
     * @param int   $truncate
     * @param bool  $location
     *
     * @return string
     */
    public function toHtml($item, $truncate = 100, $location = false): string
    {
        $options = [
            'truncate' => $truncate,
            'location' => $location,
        ];

        return Dumper::toHtml($item, $options);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->params['title'] ?? $this->title;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        $icon = '';

        if (file_exists($iconTemplate = $this->template . 'icon.phtml')) {
            ob_start();
            require $iconTemplate;

            return ob_get_clean();
        }

        return $icon;
    }

    /**
     * @param string $icon
     *
     * @return string
     */
    public function getBarTitle($icon = ''): string
    {
        $show_title = $this->params['show_title'] ?? true;

        $barTitle = $icon;

        if ($show_title) {
            $barTitle .= ' ' . $this->getTitle();
        }

        return trim($barTitle);
    }

    /**
     * @param string $icon
     *
     * @return string
     */
    public function getPanelTitle($icon = ''): string
    {
        return trim($icon . ' ' . $this->getTitle());
    }

    /**
     * @return string|array
     */
    public function getContainerKey()
    {
        return $this->params['containerKey'] ?? '';
    }
}
