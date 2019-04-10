<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Support;


abstract class SinglePanel extends BasePanel implements SinglePanelInterface
{
    /**
     * @var mixed|null
     */
    protected $data;

    /**
     * Panel constructor.
     *
     * @param mixed|null $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
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


        $title = $this->getIcon() . ' ' . $this->panelTitle;
        $className = '';
        if ($this->id) {
            $className = 'tracy-' . $this->id;
        }

        $t = '<h1>' . trim($title) . '</h1>';
        $t .= '<div class="tracy-inner ' . $className . '">';
        $t .= '<div class="tracy-inner-container">';

        ob_start();
        /** @noinspection PhpUnusedLocalVariableInspection */
        $data = $this->getData();

        /** @noinspection PhpIncludeInspection */
        require $this->panelTemplate;

        $t .= ob_get_clean();

        $t .= '</div>';
        $t .= '</div>';

        return $t;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return $this->data;
    }
}
