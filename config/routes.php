<?php

route()->group('/v1/services',function (){
    route()->get('/', 'ServiceController@index');
    route()->get('/{service}', 'ServiceController@show');
    route()->post('/','ServiceController@store');
    route()->delete('/{service}','ServiceController@delete');
    route()->put('/{service}','ServiceController@update');
});
