<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;
use Slim\Http\Response;

class SlimResponsePanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Slim Http Response';

    /**
     * @var string
     */
    protected $template = __DIR__ . '/templates/slim_response/';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Response $slimResponse */
        $slimResponse = $this->container->get($this->getContainerKey());

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
}
