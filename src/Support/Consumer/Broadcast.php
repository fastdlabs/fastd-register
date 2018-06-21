<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/19
 * Time: 17:44
 */

namespace Support\Consumer;


use FastD\Packet\Json;
use FastD\Swoole\Client;
use swoole_client;

class Broadcast extends Client
{
    public function __construct($uri = null, bool $async = true, bool $keep = false)
    {
        parent::__construct($uri, $async, $keep);
    }

    public function onConnect(swoole_client $client)
    {
        $data = [
            'type' => 'broadcast',
        ];
        $client->send(Json::encode($data));
    }
}