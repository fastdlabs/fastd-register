<?php

namespace Controller;


use FastD\Http\Response;
use FastD\Http\ServerRequest;
use Registry\Node;
use Runner\Validator\Validator;
use Support\Registry\RegistryEntity;

/**
 * Class CatalogController
 * @package Controller
 */
class CatalogController
{
    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function create(ServerRequest $request)
    {
        $data = $request->getParsedBody();

        $rules = [
            'service_host' => 'required|url',
            'service_name' => 'required|string',
            'service_pid' => 'required|numeric',
        ];

        $validator = new Validator($data, $rules);
        $validator->validate();
        $node = registry()->register(Node::make($validator->data()));
        return json($node->getArrayCopy(), Response::HTTP_CREATED);
    }

    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function patch(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $rules = [
            'service_host' => 'required|url',
            'service_name' => 'required|string',
            'service_pid' => 'required|numeric',
        ];

        $validator = new Validator($data, $rules);
        $validator->validate();
        $node = registry()->register(Node::make($validator->data()));
        return json($node->getArrayCopy());
    }

    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function delete(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $rules = [
            'service_host' => 'required|url',
            'service_name' => 'required|string',
            'service_pid' => 'required|numeric',
        ];

        $validator = new Validator($data, $rules);
        $validator->validate();
        registry()->unregister(Node::make($validator->data()));
        return json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function list(ServerRequest $request)
    {
        return json(registry()->list());
    }

    /**
     * @param ServerRequest $request
     * @return Response
     */
    public function show(ServerRequest $request)
    {
        $service = $request->getAttribute('service');
        return json(registry()->show($service));
    }
}