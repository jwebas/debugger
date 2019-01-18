<?php
declare(strict_types=1);


namespace Jwb\Panels;


use Jwb\Config;
use Jwb\DebuggerPanel;

class ConfigPanel extends DebuggerPanel
{
    /**
     * @var string
     */
    protected $title = 'Config';

    /**
     * @inheritdoc
     */
    public function getTab(): string
    {
        return '<span title="' . $this->title . '">' . $this->getIcon() . '</span>';
    }

    /**
     * Renders HTML code for custom panel.
     *
     * @return string
     */
    public function getPanel(): string
    {
        /** @var Config $config */
        $config = $this->container->get('config');

        $content = '<div class="tracy-inner">';
        $content .= $this->tableHeader(['Key', 'Values']);
        foreach ($config->all() as $key => $item) {
            $content .= '<tr>';
            $content .= '<td>' . $key . '</td>';
            $content .= '<td>' . $this->toHtml($item) . '</td>';
            $content .= '</tr>';
        }
        $content .= $this->tableFooter();
        $content .= '</div>';

        return '<h1>' . $this->getIcon() . ' ' . $this->title . '</h1>' . $content;
    }

    /**
     * @return string
     */
    protected function getIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="16px" height="16px" viewBox="0 0 16 16">
                <path fill="#444444" d="M2.1 3.1c0.2 1.3 0.4 1.6 0.4 2.9 0 0.8-1.5 1.5-1.5 1.5v1c0 0 1.5 0.7 1.5 1.5 0 1.3-0.2 1.6-0.4 2.9-0.3 2.1 0.8 3.1 1.8 3.1s2.1 0 2.1 0v-2c0 0-1.8 0.2-1.8-1 0-0.9 0.2-0.9 0.4-2.9 0.1-0.9-0.5-1.6-1.1-2.1 0.6-0.5 1.2-1.1 1.1-2-0.3-2-0.4-2-0.4-2.9 0-1.2 1.8-1.1 1.8-1.1v-2c0 0-1 0-2.1 0s-2.1 1-1.8 3.1z"/>
                <path fill="#444444" d="M13.9 3.1c-0.2 1.3-0.4 1.6-0.4 2.9 0 0.8 1.5 1.5 1.5 1.5v1c0 0-1.5 0.7-1.5 1.5 0 1.3 0.2 1.6 0.4 2.9 0.3 2.1-0.8 3.1-1.8 3.1s-2.1 0-2.1 0v-2c0 0 1.8 0.2 1.8-1 0-0.9-0.2-0.9-0.4-2.9-0.1-0.9 0.5-1.6 1.1-2.1-0.6-0.5-1.2-1.1-1.1-2 0.2-2 0.4-2 0.4-2.9 0-1.2-1.8-1.1-1.8-1.1v-2c0 0 1 0 2.1 0s2.1 1 1.8 3.1z"/>
            </svg>';
    }
}
