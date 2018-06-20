<?php

namespace Controller;


use FastD\Http\Response;
use FastD\Http\ServerRequest;

class CatalogController
{
    public function create(ServerRequest $request)
    {
        return json([]);
    }

    public function patch(ServerRequest $request)
    {
        return json([]);
    }

    public function delete(ServerRequest $request)
    {
        return json([]);
    }

    public function find(ServerRequest $request)
    {
        return json([]);
    }

    public function select(ServerRequest $request)
    {
        return json([]);
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