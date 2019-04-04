<?php declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Illuminate\Database\Capsule\Manager;
use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class EloquentOrmPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Eloquent ORM';

    /**
     * @var string
     */
    protected $template = __DIR__ . '/templates/eloquent_orm/';

    /**
     * @return string
     */
    protected function getTabData(): string
    {
        $data = $this->getData();

        return $data['count'] . ' / ' . $data['time'];
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var Manager $manager */
        $manager = $this->container->get($this->getContainerKey());
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
