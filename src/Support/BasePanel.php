<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Support;


use Tracy\Dumper;
use Tracy\IBarPanel;

abstract class BasePanel implements IBarPanel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id;

    /**
     * Bar title
     *
     * @var string
     */
    public $barTitle = '';

    /**
     * Panel title
     *
     * @var string
     */
    public $panelTitle = '';

    /**
     * @var string|null
     */
    public $iconTemplate;

    /**
     * @var string|null
     */
    public $panelTemplate;

    /**
     * Get panel ID
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Renders HTML code for custom tab.
     *
     * @return string
     */
    public function getTab(): string
    {
        $barTitle = trim($this->getIcon() . ' ' . $this->barTitle);
        if (method_exists($this, 'getTabData')) {
            $barTitle .= ' ' . $this->getTabData();
        }

        return '<span title="' . $this->panelTitle . '">' . trim($barTitle) . '</span>';
    }

    /**
     * @inheritDoc
     */
    public function getIcon(): string
    {
        if (null === $this->iconTemplate) {
            return '';
        }

        ob_start();
        /** @noinspection PhpIncludeInspection */
        require $this->iconTemplate;

        return ob_get_clean();
    }

    /**
     * Dumps variable to HTML.
     *
     * @param mixed $item
     * @param int   $truncate
     * @param bool  $location
     *
     * @return string
     */
    public function toHtml($item, $truncate = 100, $location = false): string
    {
        $options = [
            Dumper::TRUNCATE => $truncate,
            Dumper::LOCATION => $location,
        ];

        return Dumper::toHtml($item, $options);
    }
}
