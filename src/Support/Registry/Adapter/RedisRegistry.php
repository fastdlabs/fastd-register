<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 14:03
 */

namespace Support\Registry\Adapter;


use Support\Registry\RegistryEntity;

class RedisRegistry implements RegistryInterface
{
    /**
     * @var \Redis
     */
    protected $redis;

    protected $config;

    protected $prefix = 'fastd.registry.';

    public function __construct($config)
    {
        $this->redis = new \Redis();

        $this->redis->connect($config['host'], $config['port']);

        if (isset($config['auth']) && $config['auth']) {
            $this->redis->auth($config['auth']);
        }
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
    public function register(RegistryEntity $entity)
    {
        $registry = $entity->toArray();

        $this->redis->hSet($this->getPrefix() . "{$registry['service']}", "{$registry['node']}", $entity->toJson());
    }

    /**
     * @param RegistryEntity $entity
     */
    public function deRegister(RegistryEntity $entity)
    {
        $this->list();

        $registry = $entity->toArray();

        $this->redis->hDel($this->getPrefix() . "{$registry['service']}", "{$registry['node']}");
    }

    /**
     * @return array
     */
    public function list()
    {
        $this->redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY);

        $iterator = null;
        while ($keys = $this->redis->scan($iterator, $this->getPrefix() . '*')) {
            foreach ($keys as $key) {
                $services[] = str_replace($this->getPrefix(), '', $key);
            }
        }
        return $services ?? [];
    }

    /**
     * @param $service
     * @return array
     */
    public function show($service)
    {
        $service = $this->getPrefix() . $service;

        if (!$this->redis->exists($service)) {
            return ["nodes" => []];
        }

        $nodes = $this->redis->hGetAll($service);

        foreach ($nodes as $node => $data) {
            $nodes[$node] = json_decode($data, true);
        }
        return ["nodes" => $nodes];
    }
}
