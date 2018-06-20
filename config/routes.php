<?php

route()->get('/v1/catalog/services', 'CatalogController@list');
route()->get('/v1/catalog/service/{service}', 'CatalogController@show');
