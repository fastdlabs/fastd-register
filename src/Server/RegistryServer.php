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
     * 启动时检查以前的节点是否正常使用
     * 如果一旦服务发现端无故宕机，那么节点应该无无法得到妥善处理，一旦重启，而不对节点进行查，那么就会出现一些意料之外的问题。
     * 因此启动时检查的步骤是为了对每个节点进行恢复，并且在客户端重连的时候自动同步
     *
     * @param swoole_server $server
     */
    public function onManagerStart(swoole_server $server)
    {

        parent::onManagerStart($server);
    }

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
                            $data['service'] => $nodes,
                        ]));
                    }
                }catch (\Exception $e) {
                    continue;
                }
            }
        }
    }
}
