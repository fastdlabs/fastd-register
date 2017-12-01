<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

namespace Testing;

use FastD\TestCase;
use Register\Node;

class NodeTest extends TestCase
{
    /**
     * @throws \FastD\Packet\Exceptions\PacketException
     */
    public function testNodeAdd()
    {
        Node::set([
            'name' => '',
        ]);
    }
}
