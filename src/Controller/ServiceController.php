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
     * @return Response
     * @throws \Exception
     */
    public function store(ServerRequest $request)
    {
        $data = validator($request->getParsedBody());

        $node = registry()->store(ServiceNode::make($data));

        return json($node->toArray(), Response::HTTP_CREATED);
    }

    /**
     * @param ServerRequest $request
     * @return Response
     * @throws \Exception
     */
    public function update(ServerRequest $request)
    {
        $data = validator($request->getParsedBody());

        $node = ServiceNode::make($data);
        $node->set('hash', $request->getAttribute('service'));

        $node = registry()->store($node);

        return json($node->toArray());
    }

    /**
    /**
     * @param ServerRequest $request
     * @return Response
     * @throws \Exception
     */
    public function delete(ServerRequest $request)
    {
        $node = ServiceNode::make([
            'hash' => $request->getAttribute('node'),
            'service_name' => $request->getAttribute('service')
        ]);

        registry()->remove($node);

        return json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function index(ServerRequest $request)
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
