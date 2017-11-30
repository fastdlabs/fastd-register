<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Server;


use FastD\Packet\Json;
use FastD\Servitization\Server\TCPServer;
use Register\Node;
use swoole_server;

class RegisterServer extends TCPServer
{
    public function doClose(swoole_server $server, $fd, $fromId)
    {
    }

    /**
     * @param swoole_server $server
     * @param $fd
     * @param $data
     * @param $from_id
     * @return mixed
     */
    public function doWork(swoole_server $server, $fd, $data, $from_id)
    {
        try {
            $node = Json::decode($data);
            $node['fd'] = $fd;
            Node::set($node);
            $name = $node['name'];
            Node::get($name);
            $server->send($fd, "ok\r\n");
        } catch (\Exception $exception) {
            $server->send($fd, $exception->getTraceAsString());
        }
    }
}