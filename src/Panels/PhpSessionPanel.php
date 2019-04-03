<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class PhpSessionPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'PHP Session';

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
        require __DIR__ . '/templates/php_session.panel.phtml';

        return ob_get_clean();
    }

    /**
     * @return array
     */
    protected function getData(): array
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
     * @return string
     */
    protected function getIcon(): string
    {
        return '<svg viewBox="0 0 2048 2048" width="16px" height="16px"><path fill="#c0392b" d="m1691 1396-67 394h-133s2-446 0-586v-4c0-109 89-197 200-197 110 0 200 88 200 197s-89 197-200 197zm-1131-192c-2 141 0 586 0 586h-133l-67-394h-1c-110 0-199-88-199-197s89-197 200-197c110 0 200 88 200 197v4zm865 61v394h-399-403v-394c262-27 529-27 802 0zm0-66c-273-27-541-27-802 0-2-163-119-258-266-262-176-545 233-693 669-693 440 0 841 149 665 693-148 4-265 99-266 263z"></path></svg>';
    }
}
