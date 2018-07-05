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
 *
 * @method NodeAbstract store(NodeAbstract $node)
 * @method bool         remove(NodeAbstract $node)
 * @method array        fetch(string $key)
 * @method array        all()
 *
 * @package Registry
 */
class Registry
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
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (!in_array($name, ['store', 'remove', 'fetch', 'all'])) {
            $class = get_class($this);

            abort("Call to undefined method {$class}::{$name}()", 500);
        }

        return call_user_func_array([$this->driver, $name], $arguments);
    }
}
