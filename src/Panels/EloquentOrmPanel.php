<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Panels;


use Illuminate\Database\Capsule\Manager;
use Jwebas\Debugger\Panels\Abstracts\AbstractPanel;

class EloquentOrmPanel extends AbstractPanel
{
    /**
     * @var string
     */
    protected $title = 'Eloquent ORM (database)';

    /**
     * Renders HTML code for custom tab.
     *
     * @return string
     */
    public function getTab(): string
    {
        $data = $this->getInfo();
        $content = $this->getIcon() . ' ' . $data['count'] . ' / ' . $data['time'];

        return '<span title="' . $this->title . '">' . $content . '</span>';
    }

    /**
     * Renders HTML code for custom panel.
     *
     * @return string
     */
    public function getPanel(): string
    {
        ob_start();
        if (class_exists(Manager::class)) {
            require __DIR__ . '/templates/eloquent_orm.panel.phtml';
        } else {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $msg = 'Class Illuminate\Database\Capsule\Manager not found';
            require __DIR__ . '/templates/not_found.panel.phtml';
        }

        return ob_get_clean();
    }

    /**
     * @return array
     */
    protected function getInfo(): array
    {
        /** @var Manager $manager */
        $manager = $this->container->get('db');
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

    /**
     * @return string
     */
    protected function getIcon(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 284.207 ' .
            '284.207" style="enable-background:new 0 0 284.207 284.207;" xml:space="preserve" width="16px" height=' .
            '"16px"><path d="M239.604,45.447c0-25.909-41.916-45.447-97.5-45.447s-97.5,19.538-97.5,45.447v47.882c0,' .
            '6.217,2.419,12.064,6.854,17.365  c-3.84,0.328-6.854,3.543-6.854,7.468v47.882c0,6.217,2.419,12.065,6.855' .
            ',17.366c-3.84,0.328-6.855,3.543-6.855,7.468v47.881  c0,25.91,41.916,45.448,97.5,45.448s97.5-19.538,97.' .
            '5-45.448v-47.881c0-3.925-3.016-7.14-6.855-7.468  c4.437-5.301,6.855-11.149,6.855-17.366v-47.882c0-3.' .
            '925-3.015-7.14-6.855-7.468c4.436-5.301,6.855-11.148,6.855-17.365V45.447z M224.598,190.952c-0.121,14.' .
            '354-35.358,30.373-82.494,30.373s-82.373-16.02-82.494-30.373 c16.977,12.544,46.938,20.539,82.494,20.' .
            '539S207.621,203.496,224.598,190.952z M224.598,118.238 c-0.123,14.354-35.359,30.372-82.494,30.372s-82.' .
            '371-16.019-82.494-30.372c16.977,12.543,46.938,20.538,82.494,20.538  S207.621,130.781,224.598,118.238z ' .
            'M142.104,15c47.218,0,82.5,16.075,82.5,30.447s-35.282,30.447-82.5,30.447  s-82.5-16.075-82.5-30.447S94.' .
            '886,15,142.104,15z" fill="#005ccc"/></svg>';
    }
}
