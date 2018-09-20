<?php
/**
 * @author    fastdlabs
 * @copyright 2018
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */
namespace Controller;

use FastD\Http\Response;
use FastD\Http\ServerRequest;
use Registry\Node\ServiceNode;

/**
 * Class CatalogController
 * @package Controller
 */
class ServiceController
{
    /**
     * @param ServerRequest $request
     * @return string
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Exception
     */
    public function store(ServerRequest $request)
    {
        $data = validator($request->getParsedBody());

        registry()->store(ServiceNode::make($data));

        // (new Heartbeats())->start($node);

        return \response()->withContent('ok')->withStatus(Response::HTTP_CREATED);
    }

    /**
     * @param ServerRequest $request
     * @return string
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Exception
     */
    public function update(ServerRequest $request)
    {
        $data = validator($request->getParsedBody());

        $node = ServiceNode::make($data);
        $node->set('hash', $request->getAttribute('service'));

        registry()->store($node);

        return \response()->withContent('ok');
    }

    /**
     * @param ServerRequest $request
     * @return string
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function delete(ServerRequest $request)
    {
        $node = ServiceNode::make([
            'service_name' => $request->getAttribute('service'),
            'hash' => $request->getAttribute('node'),
        ]);

        registry()->remove($node);

        return \response()->withContent('ok')->withStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * @return Response
     */
    public function index()
    {
        return json(registry()->all());
    }

    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function show(ServerRequest $request)
    {
        $service = $request->getAttribute('service');

        return json(registry()->fetch($service));
    }
}
