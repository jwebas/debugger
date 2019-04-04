<?php declare(strict_types=1);


namespace Jwebas\Debugger;


use Psr\Container\ContainerInterface;
use ReflectionClass;
use Slim\Exception\ContainerValueNotFoundException;
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
        $defaultConfig = static::getConfig();
        $config = array_replace_recursive($defaultConfig, $settings);

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
     * @param array                   $panels
     * @param ContainerInterface|null $container
     */
    public static function addPanels(array $panels = [], $container = null): void
    {
        $defaultPanels = static::getConfig()['panels'];
        $panels = array_replace_recursive($defaultPanels, $panels);

        $enabledPanels = [];

        if (is_string($panels['enabled'])) {
            if ('all' === $panels['enabled']) {
                $enabledPanels = array_keys($panels['defined']);
            } else {
                $enabledPanels[] = $panels['enabled'];
            }
        } else {
            $enabledPanels = $panels['enabled'];
        }

        foreach ($enabledPanels as $panelKey) {
            $resolved = static::panelIsResolved($panelKey, $panels['defined'], $container);
            if (false !== $resolved) {
                $resolved['show_title'] = $panels['show_title'];
                static::addPanel(new $resolved['class']($container, $resolved), $panelKey);
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
     * Resolve panel
     *
     * @param string                  $key
     * @param array                   $panels
     * @param ContainerInterface|null $container
     *
     * @return bool|array
     */
    protected static function panelIsResolved(string $key, array $panels, $container = null)
    {
        if (!array_key_exists($key, $panels)) {
            return false;
        }

        $panel = $panels[$key];

        if (!class_exists($panel['class'])) {
            return false;
        }

        $class = new ReflectionClass($panel['class']);
        if (!$class->implementsInterface(IBarPanel::class)) {
            return false;
        }

        $required = $panel['required'] ?? true;
        if (!$required) {
            return false;
        }

        $containerKey = $panel['containerKey'] ?? null;
        if (null !== $containerKey) {

            if (null === $container) {
                return false;
            }

            $keys = [];

            if (is_string($containerKey)) {
                $keys[] = $containerKey;
            } else {
                $keys = $containerKey;
            }

            foreach ($keys as $value) {
                try {
                    $container->get($value);
                } catch (ContainerValueNotFoundException $e) {
                    return false;
                }
            }
        }

        return $panel;
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
