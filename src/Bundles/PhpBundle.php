<?php declare(strict_types=1);


namespace Jwebas\Debugger\Bundles;


use Jwebas\Debugger\Panels\PhpDefinesPanel;
use Jwebas\Debugger\Panels\PhpInfoPanel;
use Jwebas\Debugger\Panels\PhpSessionPanel;
use Jwebas\Debugger\Support\Bundle;

class PhpBundle extends Bundle
{
    /**
     * @var array
     */
    protected $panels = [
        PhpSessionPanel::class,
        PhpDefinesPanel::class,
        PhpInfoPanel::class,
    ];

    /**
     * Panel id
     *
     * @var string
     */
    public $id = 'php';

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
    public $iconTemplate = __DIR__ . '/templates/php/icon.svg';
}
