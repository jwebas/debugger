<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels\Abstracts;


interface PanelInterface
{
    /**
     * Get panel data
     *
     * @return array
     */
    public function getData(): array;
}
