<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2018
 *
 * @see      https://www.github.com/fastdlabs
 * @see      http://www.fastdlabs.com/
 */

namespace Testing;

use Controller\ServiceController;
use FastD\Http\Response;
use FastD\TestCase;

class ServiceControllerTest extends TestCase
{
    protected $request_data = [
        'service_name' => 'phpunit',
        'service_host' => 'http://127.0.0.1',
        'service_protocol' => '',
        'service_port' => '',
        'service_pid' => '',
        'process_number' => '',
        'service' => [
            'options' => []
        ],
        'status' => 'testing',
    ];

    protected $request_update_data = [
        'service_name' => 'phpunit',
        'service_host' => 'tcp://127.0.0.1',
        'service_protocol' => '',
        'service_port' => '',
        'service_pid' => '',
        'process_number' => '',
        'service' => [
            'options' => []
        ],
        'status' => 'running',
    ];

    public function testStore()
    {
        $data = $data2 = $this->request_data;
        $data2['service_host'] = 'ws://127.0.0.1';

        $request = $this->request('POST', '/services');
        $response = $this->handleRequest($request, $data);
        echo  11;exit();


        $this->equalsStatus($response, Response::HTTP_CREATED);
        echo  11;

        $response = $this->handleRequest($request, $data2);
        $this->equalsStatus($response, Response::HTTP_CREATED);

        $request = $this->request('GET', '/services');
        $response = $this->handleRequest($request);
        $this->equalsJsonResponseHasKey($response, 'phpunit');
        $this->equalsResponseCount($response, 1);
    }

    public function testUpdate()
    {
        // 9fcaafe4a5953dfe59b0eb474de29709 为测试案例的请求代码hash
        $request = $this->request('PUT', '/services/04d6f7046e0834d0ac73379ab83bda16');
        $response = $this->handleRequest($request, $this->request_update_data);

        $this->equalsStatus($response, Response::HTTP_OK);
        $this->assertEquals($response->toArray()['status'], 'running');
    }

    public function testDelete()
    {
        $request = $this->request('DELETE', '/services/phpunit/04d6f7046e0834d0ac73379ab83bda16');
        $response = $this->handleRequest($request);
        $this->equalsStatus($response, Response::HTTP_NO_CONTENT);

        $request = $this->request('DELETE', '/services/phpunit');
        $response = $this->handleRequest($request);
        $this->equalsStatus($response, Response::HTTP_NO_CONTENT);

        $request = $this->request('GET', '/services');
        $response = $this->handleRequest($request);
        $this->equalsJson($response, []);
    }

    public function testShow()
    {

    }

    public function testIndex()
    {

    }
}
