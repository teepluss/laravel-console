<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Route middleware
	|--------------------------------------------------------------------------
	|
	| Add middleware to protect your "console".
	|
	*/

	'middleware' => ['web', 'console_protect'],

    /*
    |--------------------------------------------------------------------------
    | Console security
    |--------------------------------------------------------------------------
    |
    | Username and password to access your console.
    |
    */

    'credentials' => [
        'username' => env('CONSOLE_USER', 'username'),
        'password' => env('CONSOLE_PASS', 'password')
    ]
);
