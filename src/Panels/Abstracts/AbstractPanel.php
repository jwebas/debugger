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
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * AbstractPanel constructor.
     *
     * @param ContainerInterface|null $container
     * @param array                   $params
     */
    public function __construct($container = null, array $params = [])
    {
        $this->container = $container;
        $this->params = $params;
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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->params['title'] ?? $this->title;
    }

    /**
     * @return string|array
     */
    public function getContainerKey()
    {
        return $this->params['containerKey'] ?? '';
    }
}
