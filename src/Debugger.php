<?php
declare(strict_types=1);


namespace Jwb;

use Jwb\Panels\ConfigPanel;
use Jwb\Panels\EloquentOrmPanel;
use Jwb\Panels\PhpInfoPanel;
use Jwb\Panels\PhpSessionPanel;
use Jwb\Panels\SlimContainerPanel;
use Jwb\Panels\SlimEnvironmentPanel;
use Jwb\Panels\SlimRequestPanel;
use Jwb\Panels\SlimResponsePanel;
use Jwb\Panels\SlimRouterPanel;
use Jwb\Panels\TwigPanel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Tracy\Debugger as TracyDebugger;
use Tracy\IBarPanel;

class Debugger extends TracyDebugger
{
    /**
     * Default panels
     *
     * @var array
     */
    protected static $default = [
        'container'     => [
            'config'     => [
                'class' => ConfigPanel::class,
                'keys'  => ['config'],
            ],
            'eloquentOrm'     => [
                'class' => EloquentOrmPanel::class,
                'keys'  => ['database'],
            ],
            'slimContainer'   => [
                'class' => SlimContainerPanel::class,
            ],
            'slimEnvironment' => [
                'class' => SlimEnvironmentPanel::class,
                'keys'  => ['environment'],
            ],
            'slimRequest'     => [
                'class' => SlimRequestPanel::class,
                'keys'  => ['request'],
            ],
            'slimResponse'    => [
                'class' => SlimResponsePanel::class,
                'keys'  => ['response'],
            ],
            'slimRouter'      => [
                'class' => SlimRouterPanel::class,
                'keys'  => ['router'],
            ],
            'twig'            => [
                'class' => TwigPanel::class,
                'keys'  => ['view', 'twigProfile'],
            ],
        ],
        'non_container' => [
            'phpInfo'    => [
                'class' => PhpInfoPanel::class,
            ],
            'phpSession' => [
                'class' => PhpSessionPanel::class,
            ],
        ],
    ];

    /**
     * Run debugger
     *
     * @param array $settings
     */
    public static function run(array $settings = []): void
    {
        $mode = static::DETECT;
        $logDirectory = null;
        $email = null;

        if (count($settings)) {

            $mode = (bool)($settings['debug'] ?? false) ? static::DEVELOPMENT : static::PRODUCTION;

            $ipAddresses = $settings['ip_addresses'] ?? [];
            if (\count($ipAddresses)) {
                $mode = static::detectMode($ipAddresses);
            }

            static::$showBar = (bool)($settings['showBar'] ?? true);
            static::$showFireLogger = (bool)($settings['showFireLogger'] ?? true);

            static::$strictMode = (bool)($settings['strictMode'] ?? false);
            static::$scream = (bool)($settings['scream'] ?? false);

            static::$maxDepth = (int)($settings['maxDepth'] ?? 3);
            static::$maxLength = (int)($settings['maxLength'] ?? 150);
            static::$showLocation = (bool)($settings['showLocation'] ?? false);

            static::$customCssFiles = $settings['customCssFiles'] ?? [];
            static::$customJsFiles = $settings['customJsFiles'] ?? [];

            $logDirectory = $settings['logDirectory'] ?? null;
            $email = $settings['email'] ?? null;
        }

        static::enable($mode, $logDirectory, $email);
    }

    /**
     * Add panels from config
     *
     * @param array                   $settings
     * @param ContainerInterface|null $container
     */
    public static function addPanels(array $settings, $container = null): void
    {
        $panels = static::mergeConfig($settings['panels']);

        $containerPanels = $panels['container'] ?? [];
        $nonContainerPanels = $panels['non_container'] ?? [];

        if ($container instanceof ContainerInterface && count($containerPanels)) {
            foreach ($containerPanels as $id => $panel) {
                $keysExists = static::containerKeysExist($container, $panel);
                if ($keysExists) {
                    static::addPanelFromConfig($panel, $container, $id);
                }
            }
        }

        if (count($nonContainerPanels)) {
            foreach ($nonContainerPanels as $id => $panel) {
                static::addPanelFromConfig($panel, $container, $id);
            }
        }
    }

    /**
     * Add new panel
     *
     * @param IBarPanel   $panel
     * @param string|null $id
     */
    public static function addPanel(IBarPanel $panel, $id = null): void
    {
        static::getBar()->addPanel($panel, $id);
    }

    /**
     * merge config
     *
     * @param array $config
     *
     * @return array
     */
    protected static function mergeConfig(array $config): array
    {
        foreach (static::$default as $main => $items) {
            foreach ($items as $key => $item) {
                foreach ($item as $i => $v) {
                    if (!isset($config[$main][$key][$i])) {
                        $config[$main][$key][$i] = $v;
                    }
                }
            }
        }

        return $config;
    }

    /**
     * Add new panel from config
     *
     * @param array                   $panel
     * @param ContainerInterface|null $container
     * @param string|null             $id
     */
    protected static function addPanelFromConfig(array $panel, $container = null, $id = null): void
    {
        $enabled = (bool)($panel['enabled'] ?? true);

        if ($enabled) {
            $class = static::resolveClass($panel);

            if (false !== $class) {
                $title = $panel['title'] ?? '';
                self::getBar()->addPanel(new $class($container, $title), $id);
            }
        }
    }

    /**
     * Check if container key exists
     *
     * @param ContainerInterface $container
     * @param array              $panel
     *
     * @return bool
     */
    protected static function containerKeysExist(ContainerInterface $container, $panel): bool
    {
        $keys = $panel['keys'] ?? null;

        if (is_array($keys) && count($keys)) {
            foreach ($keys as $key) {
                try {
                    $container->get($key);
                } catch (ContainerExceptionInterface $exception) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Resolve panel class
     *
     * @param array $panel
     *
     * @return bool|mixed|string
     */
    protected static function resolveClass($panel)
    {
        $class = $panel['class'] ?? null;

        if (null !== $class && class_exists($class)) {
            return $class;
        }

        return false;
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
            if (\in_array($ipAddress, $excludedIps, true)) {
                unset($ipAddresses[$key]);
            }
        }

        return !static::detectDebugMode($ipAddresses);
    }
}
