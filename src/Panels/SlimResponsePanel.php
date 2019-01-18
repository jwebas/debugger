<?php
declare(strict_types=1);


namespace Jwb\Panels;


use Jwb\DebuggerPanel;
use Slim\Http\Response;

class SlimResponsePanel extends DebuggerPanel
{
    /**
     * @var string
     */
    protected $title = 'Slim Http Response';

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
        /** @var Response $slimResponse */
        $slimResponse = $this->container->get('response');

        $items = [
            'status'          => $slimResponse->getStatusCode(),
            'reasonPhrase'    => $slimResponse->getReasonPhrase(),
            'protocolVersion' => $slimResponse->getProtocolVersion(),
            'headers'         => $slimResponse->getHeaders(),
            'body'            => $slimResponse->getBody(),
        ];

        $content = '<div class="tracy-inner">';
        $content .= $this->tableHeader(['Key', 'Value']);
        foreach ($items as $key => $item) {
            $content .= '<tr>';
            $content .= '<td>' . $key . '</td>';
            $content .= '<td>' . $this->toHtml($item) . '</td>';
            $content .= '</tr>';
        }
        $content .= $this->tableFooter();

        $content .= '<div style="margin-top: 10px;">';
        $content .= $this->toHtml($slimResponse);
        $content .= '</div>';

        $content .= '</div>';

        return '<h1>' . $this->getIcon() . ' ' . $this->title . '</h1>' . $content;
    }

    /**
     * @return string
     */
    protected function getIcon(): string
    {
        return '<svg enable-background="new 0 0 64 64" height="16px" version="1.1" viewBox="0 0 64 64" ' .
            'width="16px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><g id="Layer_1"><g><circle ' .
            'cx="32" cy="32" fill="#009900" r="32"/></g><g opacity="0.2"><path d="M47.839,30H40V18c0-2.209-1.' .
            '791-4-4-4h-8c-2.209,0-4,1.791-4,4v12h-7.839c-2.722,0-3.483,1.865-1.69,4.145    L28.741,52.29c1.' .
            '793,2.28,4.726,2.28,6.519,0l14.269-18.146C51.321,31.865,50.561,30,47.839,30z" fill="#231F20"/>' .
            '</g><g><path d="M24,16c0-2.209,1.791-4,4-4h8c2.209,0,4,1.791,4,4v24c0,2.209-1.791,4-4,4h-8c-2.209' .
            ',0-4-1.791-4-4V16z" fill="#FFFFFF"/></g><g><path d="M47.839,28c2.722,0,3.483,1.865,1.69,4.145L35.' .
            '259,50.29c-1.793,2.28-4.726,2.28-6.519,0L14.471,32.145    C12.679,29.865,13.439,28,16.161,28H47.' .
            '839z" fill="#FFFFFF"/></g></g><g id="Layer_2"/></svg>';
    }
}
