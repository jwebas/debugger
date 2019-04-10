<?php declare(strict_types=1);


namespace Jwebas\Debugger\Bundles;


use Jwebas\Debugger\Panels\SymfonyRequestPanel;
use Jwebas\Debugger\Panels\SymfonyResponsePanel;
use Jwebas\Debugger\Support\Bundle;

class SymfonyFrameworkBundle extends Bundle
{
    /**
     * @var array
     */
    protected $panels = [
        [SymfonyRequestPanel::class, 'sfRequest'],
        [SymfonyResponsePanel::class, 'sfResponse'],
    ];

    /**
     * Panel id
     *
     * @var string
     */
    public $id = 'symfony';

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
    public $panelTitle;

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/symfony_framework/icon.svg';
}
