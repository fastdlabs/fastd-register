<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/8/23
 * Time: 16:38
 */

namespace Registry\Heartbeats;


use Registry\Contracts\NodeAbstract;

interface HeartbeatsInterface
{
    public function heartbeats(NodeAbstract $node);

    public function start(NodeAbstract $node);

    public function die(NodeAbstract $node);
}