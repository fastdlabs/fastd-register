<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 14:28
 */

namespace Registry;


use FastD\Utils\ArrayObject;

/**
 * Class Node
 * @package Registry
 */
class Node extends ArrayObject
{
    /**
     * The node unique hash.
     *
     * @var string
     */
    protected $hash;

    /**
     * Node constructor.
     * @param array $input
     * @param int $flags
     * @param string $iterator_class
     */
    public function __construct($input = array(), $flags = 0, $iterator_class = "ArrayIterator")
    {
        parent::__construct($input, $flags, $iterator_class);

        $info = parse_url($this->getHost());

        if (isset($info['port']) && !$this->has('service_port')) {
            $this->set('service_port', $info['port']);
        }

        $this->hash = md5($this->getHost().$this->getPort());
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->get('service_name');
    }

    /**
     * @return string
     */
    public function getPid()
    {
        return $this->get('pid');
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->get('service_host');
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->get('service_port');
    }

    /**
     * @return string
     */
    public function getExtra()
    {
        return $this->get('extra');
    }

    public function json()
    {
        return json_encode($this->getArrayCopy());
    }
}