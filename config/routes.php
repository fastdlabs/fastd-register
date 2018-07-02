<?php

route()->group('/v1/services',function (){
    route()->get('/', 'CatalogController@index');
    route()->get('/{service}', 'CatalogController@show');
    route()->post('/','CatalogController@store');
    route()->delete('/{service}','CatalogController@delete');
    route()->put('/{service}','CatalogController@update');
});
