<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 11:59
 */

namespace Server;

use FastD\Servitization\Server\TCPServer;
use Registry\Node\ServiceNode;
use swoole_server;

/**
 * Class RegistryServer
 * @package Server
 */
class RegistryServer extends TCPServer
{
    /**
     * @var RegistryEntity
     */
    protected $entity;

    /**
     * @param swoole_server $server
     * @param $fd
     * @param $fromId
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function doClose(swoole_server $server, $fd, $fromId)
    {
        $key = 'map.'.$fd;
        $item = cache()->getItem($key);
        if ($item->isHit()) {
            $nodeInfo = $item->get();
            $node = ServiceNode::make([
                'service_name' => $nodeInfo['service_name'],
                'hash' => $nodeInfo['hash'],
            ]);
            registry()->remove($node);
            cache()->deleteItem($key);
        }
        // 发送广播任务到 ProducerServer
        $server->task('broadcast');
    }
}