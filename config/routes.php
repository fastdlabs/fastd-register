<?php

route()->group('/v1',function (){
    route()->group('/catalog',function (){
        route()->get('/services', 'CatalogController@list');
        route()->get('/services/{service}', 'CatalogController@show');
        route()->post('/services','CatalogController@post');
        route()->delete('/services/{service}','CatalogController@delete');
        route()->patch('/services/{service}','CatalogController@patch');
    });
});

