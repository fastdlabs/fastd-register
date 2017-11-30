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

class Node
{
    const NODE_KEY = 'nodes';

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

        cache()->save($nodes);
        cache()->save($node);
    }

    public static function get($node)
    {
        $node = cache()->getItem('node.'.$node);

        if (!($node->isHit())) {
            throw new \InvalidArgumentException(sprintf('Node %s is unregistered', $node->getKey()));
        }

        return Json::decode($node->get());
    }
}