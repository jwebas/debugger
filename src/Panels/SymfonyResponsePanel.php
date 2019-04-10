<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;
use Symfony\Component\HttpFoundation\Response;

class SymfonyResponsePanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'symfonyResponse';

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
    public $iconTemplate = __DIR__ . '/templates/symfony_response/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/symfony_response/panel.phtml';

    /**
     * @var string|array|null
     */
    protected $containerKey = 'response';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Response $response */
        $response = $this->container->get($this->containerKey);

        return [
            'items' => [
                'Status Code'      => $response->getStatusCode(),
                'Protocol Version' => $response->getProtocolVersion(),
                'Charset'          => $response->getCharset(),

                'Date'          => $response->getDate(),
                'Age'           => $response->getAge(),
                'Max Age'       => $response->getMaxAge(),
                'Expires'       => $response->getExpires(),
                'Last Modified' => $response->getLastModified(),
                'Ttl'           => $response->getTtl(),
                'Etag'          => $response->getEtag(),

                'Content' => $response->getContent(),

                'Is Cacheable'     => $response->isCacheable(),
                'Is Fresh'         => $response->isFresh(),
                'Is Validateable'  => $response->isValidateable(),
                'Is Immutable'     => $response->isImmutable(),
                'Is Invalid'       => $response->isInvalid(),
                'Is Ok'            => $response->isOk(),
                'Is Successful'    => $response->isSuccessful(),
                'Is Informational' => $response->isInformational(),
                'Is Redirection'   => $response->isRedirection(),
                'Is Client Error'  => $response->isClientError(),
                'Is Server Error'  => $response->isServerError(),
                'Is Not Found'     => $response->isNotFound(),
                'Is Forbidden'     => $response->isForbidden(),
                'Is Empty'         => $response->isEmpty(),
                'Vary Header'      => $response->hasVary(),
            ],
            'full'  => $response,
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
