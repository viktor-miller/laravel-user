<?php

namespace ViktorMiller\LaravelUser;

use Closure;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
interface BrokerManagerInterface
{
    /**
     * 
     * @param  string $name
     * @return BrokerInterface
     */
    public function broker($name = 'default');
    
    /**
     * 
     * @param  string $name
     * @param  Closure $callback
     * @return BrokerManagerInterface
     */
    public function extend($name, Closure $callback);
}
