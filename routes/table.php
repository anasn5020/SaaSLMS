<?php

use Illuminate\Support\Facades\Route;


Route::get('/table/{table_name}', 'Api\TableApiController@tableData');

