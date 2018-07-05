<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'host' => '0.0.0.0:9993',
    'class' => \FastD\Servitization\Server\HTTPServer::class,
    'options' => [
        'pid_file' => '/tmp/fastd/' . app()->getName() . '.pid',
        'worker_num' => 5,
        'task_num' => 10,
    ],
    'processes' => [

    ],
    'listeners' => [
        [
            'host' => '0.0.0.0:9999',
            'class' => \Server\RegistryServer::class,
        ],
        [
            'host' => '0.0.0.0:9996',
            'class' => \Server\ProducerServer::class
        ]
    ],
];