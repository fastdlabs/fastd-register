<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'host' => '127.0.0.1:9993',
    'class' => \FastD\Servitization\Server\HTTPServer::class,
    'options' => [
        'pid_file' => __DIR__ . '/../runtime/pid/' . app()->getName() . '.pid',
        'log_file' => __DIR__ . '/../runtime/logs/' . app()->getName() . '.pid',
        'log_level' => 5,
        'worker_num' => 10,
    ],
    'processes' => [

    ],
    'listeners' => [
        [
            'host' => '127.0.0.1:9999',
            'class' => \Server\RegistryServer::class,
        ],
        [
            'host' => '0.0.0.0:9996',
            'class' => \Server\ProducerServer::class
        ]
    ],
];