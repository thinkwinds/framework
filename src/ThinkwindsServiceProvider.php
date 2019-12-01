<?php 

namespace Thinkwinds\Framework;

use Thinkwinds\Framework\Contracts\Repository;
use Thinkwinds\Framework\Providers\RouteServiceProvider;
use Thinkwinds\Framework\Providers\HelperServiceProvider;
use Thinkwinds\Framework\Providers\ConsoleServiceProvider;
use Thinkwinds\Framework\Providers\RepositoryServiceProvider;

use Illuminate\Support\ServiceProvider;

class ThinkwindsServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/thinkwinds.php' => config_path('thinkwinds.php'),
        ], 'config');
        $this->loadViewsFrom(__DIR__.'/../views', 'thinkwinds');
        // $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadTranslationsFrom(__DIR__.'/../translations', 'thinkwinds');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/thinkwinds.php', 'thinkwinds'
        );
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(HelperServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->singleton('thinkwinds', function ($app) {
            $repository = $app->make(Repository::class);
            return new Thinkwinds($app, $repository);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string
     */
    public function provides()
    {
        return [
            'thinkwinds'
        ];
    }
}
