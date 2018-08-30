<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/8/23
 * Time: 16:38
 */

namespace Registry\Contracts;

/**
 * Interface HeartbeatsInterface
 * @package Registry\Contracts
 */
interface HeartbeatsInterface
{
    /**
     * @param NodeAbstract $node
     */
    public function heartbeats(NodeAbstract $node);

    /**
     * @param NodeAbstract $node
     */
    public function start(NodeAbstract $node);

    /**
     * @param NodeAbstract $node
     */
    public function die(NodeAbstract $node);
}
