<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Controller;


use FastD\Http\Response;
use FastD\Http\ServerRequest;
use FastD\Packet\Json;

/**
 * Class ServicesController
 * @package Controller
 */
class ServicesController
{
    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function collections(ServerRequest $request)
    {
        $nodes = cache()->getItem('nodes');
        $services = [];
        if (null !== $nodes = $nodes->get()) {
            $nodes = Json::decode($nodes);
            foreach ($nodes as $node) {
                $node = cache()->getItem('node.'.$node)->get();
                if (null !== $node) {
                    $services[] = Json::decode($node);
                }
            }
        }

        return json($services);
    }

    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function query(ServerRequest $request)
    {
        $node = $request->getAttribute('name');

        $node = cache()->getItem('node.'.$node)->get();

        if (null === $node) {
            abort(404, sprintf('Service %s is not found', $node));
        }

        $node = Json::decode($node);

        return json($node);
    }

    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function node(ServerRequest $request)
    {
        $nodeInfo = $request->getParsedBody();

        $nodes = cache()->getItem('nodes');

        if (null !== ($values = $nodes->get())) {
            $values = Json::decode($values);
            array_push($values, $nodeInfo['name']);
            $values = array_unique($values);
        } else {
            $values = [$nodeInfo['name']];
        }
        $nodes->set(Json::encode($values));

        $node = cache()->getItem('node.' . $nodeInfo['name']);
        $node->set(Json::encode($nodeInfo));

        cache()->save($nodes);
        cache()->save($node);

        return json($nodeInfo, Response::HTTP_CREATED);
    }
}