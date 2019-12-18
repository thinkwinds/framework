<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Thinkwinds\Framework\Contracts\Repository;
use Thinkwinds\Framework\Providers\RouteServiceProvider;
use Thinkwinds\Framework\Providers\HelperServiceProvider;
use Thinkwinds\Framework\Providers\ConsoleServiceProvider;
use Thinkwinds\Framework\Providers\LibrariesServiceProvider;
use Thinkwinds\Framework\Providers\GeneratorServiceProvider;
use Thinkwinds\Framework\Providers\RepositoryServiceProvider;
use Thinkwinds\Framework\Providers\MiddlewareServiceProvider;
use Thinkwinds\Framework\Libraries\Compiles\CompilesTwData;

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
        $this->publishes([
            __DIR__.'/../assets' => public_path('assets'),
        ], 'public');
        $this->loadViewsFrom(__DIR__.'/../views', 'thinkwinds');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadTranslationsFrom(__DIR__.'/../translations', 'thinkwinds');
        //处理单页多元化模版
        $this->loadViewsFrom(public_path('theme/special'), 'special');
        Paginator::defaultView('thinkwinds::pagination.default');
        Paginator::defaultSimpleView('thinkwinds::pagination.simple-default');
        //给公共视图起别名
        Blade::include('thinkwinds::manage.common.head', 'mHead');
        Blade::include('thinkwinds::manage.common.foot', 'mFoot');
        Blade::include('thinkwinds::common.head', 'twHead');
        Blade::include('thinkwinds::common.foot', 'twFoot');
        $compilesTwData = new CompilesTwData();
        Blade::directive('twData', function ($expression) use ($compilesTwData) {
            return $compilesTwData->compileData($expression);
        });
        Blade::directive('twDataEnd', function ($expression) use ($compilesTwData) {
            return $compilesTwData->compileDataEnd($expression);
        });
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
        $this->app->register(LibrariesServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(GeneratorServiceProvider::class);
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