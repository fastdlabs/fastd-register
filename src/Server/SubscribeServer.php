<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

namespace Server;


use FastD\Servitization\Server\TCPServer;
use swoole_server;

/**
 * Class SubscribeServer
 * @package Server
 */
class SubscribeServer extends TCPServer
{
    public function doWork(swoole_server $server, $fd, $data, $from_id)
    {

    }
}