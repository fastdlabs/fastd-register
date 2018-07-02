<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20
 * Time: 15:13
 */

namespace Support\Registry\Adapter;


use Registry\Contracts\NodeAbstract;
use Registry\Contracts\StorageInterface;
use Registry\Node\ServiceNode;
use Support\Common\Zookeeper;

class ZookeeperStorage implements StorageInterface
{
    /**
     * @var \zookeeper
     */
    protected $zookeeper;

    protected $config;

    protected $prefix = '/fastd/registry';

    public function __construct($config)
    {
        $this->zookeeper = new Zookeeper($config['host'] . ':' . $config['port']);
    }

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param RegistryEntity $entity
     */
    public function unregister(RegistryEntity $entity)
    {
        $registry = $entity->toArray();

        $this->zookeeper->set($this->getPrefix() . "/{$registry['service']}/{$registry['node']}", $entity->toJson());
    }

    /**
     * @param RegistryEntity $entity
     */
    public function deRegister(RegistryEntity $entity)
    {
        $registry = $entity->toArray();

        $this->zookeeper->deleteNode($this->getPrefix() . "/{$registry['service']}/{$registry['node']}");
    }

    /**
     * @return array
     */
    public function list()
    {
        $services = $this->zookeeper->getChildren($this->getPrefix());

        return $services ?? [];
    }

    /**
     * @param $service
     * @return array
     */
    public function show($service)
    {
        $service = $this->getPrefix() . '/' . $service;

        $nodes = $this->zookeeper->getChildren($service);

        foreach ($nodes as $node => $data) {
            $nodes[$node] = json_decode($this->zookeeper->get($service . '/' . $data));
        }
        return ["nodes" => $nodes];
    }

    /**
     * @param ServiceNode $node
     * @return ServiceNode
     */
    public function register(ServiceNode $node)
    {
        // TODO: Implement register() method.
    }

    /**
     * @param NodeAbstract $node
     * @return NodeAbstract
     */
    public function store(NodeAbstract $node)
    {
        // TODO: Implement store() method.
    }

    /**
     * @param NodeAbstract $node
     * @return boolean
     */
    public function remove(NodeAbstract $node)
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param $key
     * @return NodeAbstract
     */
    public function fetch($key)
    {
        // TODO: Implement fetch() method.
    }

    /**
     * @return array
     */
    public function all()
    {
        // TODO: Implement all() method.
    }
}