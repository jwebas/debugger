<?php
declare(strict_types=1);


namespace Jwb;


use Psr\Container\ContainerInterface;
use Tracy\Dumper;
use Tracy\IBarPanel;

abstract class DebuggerPanel implements IBarPanel
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var ContainerInterface|null
     */
    protected $container;

    /**
     * DebuggerPanel constructor.
     *
     * @param ContainerInterface|null $container
     * @param string                  $title
     */
    public function __construct($container = null, string $title = '')
    {
        $this->container = $container;
        if ($title) {
            $this->title = $title;
        }
    }

    /**
     * @param mixed $item
     * @param int   $truncate
     *
     * @return string
     */
    public function toHtml($item, $truncate = 100): string
    {
        $options = [
            'truncate' => $truncate,
            'location' => 0,
        ];

        return Dumper::toHtml($item, $options);
    }

    /**
     * @param array $headers
     *
     * @return string
     */
    public function tableHeader(array $headers = []): string
    {
        $content = '<div>';
        $content .= '<table>';
        $content .= '<thead>';

        if (\count($headers)) {
            $content .= '<tr>';
            foreach ($headers as $header) {
                $content .= '<th>' . $header . '</th>';
            }
            $content .= '</tr>';
        }

        $content .= '</thead>';
        $content .= '<tbody>';

        return $content;
    }

    /**
     * @return string
     */
    public function tableFooter(): string
    {
        return '</tbody></table></div>';
    }
}
