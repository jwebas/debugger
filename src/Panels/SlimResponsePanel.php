<?php
declare(strict_types=1);


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
     * Renders HTML code for custom tab.
     *
     * @return string
     */
    public function getTab(): string
    {
        return '<span title="' . $this->getTitle() . '">' . $this->getIcon() . '</span>';
    }

    /**
     * Renders HTML code for custom panel.
     *
     * @return string
     */
    public function getPanel(): string
    {
        ob_start();
        require __DIR__ . '/templates/slim_response.panel.phtml';

        return ob_get_clean();
    }

    /**
     * @return array
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
