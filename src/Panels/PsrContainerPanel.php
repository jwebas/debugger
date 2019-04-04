<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class PsrContainerPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Container';

    /**
     * @var string
     */
    protected $template = __DIR__ . '/templates/psr_container/';

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return [
            'all' => $this->container,
        ];
    }
}
