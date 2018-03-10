<?php

namespace ViktorMiller\LaravelUser;

use Illuminate\Support\Facades\Validator;
use ViktorMiller\LaravelUser\Console\Commands;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * 
 * @package  laravel-user
 * @author   Viktor Miller <phpfriq@gmail.com>
 */
class ServiceProvider extends BaseServiceProvider 
{   
    /**
     * Package root path
     * 
     * @var string 
     */
    protected $packageRoot;
    
    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);
        
        $this->root = __DIR__ .'/../';
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        $this->initTranslationPublish();
        $this->initConsoleCommands();
        $this->initValidatorRules();
    }

    /**
     * Register any application services.
     * 
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BrokerManagerInterface::class, function ($app) {
            return new BrokerManager($app);
        });
    }
    
    /**
     * Init translation publish
     * 
     * @return void
     */
    protected function initTranslationPublish()
    {
        $path = $this->root .'resources/lang';
        
        $this->loadTranslationsFrom($path, 'user');
        $this->publishes([
            $path => resource_path('lang/vendor/laravel-user'),
        ], 'user:translations');
    }
    
    /**
     * Init console commands
     * 
     * @return void
     */
    protected function initConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\User::class
            ]);
        }
    }
    
    /**
     * Init Validator ruless
     * 
     * @return void 
     */
    protected function initValidatorRules()
    {
        Validator::extend(
            'current_password', 'ViktorMiller\LaravelUser\Rules\Password@current'
        );
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [BrokerManagerInterface::class];
    }
}
