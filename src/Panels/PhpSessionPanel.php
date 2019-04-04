<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class PhpSessionPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'PHP Session';

    /**
     * @var string
     */
    protected $template = __DIR__ . '/templates/php_session/';

    /**
     * @inheritDoc
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
}
