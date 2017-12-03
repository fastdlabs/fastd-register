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

/**
 * Class RegisterServer
 * @package Server
 */
class RegisterServer extends TCPServer
{
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
            node()->add($node['name'], $node);
            $server->send($fd, "ok\r\n");
            $server->task('notify');
        } catch (\Exception $exception) {
            $server->send($fd, $exception->getTraceAsString());
        }
    }
}
