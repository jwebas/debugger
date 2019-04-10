<?php declare(strict_types=1);


namespace Jwebas\Debugger\Helpers;


use Jwebas\Debugger\Bundles\SymfonyFrameworkBundle;
use Jwebas\Debugger\Panels\SymfonyRequestPanel;
use Jwebas\Debugger\Panels\SymfonyResponsePanel;

class SymfonyFrameworkBundleHelper extends SymfonyFrameworkBundle
{
    /**
     * @var array
     */
    protected $panels = [
        [SymfonyRequestPanel::class, 'sfRequest'],
        [SymfonyResponsePanel::class, 'sfResponse'],
    ];
}
