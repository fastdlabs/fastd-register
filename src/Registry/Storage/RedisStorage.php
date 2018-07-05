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
        $this->prefix = $config['prefix'];

        $this->client = new Client($config['connections']);
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

        if (false === $this->client->hset($key, $hashKey, $node->toJson())) {
            abort('save failed', 500);
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
            return $this->client->hdel($key, [$node->hash()]);
        }

        // remove key
        return $this->client->del([$node->service()]);
    }

    /**
     * @param $key
     * @return array|NodeAbstract
     * @throws \Exception
     */
    public function fetch($key)
    {
        $key = $this->getKey($key);

        if (!$this->client->exists($key)) {
            abort('http not found', 404);
        }

        $nodes = [];
        foreach ($this->client->hgetall($key) as $value) {
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

        while ($keys = $this->client->keys($this->prefix . '*')) {
            foreach ($keys as $key) {
                foreach ((array)$this->client->hgetall($key) as $value) {
                    $nodes[str_replace($this->prefix, '', $key)][] = json_decode($value, true);
                }
            }

            return $nodes;
        }

        return [];
    }
}
