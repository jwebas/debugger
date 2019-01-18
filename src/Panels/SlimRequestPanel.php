<?php
declare(strict_types=1);


namespace Jwb\Panels;


use Jwb\DebuggerPanel;
use Slim\Http\Request;

class SlimRequestPanel extends DebuggerPanel
{
    /**
     * @var string
     */
    protected $title = 'Slim Http Request';

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
        /** @var Request $slimRequest */
        $slimRequest = $this->container->get('request');

        $items = [
            'method'          => $slimRequest->getMethod(),
            'originalMethod'  => $slimRequest->getOriginalMethod(),
            'uri'             => $slimRequest->getUri(),
            'requestTarget'   => $slimRequest->getRequestTarget(),
            'queryParams'     => $slimRequest->getQueryParams(),
            'cookies'         => $slimRequest->getCookieParams(),
            'serverParams'    => $slimRequest->getServerParams(),
            'attributes'      => $slimRequest->getAttributes(),
            'bodyParsed'      => $slimRequest->getParsedBody(),
            'uploadedFiles'   => $slimRequest->getUploadedFiles(),
            'protocolVersion' => $slimRequest->getProtocolVersion(),
            'headers'         => $slimRequest->getHeaders(),
            'body'            => $slimRequest->getBody(),
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

        $content .= '<div>';
        $content .= $this->toHtml($slimRequest);
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
            'width="16px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" ' .
            '><g><circle cx="32" cy="32" fill="#085aa3" r="32"/></g><g opacity="0.2"><path d="M49.529' .
            ',33.855L35.259,15.71c-1.793-2.28-4.726-2.28-6.519,0L14.471,33.855 C12.679,36.135,13.439,38,16.161,' .
            '38H24v12c0,2.209,1.791,4,4,4h8c2.209,0,4-1.791,4-4V38h7.839 C50.561,38,51.321,36.135,49.529,33.855z"' .
            ' fill="#231F20"/></g><g><path d="M40,48c0,2.209-1.791,4-4,4h-8c-2.209,0-4-1.791-4-4V24c0-2.209,1.791' .
            '-4,4-4h8c2.209,0,4,1.791,4,4V48z" fill="#FFFFFF"/></g><g><path d="M16.161,36c-2.722,0-3.483-1.865-1.' .
            '69-4.145L28.741,13.71c1.793-2.28,4.726-2.28,6.519,0l14.269,18.146    c1.793,2.28,1.032,4.145-1.69,4.' .
            '145H16.161z" fill="#FFFFFF"/></g></svg>';
    }
}
