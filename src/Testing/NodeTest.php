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

class NodeTest extends TestCase
{
    public function testNodeAdd()
    {
        $node = node()->add('demo')->get('demo');
        $this->assertEmpty($node);
    }

    public function testNodeAddInfo()
    {
        $node = node()->add('service', [
            'name' => 'demo',
            'host' => '127.0.0.1',
        ])->get('service');

        $this->assertEquals([[
            'name' => 'demo',
            'host' => '127.0.0.1'
        ]], $node);
    }

    public function testNodeReject()
    {
        $node = node()->reject('service', '127.0.0.1')->get('service');
        $this->assertEmpty($node);
    }

    public function testNodeDelete()
    {
        node()->remove('service');
    }

    public function testNodeCollection()
    {

    }
}
