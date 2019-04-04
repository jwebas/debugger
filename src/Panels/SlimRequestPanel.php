<?php declare(strict_types=1);


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
     * @var string
     */
    protected $template = __DIR__ . '/templates/slim_request/';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Request $slimRequest */
        $slimRequest = $this->container->get($this->getContainerKey());

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
}
