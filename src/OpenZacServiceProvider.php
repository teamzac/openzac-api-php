<?php

namespace TeamZac\OpenZac;

use Illuminate\Support\ServiceProvider;

class OpenZacServiceProvider extends ServiceProvider 
{
    /**
     * 
     *
     * @param   
     * @return  
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../laravel-config.php' => config_path('openzac.php')
            ], 'openzac-laravel-config');
        }
    }

    /**
     * 
     *
     * @param   
     * @return  
     */
    public function register()
    {
        $this->app->singleton('OpenZac', function($app) {
            return new OpenZac( config('openzac.token') );
        });
    }
}