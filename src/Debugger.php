<?php declare(strict_types=1);


namespace Jwebas\Debugger;


use Jwebas\Debugger\Support\BundleInterface;
use Jwebas\Debugger\Support\Panel;
use Jwebas\Debugger\Support\PanelInterface;
use Psr\Container\ContainerInterface;
use Tracy\Debugger as TracyDebugger;
use Tracy\IBarPanel;

class Debugger extends TracyDebugger
{
    /**
     * @var array
     */
    protected static $config = [];

    /**
     * @var array
     */
    protected static $panels = [];

    /**
     * Run debugger.
     *
     * @param array $settings
     */
    public static function run(array $settings = []): void
    {
        $defaultConfig = static::getConfig();
        static::$config = array_replace_recursive($defaultConfig, $settings);

        $mode = static::DETECT;
        $logDirectory = null;
        $email = null;

        $config = static::$config;

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

        static::$panels = $config['panels'] ?? [];
    }

    /**
     * @param ContainerInterface|null $container
     */
    public static function renderPanels($container = null): void
    {
        foreach (static::$panels as $panel) {

            /** @var null|string|array $containerKey */
            $containerKey = null;
            if (is_array($panel)) {
                [$class, $containerKey] = $panel;
            } else {
                $class = $panel;
            }

            /** @var PanelInterface|BundleInterface|Panel $panelClass */
            $panelClass = new $class($container);
            if (($panelClass instanceof PanelInterface || $panelClass instanceof BundleInterface)
                && $panelClass instanceof IBarPanel && $panelClass->valid()) {

                if ($panelClass instanceof PanelInterface && null !== $containerKey) {
                    $panelClass->setContainerKey($containerKey);
                }

                static::addPanel($panelClass, $panelClass->getId());
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
     * Get default config
     *
     * @return array
     */
    protected static function getConfig(): array
    {
        return include __DIR__ . '/../config/debugger.php';
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
