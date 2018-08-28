<?php
/**
 * @author: ZhaQiu <34485431@qq.com>
 * @time: 2018/6/29
 */

namespace Registry\Contracts;

use FastD\Utils\ArrayObject;

abstract class NodeAbstract extends ArrayObject implements NodeInterface
{
    /**
     * @return string
     */
    public function hash()
    {
        return $this->get('hash');
    }

    /**
     * @return string
     */
    public function service()
    {
        return $this->get('service_name');
    }

    /**
     * @return string
     */
    public function pid()
    {
        return $this->get('pid');
    }

    /**
     * @return string
     */
    public function host()
    {
        return $this->get('service_host');
    }

    /**
     * @return integer
     */
    public function fd()
    {
        return $this->get('fd');
    }

    /**
     * @return string
     */
    public function port()
    {
        return $this->get('service_port');
    }

    /**
     * @return string
     */
    public function extra()
    {
        return $this->get('extra');
    }

    /**
     * @return array
     */
    public function check()
    {
        return $this->get('check');
    }

    public function toJson()
    {
        return json_encode($this->getArrayCopy());
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }
}
