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
     * @param NodeAbstract $node
     * @return NodeAbstract
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function store(NodeAbstract $node)
    {
        $item = cache()->getItem('map.'.$node->fd());

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
        $key = 'map.'.$node->fd();

        $item = cache()->getItem($key);

        if ($item->isHit()) {
            cache()->deleteItem($key);
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
