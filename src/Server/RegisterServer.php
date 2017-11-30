<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Server;


use FastD\Servitization\Server\TCPServer;
use swoole_server;

class RegisterServer extends TCPServer
{
    public function doConnect(swoole_server $server, $fd, $from_id)
    {

    }

    public function doClose(swoole_server $server, $fd, $fromId)
    {

    }

    public function doWork(swoole_server $server, $data, $taskId, $workerId)
    {

    }
}