<?php

namespace ViktorMiller\LaravelUser;

use Closure;
use Illuminate\Foundation\Application;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
class BrokerManager implements BrokerManagerInterface
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The array of created brokers.
     *
     * @var array
     */
    protected $brokers = [];
    
    /**
     * Create a new user broker manager instance.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    /**
     * Attempt to get the broker from the local cache.
     *
     * @param  string  $name
     * @return BrokerInterface
     */
    public function broker($name = 'default')
    {
        return isset($this->brokers[$name])
                    ? $this->brokers[$name]
                    : $this->brokers[$name] = $this->resolve();
    }
    
    /**
     * Resolve the given broker.
     *
     * @return BrokerInterface
     */
    protected function resolve()
    {
        return new Broker();
    }
    
    /**
     * Register a custom broker Closure.
     *
     * @param  string  $name
     * @param  \Closure  $callback
     * @return BrokerManagerInterface
     */
    public function extend($name, Closure $callback)
    {
        $this->brokers[$name] = call_user_func($callback);

        return $this;
    }
    
    /**
     * Dynamically call the default broker instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->broker()->{$method}(...$parameters);
    }
}
