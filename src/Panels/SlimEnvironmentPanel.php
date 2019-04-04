<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class SlimEnvironmentPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Slim Http Environment';

    /**
     * @var string
     */
    protected $template = __DIR__ . '/templates/slim_environment/';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return [
            'all' => $this->container->get($this->getContainerKey()),
        ];
    }
}
