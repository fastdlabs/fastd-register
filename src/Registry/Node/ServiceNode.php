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
     */
    public function __construct($input = array())
    {
        if (!isset($input['hash'])) {
            $input['hash'] =  md5(json_encode($input));
        }

        parent::__construct($input, 0, 'ArrayIterator');

        if ($this->has('service_host')) {
            $info = parse_url($this->host());

            if (isset($info['port']) && !$this->has('service_port')) {
                $this->set('service_port', $info['port']);
            }
        }

        $this->set('fd', server()->getListener('producer')->getFileDescriptor());
    }
}
