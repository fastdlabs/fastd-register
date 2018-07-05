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

    /**
     * Broadcast constructor.
     * @param null $uri
     * @param bool $async
     * @param bool $keep
     */
    /**
     * Broadcast constructor.
     * @param null $uri
     * @param bool $async
     * @param bool $keep
     */
    public function __construct($uri = null, bool $async = true, bool $keep = false)
    {
        parent::__construct($uri, $async, $keep);
    }

    /**
     * @param swoole_client $client
     * @return mixed|void
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public function onConnect(swoole_client $client)
    {
        $data = [
            'type' => 'broadcast',
        ];
        $client->send(Json::encode($data));
    }
}
