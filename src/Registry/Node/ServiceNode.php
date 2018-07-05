<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/15
 * Time: 14:28
 */

namespace Registry\Node;

use Registry\Contracts\NodeAbstract;

/**
 * Class ServiceNode
 * @package Registry
 */
class ServiceNode extends NodeAbstract
{
    /**
     * ServiceNode constructor.
     * @param array $input
     * @param int $flags
     * @param string $iterator_class
     */
    public function __construct($input = array(), $flags = 0, $iterator_class = "ArrayIterator")
    {
        if (!isset($input['hash'])) {
            $input['hash'] =  md5(json_encode($input));
        }

        parent::__construct($input, $flags, $iterator_class);

        if ($this->has('service_host')) {
            $info = parse_url($this->host());

            if (isset($info['port']) && !$this->has('service_port')) {
                $this->set('service_port', $info['port']);
            }
        }
    }

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
