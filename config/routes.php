<?php

route()->get('/', 'ServicesController@collections');
route()->get('/{name}', 'ServicesController@query');
route()->post('/', 'ServicesController@node');
