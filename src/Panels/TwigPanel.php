<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;
use Slim\Views\Twig;
use Twig\Profiler\Profile;

class TwigPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Twig Templates Engine';

    /**
     * @var string
     */
    protected $template = __DIR__ . '/templates/twig/';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Twig $twig */
        $twig = $this->container->get($this->getContainerKey()[0]);

        /** @var Profile $twigProfile */
        $twigProfile = $this->container->get($this->getContainerKey()[1]);

        return [
            'twigProfile' => $twigProfile,
            'time'        => sprintf('%.2f ms', $twigProfile->getDuration() * 1000),
            'extensions'  => $twig->getEnvironment()->getExtensions(),
            'loader'      => $twig->getLoader(),
            'full'        => $twig,
        ];
    }
}
