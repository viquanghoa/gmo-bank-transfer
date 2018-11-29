<?php

namespace HoaVQ\GmoPG;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;

class GmoServiceProvider extends ServiceProvider
{
    /**
     * Supported Blade Directives
     *
     * @var array
     */
//    protected $directives = [];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerGmoFunctions();

        $this->app->alias('gmo', GmoFunctions::class);

    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/gmo.php' => config_path('gmo.php'),
        ]);
    }


    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerGmoFunctions()
    {
        $this->app->singleton('gmo', function ($app) {
            return new GmoFunctions();
        });
    }



    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['gmo', GmoFunctions::class];
    }
}
