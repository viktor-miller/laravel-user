<?php

namespace ViktorMiller\LaravelUser;

use Illuminate\Support\Facades\Route;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
class Broker implements BrokerInterface
{    
    /**
     * 
     * @param  string $password
     * @return string
     */
    public function cryptPassword($password)
    {
        return bcrypt($password);
    }
    
    /**
     * Init base user routes
     * 
     * @return void
     */
    public function routes()
    {
        Route::prefix('user')->namespace('User')->group(function(){
            Route::get('/', 'DataController@index');
            Route::get('/data', 'DataController@index');
            Route::post('/data', 'DataController@handle');
            Route::get('/email', 'EmailController@index');
            Route::post('/email', 'EmailController@handle');
            Route::get('/delete', 'DeleteController@index');
            Route::post('/delete', 'DeleteController@handle');
            Route::get('/password', 'PasswordController@index');
            Route::post('/password', 'PasswordController@handle');
        });
    }
}
