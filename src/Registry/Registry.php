<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 16:08
 */

namespace Registry;

/**
 * Class Registry
 * @package Registry
 */
class Registry implements RegistryInterface
{
    /**
     * @var RegistryInterface
     */
    protected  $registry;

    /**
     * Registry constructor.
     */
    public function __construct()
    {
        $registry_config = config()->get('registry');

        if (!isset($registry_config['driver'])) {
            throw new \RuntimeException('Cannot be use register driver.');
        }

        $driver = ucfirst($registry_config['driver']);

        if (!class_exists($driver)) {
            return new \LogicException(sprintf('Cannot support register driver %s', $driver));
        }

        $this->registry = new $driver($registry_config['options']);
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return static::REGISTRY_PREFIX;
    }

    /**
     * @param $key
     * @return string
     */
    public function getKey($key)
    {
        return $this->getPrefix() . $key;
    }

    /**
     * @param Node $node
     * @return Node
     */
    public function register(Node $node)
    {
        return $this->registry->register($node);
    }

    /**
     * @param Node $entity
     * @return mixed
     */
    public function unregister(Node $entity)
    {
        return $this->registry->unregister($entity);
    }

    /**
     * @return Node[]
     */
    public function list()
    {
        return $this->registry->list();
    }

    /**
     * @param $service
     * @return array
     */
    public function show($service)
    {
        return $this->registry->show($service);
    }
}