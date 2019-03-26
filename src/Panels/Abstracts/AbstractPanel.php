<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Panels\Abstracts;


use Psr\Container\ContainerInterface;
use Tracy\Dumper;
use Tracy\IBarPanel;

abstract class AbstractPanel implements IBarPanel
{
    /**
     * @var ContainerInterface|null
     */
    protected $container;

    /**
     * @var string
     */
    protected $title;

    /**
     * AbstractPanel constructor.
     *
     * @param ContainerInterface|null $container
     * @param string                  $title
     */
    public function __construct($container = null, $title = '')
    {
        $this->container = $container;
        $this->title = $title;
    }

    /**
     * @param mixed $item
     * @param int   $truncate
     * @param bool  $location
     *
     * @return string
     */
    public function toHtml($item, $truncate = 100, $location = false): string
    {
        $options = [
            'truncate' => $truncate,
            'location' => $location,
        ];

        return Dumper::toHtml($item, $options);
    }
}
