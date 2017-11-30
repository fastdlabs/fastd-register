<?php

route()->get('/services', 'ServicesController@collections');
route()->get('/services/{name}', 'ServicesController@query');
route()->post('/services', 'ServicesController@node');
