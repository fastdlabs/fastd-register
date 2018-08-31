<?php

use FastD\Http\Response;

route()->group('/services', function (){
    route()->get('/', 'ServiceController@index');
    route()->get('/{service}', 'ServiceController@show');
    route()->post('/','ServiceController@store');
    route()->delete('/{service}/[{node}]','ServiceController@delete');
    route()->put('/{service}','ServiceController@update');
});

route()->head('/heart-beats', function () {
    return new Response('ok');
});
route()->get('/heart-beats', function () {
    return new Response('ok');
});
