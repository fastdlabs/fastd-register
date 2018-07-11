<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 14:03
 */

namespace Registry\Storage;

use Registry\Contracts\NodeAbstract;
use Registry\Contracts\StorageInterface;
use Predis\Client;

/**
 * Class clientStorage
 * @package Registry\Adapter
 */
class RedisStorage implements StorageInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $prefix = '';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * clientStorage constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->prefix = isset($config['prefix']) ? $config['prefix'] : StorageInterface::PREFIX;

        $this->client = new Client($config['connections']);
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        if (false === $this->client->ping()) {
            $this->client->connect();
        }

        return $this->client;
    }

    /**
     * @param $key
     * @return string
     */
    public function getKey($key)
    {
        return $this->prefix . $key;
    }

    /**
     * @param NodeAbstract $node
     * @return NodeAbstract
     * @throws \Exception
     */
    public function store(NodeAbstract $node)
    {
        $key = $this->getKey($node->service());
        $hashKey = $node->hash();

        if (false === $this->getClient()->hset($key, $hashKey, $node->toJson())) {
            abort(500,'save failed');
        }

        return $node;
    }

    /**
     * @param NodeAbstract $node
     * @return bool|int
     */
    public function remove(NodeAbstract $node)
    {
        $key = $this->getKey($node->service());

        // remove hash item
        if ($node->has('hash') && !empty($node->hash())) {
            return $this->getClient()->hdel($key, [$node->hash()]);
        }

        // remove key
        return $this->getClient()->del([$node->service()]);
    }

    /**
     * @param $key
     * @return array|NodeAbstract
     * @throws \Exception
     */
    public function fetch($key)
    {
        $key = $this->getKey($key);

        if (!$this->getClient()->exists($key)) {
            abort(404, 'http not found');
        }

        $nodes = [];
        foreach ($this->getClient()->hgetall($key) as $value) {
            $nodes[] = json_decode($value, true);
        }

        return $nodes;
    }

    /**
     * @return array
     */
    public function all()
    {
        $nodes = [];

        while ($keys = $this->getClient()->keys($this->prefix . '*')) {
            foreach ($keys as $key) {
                foreach ((array)$this->getClient()->hgetall($key) as $value) {
                    $nodes[str_replace($this->prefix, '', $key)][] = json_decode($value, true);
                }
            }

            return $nodes;
        }

        return [];
    }
}
