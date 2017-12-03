<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

namespace Server;


use FastD\Servitization\Server\HTTPServer;
use swoole_server;

/**
 * Class SubscribeServer
 * @package Server
 */
class SubscribeServer extends HTTPServer
{
    public function doTask(swoole_server $server, $data, $taskId, $workerId)
    {
        foreach ($this->getSwoole()->connections as $connection) {
            $info = $this->getSwoole()->connection_info($connection);
        }
    }
}