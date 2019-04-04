<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Config\Config;
use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class JwebasConfigPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Config';

    /**
     * @var string
     */
    protected $template = __DIR__ . '/templates/jwebas_config/';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Config $config */
        $config = $this->container->get($this->getContainerKey());

        return $config->all();
    }
}
