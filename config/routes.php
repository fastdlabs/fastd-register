<?php

route()->group('/v1',function (){
    route()->get('/services', 'CatalogController@list');
    route()->get('/services/{service}', 'CatalogController@show');
    route()->post('/services','CatalogController@create');
    route()->delete('/services/{service}','CatalogController@delete');
    route()->put('/services/{service}','CatalogController@patch');
});

