<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;

class PhpSessionPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'phpSession';

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
    public $panelTitle = 'Php Session';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/php_session/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/php_session/panel.phtml';

    /**
     * @return array
     */
    public function getData(): array
    {
        $cookies = session_get_cookie_params();

        return [
            'session'        => [
                'title'  => 'Session',
                'values' => $_SESSION,
            ],
            'session_params' => [
                'title'  => 'Session params',
                'values' => [
                    'ID'                      => session_id(),
                    'Name'                    => session_name(),
                    'Cache Expire Time (min)' => session_cache_expire(),
                    'Cache Limiter'           => session_cache_limiter(),
                    'Save Path'               => session_save_path(),
                ],
            ],
            'cookie_params'  => [
                'title'  => 'Cookie Params',
                'values' => [
                    'lifetime (s)' => $cookies['lifetime'],
                    'path'         => $cookies['path'],
                    'domain'       => $cookies['domain'],
                    'secure'       => $cookies['secure'],
                    'httponly'     => $cookies['httponly'],
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return session_status() !== PHP_SESSION_DISABLED;
    }
}
