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
     * @param $fd
     * @param $data
     * @param $from_id
     * @return int|mixed
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public function doWork(swoole_server $server, $fd, $data, $from_id)
    {
        //校验格式
        $data = Json::decode($data);
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

    /**
     * @param swoole_server $server
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    protected function broadcast(swoole_server $server)
    {
        $data = Json::encode(registry()->all());

        foreach ($server->connections as $fd) {
            $server->send($fd, $data);
        }
        print_r('广播' . PHP_EOL);
    }

    /**
     * @param swoole_server $server
     * @param $fd
     * @param $service
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    protected function show(swoole_server $server, $fd, $service)
    {
        $data = registry()->show($service);

        $server->send($fd, Json::encode($data));

        print_r('发送服务列表' . PHP_EOL);
    }
}
