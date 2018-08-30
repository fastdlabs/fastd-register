<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/8/23
 * Time: 16:41
 */

namespace Registry\Heartbeats;

use Registry\Contracts\HeartbeatsInterface;
use Registry\Contracts\NodeAbstract;

/**
 * 心跳检测
 *
 * Class Heartbeats
 * @package Registry\Heartbeats
 */
class Heartbeats implements HeartbeatsInterface
{
    /**
     * @param NodeAbstract $node
     */
    public function start(NodeAbstract $node)
    {
        $this->heartbeats($node);
    }

    /**
     * @param NodeAbstract $node
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function die(NodeAbstract $node)
    {
        registry()->remove($node);
    }

    /**
     * @param NodeAbstract $node
     */
    public function heartbeats(NodeAbstract $node)
    {
        swoole_timer_after(5000, function () use ($node) {
            if (!$this->isAlive($node)) {
                $this->die($node);
            }
        });
    }

    /**
     * @param NodeAbstract $node
     * @return bool
     * @throws \Psr\Cache\InvalidArgumentException
     */
    protected function isAlive(NodeAbstract $node)
    {
        $data = registry()->getNode($node->fd());
        if (isset($data['check'])) {
            if (time() > $data['check']['time'] + $data['check']['ttl']) {
                return false;
            }
        }
        return true;
    }
}
