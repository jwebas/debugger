<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Config\Config;
use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class ConfigPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Config';

    /**
     * Renders HTML code for custom tab.
     *
     * @return string
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
        ob_start();
        if (class_exists(Config::class)) {
            require __DIR__ . '/templates/config.panel.phtml';
        } else {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $msg = 'Class Jwebas\Config\Config not found';
            require __DIR__ . '/templates/not_found.panel.phtml';
        }

        return ob_get_clean();
    }

    /**
     * @return array
     */
    protected function getData(): array
    {
        $config = $this->container->get('config');

        return $config->all();
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
