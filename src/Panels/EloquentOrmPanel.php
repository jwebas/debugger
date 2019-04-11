<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Illuminate\Database\Capsule\Manager;
use Jwebas\Debugger\Support\Panel;
use Psr\Container\NotFoundExceptionInterface;

class EloquentOrmPanel extends Panel
{
    /**
     * Panel id
     *
     * @var string|null
     */
    public $id = 'eloquentOrm';

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
    public $panelTitle = 'Eloquent ORM';

    /**
     * @var string|null
     */
    public $iconTemplate = __DIR__ . '/templates/eloquent_orm/icon.svg';

    /**
     * @var string|null
     */
    public $panelTemplate = __DIR__ . '/templates/eloquent_orm/panel.phtml';

    /**
     * @var string|array|null
     */
    protected $containerKey = 'database';

    /**
     * @return string
     */
    public function getTabData(): string
    {
        $data = $this->getData();

        return $data['count'] . ' / ' . $data['time'];
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        if (null === $this->container || !class_exists(Manager::class)) {
            return false;
        }

        try {
            $this->container->get($this->containerKey);
        } catch (NotFoundExceptionInterface $e) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Manager $manager */
        $manager = $this->container->get($this->containerKey);
        $queryLog = $manager->getConnection()->getQueryLog();
        $time = $cnt = 0;
        $content = '';

        foreach ($queryLog as $var) {
            $time += $var['time'];
            $row = $this->getBaseRow();
            $bind = '<span class="tracy-dump-hash"><hr />';
            if (!empty($var['bindings'])) {
                foreach ($var['bindings'] as $k => $v) {
                    $bind .= "[$k => $v]<br />";
                }
            }
            $content .= sprintf(
                $row,
                ++$cnt,
                $var['time'],
                $var['query'] . $bind . '</span>'
            );
        }

        return [
            'count'   => count($queryLog),
            'time'    => $time,
            'content' => $content,
        ];
    }

    /**
     * @return string
     */
    protected function getBaseRow(): string
    {
        return '<tr><td class="e">%s</td><td class="v">%s</td><td class="u">%s</td></tr>';
    }
}
