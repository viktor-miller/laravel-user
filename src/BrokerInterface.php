<?php

namespace ViktorMiller\LaravelUser;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
interface BrokerInterface
{
    /**
     * 
     * @param  string $password
     * @return string
     */
    public function cryptPassword($password);
    
    /**
     * 
     * @return void
     */
    public function routes();
}
