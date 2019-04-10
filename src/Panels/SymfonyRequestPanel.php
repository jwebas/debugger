<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;
use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'symfonyRequest';

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
    public $iconTemplate = __DIR__ . '/templates/symfony_request/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/symfony_request/panel.phtml';

    /**
     * @var string|array|null
     */
    protected $containerKey = 'request';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Request $request */
        $request = $this->container->get($this->containerKey);

        return [
            'items' => [
                'Method'      => $request->getMethod(),
                'Real Method' => $request->getRealMethod(),

                'Scheme'               => $request->getScheme(),
                'Base Url'             => $request->getBaseUrl(),
                'Port'                 => $request->getPort(),
                'Http Host'            => $request->getHttpHost(),
                'Request Uri'          => $request->getRequestUri(),
                'Scheme and Http Host' => $request->getSchemeAndHttpHost(),
                'Uri'                  => $request->getUri(),
                'Query String'         => $request->getQueryString(),
                'Host'                 => $request->getHost(),

                'Protocol Version' => $request->getProtocolVersion(),
                'Content Type'     => $request->getContentType(),
                'ETags'            => $request->getETags(),

                'is Xml Http Request (AJAX)' => $request->isXmlHttpRequest(),
                'Is Secure (https)'          => $request->isSecure(),
                'is No Cache'                => $request->isNoCache(),
                'is From Trusted Proxy'      => $request->isFromTrustedProxy(),

                'Locale'         => $request->getLocale(),
                'Default Locale' => $request->getDefaultLocale(),

                'Acceptable Encodings'     => $request->getEncodings(),
                'Acceptable Languages'     => $request->getLanguages(),
                'Acceptable Charsets'      => $request->getCharsets(),
                'Acceptable Content Types' => $request->getAcceptableContentTypes(),

                'Path Info' => $request->getPathInfo(),
                'Base Path' => $request->getBasePath(),

                'Session'             => $request->getSession(),
                'Client Ips'          => $request->getClientIps(),
                'Current script name' => $request->getScriptName(),

                'User'     => $request->getUser(),
                'Password' => $request->getPassword(),
                'Info'     => $request->getUserInfo(),
            ],
            'full'  => $request,
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
