<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 11:59
 */

namespace Server;

use FastD\Packet\Json;
use FastD\Servitization\Server\HTTPServer;
use swoole_server;

/**
 * Class RegistryServer
 * @package Server
 */
class RegistryServer extends HTTPServer
{
    /**
     * @param swoole_server $server
     * @param $data
     * @param $taskId
     * @param $workerId
     * @return mixed|void
     * @throws \FastD\Packet\Exceptions\PacketException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function doTask(swoole_server $server, $data, $taskId, $workerId)
    {
        $this->broadcast($server, $data);
    }

    /**
     * @param swoole_server $server
     * @param $data
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public function broadcast(swoole_server $server, $data)
    {
        $data = Json::decode($data);
        if (isset($server->connections)) {
            foreach ($server->connections as $fd) {
                try {
                    $nodes = registry()->fetch($data['service']);
                    if ($data['fd'] != $fd) {
                        $server->send($fd, Json::encode([
                            'service' => $data['service'],
                            'list' => $nodes,
                        ]));
                    }
                }catch (\Exception $e) {
                    continue;
                }
            }
        }
    }
}