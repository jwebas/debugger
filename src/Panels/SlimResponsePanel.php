<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;
use Slim\Http\Response;

class SlimResponsePanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'slimResponse';

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
    public $panelTitle = 'Response';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/slim_response/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/slim_response/panel.phtml';

    /**
     * @var string|array|null
     */
    protected $containerKey = 'response';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Response $slimResponse */
        $slimResponse = $this->container->get($this->containerKey);

        return [
            'items' => [
                'Status Code'      => $slimResponse->getStatusCode(),
                'Reason Phrase'    => $slimResponse->getReasonPhrase(),
                'Status'           => [
                    'Is Empty'         => $slimResponse->isEmpty(),
                    'Is Informational' => $slimResponse->isInformational(),
                    'Is OK'            => $slimResponse->isOk(),
                    'Is Successful'    => $slimResponse->isSuccessful(),
                    'Is Redirect'      => $slimResponse->isRedirect(),
                    'Is Redirection'   => $slimResponse->isRedirection(),
                    'Is Forbidden'     => $slimResponse->isForbidden(),
                    'Is NotFound'      => $slimResponse->isNotFound(),
                    'Is Client Error'  => $slimResponse->isClientError(),
                    'Is Server Error'  => $slimResponse->isServerError(),
                ],
                'Protocol Version' => $slimResponse->getProtocolVersion(),
                'Headers'          => $slimResponse->getHeaders(),
                'Body'             => $slimResponse->getBody(),
            ],
            'full'  => $slimResponse,
        ];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return null !== $this->container && class_exists(Response::class);
    }
}
