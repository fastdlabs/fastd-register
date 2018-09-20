<?php
/**
 * @author    fastdlabs[yong]
 * @copyright 2018
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
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
     * 接受 server 端与 agent 端连接
     *      server 端处理: 进入控制器处理逻辑，节点存储，并且将该节点信息同步更新到agent，此时仅同步单节点，保持连接
     *      agent 端端处理: 广播全量节点信息到 agent，保持连接，在首次连接的时候会同步到 agent 端
     *
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
        $nodeBefore = registry()->getItem($fd)->get();

        $response = parent::doWork($server, $fd, $data, $from_id);

        $node = registry()->getNode($fd);

        echo '准备广播', PHP_EOL,$fd,PHP_EOL;
        // 比对hash值 不同则需要广播至agent @todo parent::doWork心跳数据是否需要写入？
        if (!isset($nodeBefore['hash']) || $nodeBefore['hash'] !== $node['hash']) {
            echo '开始发送', PHP_EOL;
            if ($node instanceof NodeAbstract) {
                $this->broadcast($server, $fd, $node);
            }
            echo '广播完毕', PHP_EOL;

            return $response;
        }
        echo '节点hash相同,取消广播', PHP_EOL;

        echo 'response';

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
        echo $fd,PHP_EOL;
        if (false !== ($node = registry()->getNode($fd))) {
            $item = registry()->getItem($fd);
            echo $item->getKey(),PHP_EOL;
            registry()->remove($node);
            cache()->deleteItem($item->getKey());

            $this->broadcast($server, $fd, $node);
        }
    }

    /**
     * @param swoole_server $server
     * @param $fd
     * @param NodeAbstract|null $node
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public function broadcast(swoole_server $server, $fd, NodeAbstract $node = null)
    {
        $server->task(Json::encode([
            'service' => $node->service(),
            'hash' => $node->hash(),
            'fd' => $fd,
        ]));
    }
}
