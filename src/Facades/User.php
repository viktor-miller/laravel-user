<?php

namespace ViktorMiller\LaravelUser\Facades;

use Illuminate\Support\Facades\Facade;
use ViktorMiller\LaravelUser\BrokerManagerInterface;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
class User extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BrokerManagerInterface::class;
    }
}
