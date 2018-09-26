<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'host' =>  'http://0.0.0.0:80',
    'class' => \Server\RegistryServer::class,
    'options' => [
        'pid_file' => '/tmp/fastd/' . app()->getName() . '.pid',
        'worker_num' => 1,
        'task_worker_num' => 5,
        'heartbeat_check_interval' => 5,
        'heartbeat_idle_time' => 15,
    ],
    'processes' => [

    ],
    'listeners' => [
        [
            'name' => 'producer',
            'host' => '0.0.0.0:8800',
            'class' => \Server\ProducerServer::class,
        ]
    ],
];
