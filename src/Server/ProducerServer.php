<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/19
 * Time: 15:42
 */
namespace Server;

use FastD\Packet\Json;
use FastD\Servitization\Server\TCPServer;
use swoole_server;

/**
 * Class ProducerTcpServer
 * @package Server
 */
class ProducerServer extends TCPServer
{
    /**
     * @param swoole_server $server
     * @param $taskId
     * @param $workerId
     * @param $data
     * @return mixed|void
     */
    public function onTask(swoole_server $server, $taskId, $workerId, $data)
    {
        // 接受更新任务，广播到所有客户端 agent
        echo $data;
    }
}
