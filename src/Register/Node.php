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

/**
 * Class Node
 * @package Register
 */
class Node
{
    const NODE_KEY = 'nodes';

    /**
     * @return array
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public static function collection()
    {
        $nodes = cache()->getItem(static::NODE_KEY);
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
     * @param array $nodeInfo
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public static function set(array $nodeInfo = [])
    {
        if (!isset($nodeInfo['name'])) {
            throw new \InvalidArgumentException('node name is undefined.');
        }

        $nodes = cache()->getItem(static::NODE_KEY);

        if (null !== ($values = $nodes->get())) {
            $values = Json::decode($values);
            array_push($values, $nodeInfo['name']);
            $values = array_unique($values);
        } else {
            $values = [$nodeInfo['name']];
        }
        $nodes->set(Json::encode($values));

        $node = cache()->getItem('node.' . $nodeInfo['name']);
        $node->set(Json::encode($nodeInfo));

        static::map($nodeInfo['fd'], $nodeInfo['name']);
        cache()->save($nodes);
        cache()->save($node);
    }

    /**
     * @param $node
     * @return array
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public static function get($node)
    {
        $node = cache()->getItem('node.'.$node);

        if (!($node->isHit())) {
            throw new \InvalidArgumentException(sprintf('Node %s is unregistered', $node->getKey()));
        }

        return Json::decode($node->get());
    }

    /**
     * @param $fd
     * @param $name
     * @return bool|mixed
     */
    public static function map($fd, $name = null)
    {
        $node = cache()->getItem('node.'.$fd);

        if (null === $name) {
            return $node->get();
        }
        $node->set($name);
        return cache()->save($node);
    }

    /**
     * @param $name
     */
    public static function delete($name)
    {
        $node = cache()->getItem('node.'.$name);
        if ($node->isHit()) {
            cache()->deleteItems([$node]);
        }
    }

    public function add($node, array $info = [])
    {}

    public function reject($node, $host)
    {}

    public function remove($node)
    {}
}