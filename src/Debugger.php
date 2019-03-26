<?php declare(strict_types=1);


namespace Jwebas\Debugger;


use Psr\Container\ContainerInterface;
use Tracy\Debugger as TracyDebugger;
use Tracy\IBarPanel;

class Debugger extends TracyDebugger
{
    /**
     * Run debugger.
     *
     * @param array $settings
     */
    public static function run(array $settings = []): void
    {
        $mainConfig = include __DIR__ . '/../config/debugger.php';
        $config = array_merge($mainConfig, $settings);

        $mode = static::DETECT;
        $logDirectory = null;
        $email = null;

        if (count($config)) {
            $mode = (bool)($config['debug'] ?? false) ? static::DEVELOPMENT : static::PRODUCTION;

            $ipAddresses = $config['ip_addresses'] ?? [];
            if (count($ipAddresses)) {
                $mode = static::detectMode($ipAddresses);
            }

            static::$showBar = (bool)($config['showBar'] ?? true);
            static::$showFireLogger = (bool)($config['showFireLogger'] ?? true);

            static::$strictMode = (bool)($config['strictMode'] ?? false);
            static::$scream = (bool)($config['scream'] ?? false);

            static::$maxDepth = (int)($config['maxDepth'] ?? 3);
            static::$maxLength = (int)($config['maxLength'] ?? 150);
            static::$showLocation = (bool)($config['showLocation'] ?? false);

            static::$customCssFiles = $config['customCssFiles'] ?? [];
            static::$customJsFiles = $config['customJsFiles'] ?? [];

            $errorTemplate = $config['errorTemplate'] ?? '';
            if ($errorTemplate) {
                static::$errorTemplate = $errorTemplate;
            }

            $logDirectory = $config['logDirectory'] ?? null;
            $email = $config['email'] ?? null;
        }

        static::enable($mode, $logDirectory, $email);
    }

    /**
     * Add panels.
     *
     * @param array                   $settings
     * @param ContainerInterface|null $container
     */
    public static function addPanels(array $settings = [], $container = null): void
    {
        $mainConfig = include __DIR__ . '/../config/debugger.php';
        $config = array_merge($mainConfig, $settings);

        if (!$config['debug']) {
            return;
        }

        foreach ($config['panels'] as $key => $panel) {
            $enabled = $panel['enabled'] ?? true;
            $title = $panel['title'] ?? '';

            if ($enabled) {
                static::addPanel(new $panel['class']($container, $title), $key);
            }
        }
    }

    /**
     * Add custom panel.
     *
     * @param IBarPanel   $panel
     * @param string|null $id
     */
    public static function addPanel(IBarPanel $panel, $id = null): void
    {
        static::getBar()->addPanel($panel, $id);
    }

    /**
     * Detects debug mode by IP address.
     *
     * @param array $ipAddresses
     *
     * @return bool
     */
    protected static function detectMode(array $ipAddresses = []): bool
    {
        $excludedIps = ['localhost', '::1', '127.0.0.1'];

        foreach ($ipAddresses as $key => $ipAddress) {
            if (in_array($ipAddress, $excludedIps, true)) {
                unset($ipAddresses[$key]);
            }
        }

        return !static::detectDebugMode($ipAddresses);
    }
}
