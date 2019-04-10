<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;
use Slim\Http\Request;

class SlimRequestPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'slimRequest';

    /**
     * Bar title
     *
     * @var string
     */
    public $barTitle;

    /**
     * Panel title
     *
     * @var string
     */
    public $panelTitle = 'Request';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/slim_request/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/slim_request/panel.phtml';

    /**
     * @var string|array|null
     */
    protected $containerKey = 'request';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Request $slimRequest */
        $slimRequest = $this->container->get($this->containerKey);

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
     * @inheritDoc
     */
    public function valid(): bool
    {
        return null !== $this->container && class_exists(Request::class);
    }
}
