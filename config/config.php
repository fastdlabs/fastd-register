<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

return [
    'registry_server' => [
        //redis
        'driver' => 'redis',
        'host' => '10.0.75.1',
        'port' => 6379,
        'auth' => '',

        //zookeeper
        /*'driver' => 'zookeeper',
        'host' => '127.0.0.1',
        'port' => 2181,
        //集群模式
        //'url' => '127.0.0.1:2181,127.0.0.1:2182'*/
    ],
    'producer_server' => [
        'host' => 'tcp://0.0.0.0:9996'
    ]
];