<?php

namespace Controller;


use FastD\Http\Response;
use FastD\Http\ServerRequest;
use Runner\Validator\Validator;
use Support\Registry\RegistryEntity;

class CatalogController
{
    public function create(ServerRequest $request)
    {
        $data = $request->getQueryParams();
        $rules = [
            'service_host' => 'required|url',
            'service_name' => 'required|string',
            'service_pid' => 'required|numeric',
        ];

        $validator = new Validator($data, $rules);
        $validator->validate();
        registry()->register(new RegistryEntity($validator->data()));
        return json([], Response::HTTP_CREATED);
    }

    public function patch(ServerRequest $request)
    {
        $data = $request->getQueryParams();
        $rules = [
            'service_host' => 'required|url',
            'service_name' => 'required|string',
            'service_pid' => 'required|numeric',
        ];

        $validator = new Validator($data, $rules);
        $validator->validate();
        registry()->register(new RegistryEntity($validator->data()));
        return json([]);
    }

    public function delete(ServerRequest $request)
    {
        $data = $request->getQueryParams();
        $rules = [
            'service_host' => 'required|url',
            'service_name' => 'required|string',
            'service_pid' => 'required|numeric',
        ];

        $validator = new Validator($data, $rules);
        $validator->validate();
        registry()->deRegister(new RegistryEntity($validator->data()));
        return json([], Response::HTTP_NO_CONTENT);
    }

    public function list(ServerRequest $request)
    {
        return json(registry()->list());
    }

    public function show(ServerRequest $request)
    {
        $service = $request->getAttribute('service');
        return json(registry()->show($service));
    }
}