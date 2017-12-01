<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

namespace Register;


use FastD\Packet\Json;
use InvalidArgumentException;

/**
 * Class Node
 * @package Register
 */
class Node
{
    const NODE_PREFIX = 'node.';
    const NODES = 'nodes';

    /**
     * @var \Symfony\Component\Cache\Adapter\AbstractAdapter
     */
    protected $store = null;

    public function __construct()
    {
        $this->store = cache();
    }

    /**
     * @return array
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public function collection()
    {
        $nodes = cache()->getItem(static::NODES);
        $services = [];
        if (null !== $nodes = $nodes->get()) {
            $nodes = Json::decode($nodes);
            foreach ($nodes as $node) {
                $node = cache()->getItem('node.'.$node)->get();
                if (null !== $node) {
                    $services[] = Json::decode($node);
                }
            }
        }
        return $services;
    }

    /**
     * @param $node
     * @return array
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public function get($node)
    {
        $node = $this->store->getItem(static::NODE_PREFIX.$node);

        if (!($node->isHit())) {
            throw new InvalidArgumentException(sprintf('Node %s is unregistered', $node->getKey()));
        }

        return Json::decode($node->get());
    }

    /**
     * @param $node
     * @param array $info
     * @return $this
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public function add($node, array $info = [])
    {
        $node = $this->store->getItem(static::NODE_PREFIX.$node);
        $nodeInfo = [];
        if ($node->isHit()) {
            $nodeInfo = Json::decode($node->get());
        }
        if (!empty($info) || isset($info['host'])) {
            $hosts = [];
            if (isset($nodeInfo[0]['host'])) {
                $hosts = array_column($nodeInfo, 'host');
            }
            if (empty($hosts) || !in_array($info['host'], $hosts)) {
                array_push($nodeInfo, $info);
            }
        }
        $node->set(Json::encode($nodeInfo));
        $this->store->save($node);
        return $this;
    }

    /**
     * @param $node
     * @param $host
     * @return $this
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public function reject($node, $host)
    {
        $node = $this->store->getItem(static::NODE_PREFIX.$node);
        if ($node->isHit()) {
            $nodeInfo = Json::decode($node->get());
            $hosts = array_column($nodeInfo, 'host');
            $index = array_search($host, $hosts);
            unset($nodeInfo[$index]);
            $node->set(Json::encode($nodeInfo));
            cache()->save($node);
        }
        return $this;
    }

    /**
     * @param $node
     * @return $this
     */
    public function remove($node)
    {
        $node = cache()->getItem(static::NODE_PREFIX.$node);
        if ($node->isHit()) {
            cache()->deleteItem(static::NODE_PREFIX.$node->getKey());
        }

        return $this;
    }
}