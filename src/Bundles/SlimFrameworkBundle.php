<?php declare(strict_types=1);


namespace Jwebas\Debugger\Bundles;


use Jwebas\Debugger\Panels\SlimEnvironmentPanel;
use Jwebas\Debugger\Panels\SlimRequestPanel;
use Jwebas\Debugger\Panels\SlimResponsePanel;
use Jwebas\Debugger\Panels\SlimRouterPanel;
use Jwebas\Debugger\Panels\SlimTwigPanel;
use Jwebas\Debugger\Support\Bundle;

class SlimFrameworkBundle extends Bundle
{
    /**
     * @var array
     */
    protected $panels = [
        SlimEnvironmentPanel::class,
        SlimRequestPanel::class,
        SlimResponsePanel::class,
        SlimRouterPanel::class,
        SlimTwigPanel::class,
    ];

    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'slim';

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
    public $iconTemplate = __DIR__ . '/templates/slim_framework/icon.svg';
}
