<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

$router->get('console',  '\Teepluss\Console\Http\Controllers\ConsoleController@getIndex');
$router->post('console', [
    'as' => 'console_execute',
    'uses' => '\Teepluss\Console\Http\Controllers\ConsoleController@postExecute'
]);
