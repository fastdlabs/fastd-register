<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/22
 * Time: 14:10
 */

namespace Support\Common;

class Zookeeper
{
    public $zookeeper;

    public function __construct($address) {
        $this->zookeeper = new \Zookeeper($address);
    }

    public function get($path, $default = '') {
        if (!$this->zookeeper->exists($path)) {
            return $default;
        }
        return $this->zookeeper->get($path);
    }

    public function set($path, $value) {
        if (!$this->zookeeper->exists($path)) {
            $this->makePath($path);
            $this->makeNode($path, $value);
        } else {
            $this->zookeeper->set($path, $value);
        }
    }

    public function getChildren($path, $default = []) {

        if (strlen($path) > 1 && preg_match('@/$@', $path)) {
            $path = substr($path, 0, -1);
        }

        if (!$this->zookeeper->exists($path)) {
            return $default;
        }

        return $this->zookeeper->getChildren($path);
    }


    public function deleteNode($path)
    {
        if(!$this->zookeeper->exists($path)) {
            return null;
        } else {
            return $this->zookeeper->delete($path);
        }
    }


    public function makePath($path, $value = '') {
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

    public function makeNode($path, $value, array $params = array()) {
        if (empty($params)) {
            $params = [
                [
                    'perms'  => \Zookeeper::PERM_ALL,
                    'scheme' => 'world',
                    'id'     => 'anyone',
                ]
            ];
        }
        return $this->zookeeper->create($path, $value, $params);
    }


}