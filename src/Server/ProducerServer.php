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
use Registry\Contracts\NodeAbstract;
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
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function doWork(swoole_server $server, $fd, $data, $from_id)
    {
        $response = parent::doWork($server, $fd, $data, $from_id);

        $node = registry()->getNode($fd);

        if ($node instanceof NodeAbstract) {
            $server->task(Json::encode([
                'service' => $node->service(),
                'hash' => $node->hash(),
                'fd' => $fd,
            ]));
        }

        return $response;
    }

    /**
     * @param swoole_server $server
     * @param $fd
     * @param $fromId
     * @throws \FastD\Packet\Exceptions\PacketException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function doClose(swoole_server $server, $fd, $fromId)
    {
        if (false !== ($node = registry()->getNode($fd))) {
            $item = registry()->getItem($fd);
            registry()->remove($node);
            cache()->deleteItem($item->getKey());
            $server->task(Json::encode([
                'service' => $node->service(),
                'hash' => $node->hash(),
                'fd' => $fd,
            ]));
        }
    }
}
