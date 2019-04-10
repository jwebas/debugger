<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Support;


use Jwebas\Debugger\Debugger;
use Psr\Container\ContainerInterface;

abstract class Bundle extends BasePanel implements BundleInterface
{
    /**
     * @var ContainerInterface|null
     */
    protected $container;

    /**
     * @var array
     */
    protected $panels = [];

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
     * @inheritDoc
     */
    public function getTab(): string
    {
        if (!$this->valid()) {
            return '';
        }

        return parent::getTab();
    }

    /**
     * @inheritDoc
     */
    public function getPanel(): string
    {
        if (!$this->valid()) {
            return '';
        }

        $checked = false;
        $title = $this->getIcon() . ' ' . $this->panelTitle;
        $className = '';
        if ($this->id) {
            $className = 'tracy-' . $this->id;
        }

        $t = '<h1>' . trim($title) . '</h1>';
        $t .= '<div class="tracy-inner ' . $className . '">';
        $t .= '<div class="tracy-inner-container">';

        $t .= '<section id="tracy-tabs">';
        foreach ($this->panels as $key => $panel) {
            $p = Debugger::resolvePanel($panel, $this->container);

            if ($p->valid()) {
                $t .= '<input id="tab-' . $p->id . '" type="radio" name="' . $this->id . '" ' . (!$checked ? 'checked="checked"' : '') . '>';
                $t .= '<label for="tab-' . $p->id . '">' . $p->getIcon() . ' ' . $p->panelTitle . '</label>';
                $t .= '<div class="panel-content">' . $p->getContent() . '</div>';

                $checked = true;
            }
        }
        $t .= '</section>';

        $t .= '</div>';
        $t .= '</div>';

        return $t;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        foreach ($this->panels as $panel) {
            /** @var Panel $p */
            $p = Debugger::resolvePanel($panel, $this->container);

            if ($p->valid()) {
                return true;
            }
        }

        return false;
    }
}
