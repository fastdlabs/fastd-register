<?php

route()->group('/v1',function (){
    route()->group('/catalog',function (){
        route()->post('/service','CatalogController@post');
        route()->delete('/service','CatalogController@delete');
        route()->patch('/service','CatalogController@patch');
        route()->get('/services', 'CatalogController@list');
        route()->get('/service/{service}', 'CatalogController@show');
    });
});

