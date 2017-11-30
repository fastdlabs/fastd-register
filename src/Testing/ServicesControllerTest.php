<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Testing;

use Controller\ServicesController;
use FastD\TestCase;

class ServicesControllerTest extends TestCase
{
    public function testCreateServiceNode()
    {
        $request = $this->request('POST', '/services');
        $response = $this->handleRequest($request, [
            'name'   => 'testing',
            'pid'       => 0,
            'sock'      => 'tcp',
            'host'      => '127.0.0.1',
            'port'      => '9876',
            'stats'     => [
                'connections' => 100
            ],
            'error'     => 0,
            'time'      => time()
        ]);
        $this->handleRequest($request, [
            'name'   => 'testing2',
            'pid'       => 0,
            'sock'      => 'tcp',
            'host'      => '127.0.0.1',
            'port'      => '9877',
            'stats'     => [
                'connections' => 100
            ],
            'error'     => 0,
            'time'      => time()
        ]);
//        echo $response;
    }

    public function testRegisteredServiceNodes()
    {
        $request = $this->request('GET', '/services');
        $response = $this->handleRequest($request);
        echo $response;
    }
}
