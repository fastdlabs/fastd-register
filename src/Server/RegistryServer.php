<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 11:59
 */

namespace Server;

use FastD\Servitization\Server\HTTPServer;
use swoole_server;

/**
 * Class RegistryServer
 * @package Server
 */
class RegistryServer extends HTTPServer
{
    public function doTask(swoole_server $server, $data, $taskId, $workerId)
    {
        $server->ports[0]->connections;
    }
}