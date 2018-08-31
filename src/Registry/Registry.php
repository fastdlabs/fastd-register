<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 16:08
 */

namespace Registry;

use Registry\Contracts\NodeAbstract;
use Registry\Contracts\StorageInterface;
use Registry\Node\ServiceNode;

/**
 * Class Registry
 * @package Registry
 */
class Registry implements StorageInterface
{
    /**
     * @var StorageInterface
     */
    protected $driver;

    /**
     * Registry constructor.
     * @param null $config
     */
    public function __construct($config = null)
    {
        !is_null($config) && $this->setDriver($config);
    }

    /**
     * @param $config
     */
    protected function setDriver($config)
    {
        if (!isset($config['driver'])) {
            throw new \RuntimeException('Cannot be use register driver.');
        }

        $driver = ucfirst($config['driver']);

        if (!class_exists($config['driver'])) {
            throw new \LogicException(sprintf('Cannot support register driver %s', $driver));
        }

        $this->driver = new $driver($config['options']);
    }

    /**
     * @param $fd
     * @return mixed|\Symfony\Component\Cache\CacheItem
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getItem($fd)
    {
        return cache()->getItem('map.' . $fd);
    }

    /**
     * @param $fd
     * @return bool|ServiceNode
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getNode($fd)
    {
        $item = $this->getItem($fd);

        if ($item->isHit()) {
            $nodeInfo = $item->get();
            return ServiceNode::make([
                'service_name' => $nodeInfo['service_name'],
                'hash' => $nodeInfo['hash'],
                //'check' => $nodeInfo['check'],
            ]);
        }

        return false;
    }

    /**
     * @param NodeAbstract $node
     * @return NodeAbstract
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function store(NodeAbstract $node)
    {
        $item = $this->getItem($node->fd());

        $item->set($node->toArray());

        cache()->save($item);

        return $this->driver->store($node);
    }

    /**
     * @param NodeAbstract $node
     * @return bool
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function remove(NodeAbstract $node)
    {
        $item = registry()->getItem($node->fd());

        if ($item->isHit()) {
            cache()->deleteItem($item->getKey());
        }

        return $this->driver->remove($node);
    }

    /**
     * @param $key
     * @return array
     */
    public function fetch($key)
    {
        return $this->driver->fetch($key);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->driver->all();
    }
}
