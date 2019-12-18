<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Thinkwinds\Framework\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        Route::pattern('id', '[0-9]+'); //自定类型
        parent::boot();
    }

    /**
     * Define the routes for the module.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
        $this->mapOpenRoutes();
    }

    /**
     * Define the "web" routes for the module.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace'  => $this->namespace,
        ], function ($router) {
            require __DIR__.'/../Routes/web.php';
        });
    }

    /**
     * Define the "api" routes for the module.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace'  => $this->namespace.'\Api',
            'domain'     => config('thinkwinds.apiDomain') ? config('thinkwinds.apiDomain') : env('APP_URL'),
            'prefix'     => config('thinkwinds.apiDomain') ? (config('thinkwinds.apiPrefix') ? config('thinkwinds.apiPrefix') : '') : (config('thinkwinds.apiPrefix') ? config('thinkwinds.apiPrefix') : 'api'),
        ], function ($router) {
             require __DIR__.'/../Routes/api.php';
        });
    }

    //开放平台API
    protected function mapOpenRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace'  => $this->namespace.'\Open',
            'prefix'     => config('open.apiDomain') ? config('open.apiDomain') : env('APP_URL'),
            'prefix'     => config('open.apiDomain') ? 'api/cms' : 'open/api/cms',
        ], function ($router) {
            require __DIR__.'/../Routes/open.php';
        });
    }
}
