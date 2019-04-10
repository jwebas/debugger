<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Jwebas\Debugger\Support\Panel;

class PhpDefinesPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'phpDefines';

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
    public $panelTitle = 'Php Defines';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/php_defines/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/php_defines/panel.phtml';


    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return get_defined_constants(true)['user'] ?? [];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return true;
    }
}
