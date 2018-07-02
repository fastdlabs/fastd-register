<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/22
 * Time: 14:10
 */
namespace Support\Common;

/**
 * Class Zookeeper
 * @package Support\Common
 */
class Zookeeper
{
    /**
     * @var \Zookeeper
     */
    public $zookeeper;

    /**
     * Zookeeper constructor.
     * @param $address
     */
    public function __construct($address)
    {
        $this->zookeeper = new \Zookeeper($address);
    }

    /**
     * @param $path
     * @param string $default
     * @return string
     */
    public function get($path, $default = '')
    {
        if (!$this->zookeeper->exists($path)) {
            return $default;
        }
        return $this->zookeeper->get($path);
    }

    /**
     * @param $path
     * @param $value
     */
    public function set($path, $value)
    {
        if (!$this->zookeeper->exists($path)) {
            $this->makePath($path);
            $this->makeNode($path, $value);
        } else {
            $this->zookeeper->set($path, $value);
        }
    }

    /**
     * @param $path
     * @param array $default
     * @return array
     */
    public function getChildren($path, $default = [])
    {

        if (strlen($path) > 1 && preg_match('@/$@', $path)) {
            $path = substr($path, 0, -1);
        }

        if (!$this->zookeeper->exists($path)) {
            return $default;
        }

        return $this->zookeeper->getChildren($path);
    }

    /**
     * @param $path
     * @return bool|null
     */
    public function deleteNode($path)
    {
        if (!$this->zookeeper->exists($path)) {
            return null;
        } else {
            return $this->zookeeper->delete($path);
        }
    }

    /**
     * @param $path
     * @param string $value
     */
    public function makePath($path, $value = '')
    {
        $parts = explode('/', $path);
        $parts = array_filter($parts);
        $nodePath = '';
        while (count($parts) > 1) {
            $nodePath .= '/' . array_shift($parts);
            if (!$this->zookeeper->exists($nodePath)) {
                $this->makeNode($nodePath, $value);
            }
        }
    }

    /**
     * @param $path
     * @param $value
     * @param array $params
     * @return string
     */
    public function makeNode($path, $value, array $params = array())
    {
        if (empty($params)) {
            $params = [
                [
                    'perms' => \Zookeeper::PERM_ALL,
                    'scheme' => 'world',
                    'id' => 'anyone',
                ]
            ];
        }
        return $this->zookeeper->create($path, $value, $params);
    }
}
