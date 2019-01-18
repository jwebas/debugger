<?php
declare(strict_types=1);


namespace Jwb\Panels;


use Jwb\DebuggerPanel;

class PhpSessionPanel extends DebuggerPanel
{
    /**
     * @var string
     */
    protected $title = 'PHP Session';

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
        $content = '<div class="tracy-inner">';
        if (count($_SESSION)) {
            $content .= $this->tableHeader(['Key', 'Value']);
            foreach ($_SESSION as $key => $item) {
                $content .= '<tr>';
                $content .= '<td>' . $key . '</td>';
                $content .= '<td>' . $this->toHtml($item) . '</td>';
                $content .= '</tr>';
            }
            $content .= $this->tableFooter();
        }

        $content .= '<div style="margin-top: 10px;">';
        $content .= $this->toHtml($_SESSION);
        $content .= '</div>';

        $content .= '</div>';

        return '<h1>' . $this->getIcon() . ' ' . $this->title . '</h1>' . $content;
    }

    /**
     * @return string
     */
    protected function getIcon(): string
    {
        return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px"
                 width="16px" height="16px" viewBox="212.8 211.3 16 16" enable-background="new 212.8 211.3 16 16" xml:space="preserve">
            <g>
                <path d="M225.6,216c-0.1-0.3-0.3-0.6-0.5-0.8l-3.2-3.3c-0.2-0.2-0.4-0.4-0.8-0.5c-0.3-0.1-0.6-0.2-0.9-0.2h-6.5
                    c-0.3,0-0.5,0.1-0.7,0.3c-0.2,0.2-0.3,0.4-0.3,0.7v14c0,0.3,0.1,0.5,0.3,0.7c0.2,0.2,0.4,0.3,0.7,0.3h11.1c0.3,0,0.5-0.1,0.7-0.3
                    c0.2-0.2,0.3-0.4,0.3-0.7v-9.3C225.8,216.7,225.7,216.4,225.6,216z M220.6,212.7c0.2,0.1,0.3,0.1,0.4,0.2l3.2,3.3
                    c0.1,0.1,0.2,0.2,0.2,0.4h-3.8V212.7z M224.5,225.9h-10.4v-13.3h5.2v4.3c0,0.3,0.1,0.5,0.3,0.7c0.2,0.2,0.4,0.3,0.7,0.3h4.2V225.9z" fill="#231F20"/>
                <path d="M222.8,221.9h-7.2c-0.1,0-0.2,0-0.2,0.1c-0.1,0.1-0.1,0.1-0.1,0.2v0.7c0,0.1,0,0.2,0.1,0.2c0.1,0.1,0.1,0.1,0.2,0.1h7.2
                    c0.1,0,0.2,0,0.2-0.1c0.1-0.1,0.1-0.1,0.1-0.2v-0.7c0-0.1,0-0.2-0.1-0.2C223,222,222.9,221.9,222.8,221.9z" fill="#231F20"/>
                <path d="M215.5,219.4c-0.1,0.1-0.1,0.1-0.1,0.2v0.7c0,0.1,0,0.2,0.1,0.2c0.1,0.1,0.1,0.1,0.2,0.1h7.2c0.1,0,0.2,0,0.2-0.1
                    c0.1-0.1,0.1-0.1,0.1-0.2v-0.7c0-0.1,0-0.2-0.1-0.2c-0.1-0.1-0.1-0.1-0.2-0.1h-7.2C215.6,219.3,215.5,219.3,215.5,219.4z" fill="#231F20"/>
            </g>
            </svg>';
    }
}
