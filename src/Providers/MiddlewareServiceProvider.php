<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Providers;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton('manage.request.log', function ($app) {
            return new \Thinkwinds\Framework\Http\Middleware\RequestLog($app['thinkwinds']);
        });
        $this->app->singleton('manage.auth.check', function ($app) {
            return new \Thinkwinds\Framework\Http\Middleware\CheckAuth($app['thinkwinds']);
        });
        $this->app->singleton('api.service', function ($app) {
            return new \Thinkwinds\Framework\Http\Middleware\ApiService($app['thinkwinds']);
        });
        $this->app->singleton('module.service', function ($app) {
            return new \Thinkwinds\Framework\Http\Middleware\ModuleService($app['thinkwinds']);
        });
        $this->app->singleton('check.site.status', function ($app) {
            return new \Thinkwinds\Framework\Http\Middleware\CheckSiteStatus($app['thinkwinds']);
        });
        // $this->app->singleton('module.api.service', function ($app) {
        //     return new \Thinkwinds\Framework\Http\Middleware\ModuleApiService($app['thinkwinds']);
        // });
        // $this->app->singleton('module.openapi.service', function ($app) {
        //     return new \Thinkwinds\Framework\Http\Middleware\ModuleOpenApiService($app['thinkwinds']);
        // });
    }
}
