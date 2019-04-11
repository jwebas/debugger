<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Views\Twig;
use Twig\Profiler\Profile;

class SlimTwigPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'slimTwig';

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
    public $panelTitle = 'Twig';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/slim_twig/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/slim_twig/panel.phtml';

    /**
     * @var string|array|null
     */
    protected $containerKey = ['twig', 'twigProfile'];

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Twig $twig */
        $twig = $this->container->get($this->containerKey[0]);

        /** @var Profile $twigProfile */
        $twigProfile = $this->container->get($this->containerKey[1]);

        return [
            'twigProfile' => $twigProfile,
            'time'        => sprintf('%.2f ms', $twigProfile->getDuration() * 1000),
            'extensions'  => $twig->getEnvironment()->getExtensions(),
            'loader'      => $twig->getLoader(),
            'full'        => $twig,
        ];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        if (null === $this->container || !class_exists(Twig::class) || !class_exists(Profile::class)) {
            return false;
        }

        foreach ($this->containerKey as $key) {
            try {
                $this->container->get($key);
            } catch (NotFoundExceptionInterface $e) {
                return false;
            }
        }

        return true;
    }
}
