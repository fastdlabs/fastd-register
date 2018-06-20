<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/19
 * Time: 15:42
 */

namespace Server;


use FastD\Packet\Json;
use FastD\Servitization\OnWorkerStart;
use FastD\Swoole\Server\TCP;
use swoole_server;

class ConsumerTcpServer extends TCP
{
    use OnWorkerStart;


    public function doWork(swoole_server $server, $fd, $data, $from_id)
    {
        //校验格式
        $data = Json::decode($data, true);
        if (!$data || !is_array($data) || !isset($data['type'])) {
            return 0;
        }
        switch ($data['type']) {
            case 'show':
                $this->show($server, $fd, $data['service']);
                break;
            case 'broadcast':
            default:
                $this->broadcast($server);
                break;
        }
    }


    protected function broadcast(swoole_server $server)
    {
        $data = Json::encode(registry()->list());

        foreach ($server->connections as $fd) {
            $server->send($fd, $data);
        }
        print_r('广播' . PHP_EOL);
    }

    protected function show(swoole_server $server, $fd, $service)
    {
        $data = registry()->show($service);

        $server->send($fd, Json::encode($data));

        print_r('发送服务列表' . PHP_EOL);
    }
}