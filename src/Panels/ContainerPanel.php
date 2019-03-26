<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class ContainerPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Container';

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
        if (null !== $this->container) {
            require __DIR__ . '/templates/container.panel.phtml';
        } else {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $msg = 'Container not defined';
            require __DIR__ . '/templates/not_found.panel.phtml';
        }

        return ob_get_clean();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'full' => $this->container,
        ];
    }

    /**
     * @return string
     */
    protected function getIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" ' .
            'viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="24px" ' .
            'height="24px"><path d="M446.537,188.13h-37.026l-101.798-70.979c7.453-27.802-7.912-55.925-33.853-65.' .
            '226V17.86C273.86,7.997,265.864,0,256,0    c-9.864,0-17.86,7.997-17.86,17.86v34.065c-25.961,9.309-41.' .
            '301,37.449-33.853,65.228L102.489,188.13H65.463    c-22.966,0-41.649,18.683-41.649,41.649v240.57c0,22.' .
            '967,18.683,41.651,41.649,41.651h381.072    c22.967,0,41.651-18.683,41.651-41.649V229.78C488.186,206.' .
            '813,469.503,188.13,446.537,188.13z M160.744,400.074    c0,9.864-7.997,17.86-17.86,17.86c-9.864,0-17.' .
            '86-7.997-17.86-17.86V300.056c0-9.864,7.997-17.86,17.86-17.86    c9.864,0,17.86,7.997,17.86,17.86V400.' .
            '074z M273.86,400.074c0,9.864-7.997,17.86-17.86,17.86c-9.864,0-17.86-7.997-17.86-17.86 V300.056c0-9.' .
            '864,7.997-17.86,17.86-17.86c9.864,0,17.86,7.997,17.86,17.86V400.074z M164.945,188.13l59.43-41.438' .
            ' c18.602,13.801,44.186,14.144,63.25,0l59.43,41.438H164.945z M386.977,400.074c0,9.864-7.997,17.86-17.' .
            '86,17.86 c-9.864,0-17.86-7.997-17.86-17.86V300.056c0-9.864,7.997-17.86,17.86-17.86c9.864,0,17.86,7.' .
            '997,17.86,17.86V400.074z" fill="#006DF0"/></svg>';
    }
}
