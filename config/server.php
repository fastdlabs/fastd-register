<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'host' => '112.124.34.87:9529',
    'class' => \Server\RegistryServer::class,
    'options' => [
        'pid_file' => '/tmp/fastd/' . app()->getName() . '.pid',
        'worker_num' => 2,
        'task_worker_num' => 5,
        'heartbeat_check_interval' => 5,
        'heartbeat_idle_time' => 15,
    ],
    'processes' => [
    ],
    'listeners' => [
        [
            'name' => 'producer',
            'host' => '112.124.34.87:9530',
            'class' => \Server\ProducerServer::class,
        ]
    ],
];