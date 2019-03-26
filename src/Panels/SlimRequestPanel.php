<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;
use Slim\Http\Request;

class SlimRequestPanel extends AbstractPanel
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
        ob_start();
        if (class_exists(Request::class)) {
            require __DIR__ . '/templates/slim_request.panel.phtml';
        } else {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $msg = 'Class Slim\Http\Request not found';
            require __DIR__ . '/templates/not_found.panel.phtml';
        }

        return ob_get_clean();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        /** @var Request $slimRequest */
        $slimRequest = $this->container->get('request');

        return [
            'items' => [
                'Method'            => $slimRequest->getMethod(),
                'Original Method'   => $slimRequest->getOriginalMethod(),
                'Is Xhr (Ajax)'     => $slimRequest->isXhr(),
                'Request Target'    => $slimRequest->getRequestTarget(),
                'Uri'               => $slimRequest->getUri(),
                'Content Type'      => $slimRequest->getContentType(),
                'Media Type'        => $slimRequest->getMediaType(),
                'Media Type Params' => $slimRequest->getMediaTypeParams(),
                'Content Charset'   => $slimRequest->getContentCharset(),
                'Content Length'    => $slimRequest->getContentLength(),
                'Cookie Params'     => $slimRequest->getCookieParams(),
                'Query Params'      => $slimRequest->getQueryParams(),
                'Uploaded Files'    => $slimRequest->getUploadedFiles(),
                'Server Params'     => $slimRequest->getServerParams(),
                'Attributes'        => $slimRequest->getAttributes(),
                'Parsed Body'       => $slimRequest->getParsedBody(),
                'Protocol Version'  => $slimRequest->getProtocolVersion(),
                'Headers'           => $slimRequest->getHeaders(),
                'Body'              => $slimRequest->getBody(),
            ],
            'full'  => $slimRequest,
        ];
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
