<?php 

namespace Thinkwinds\Framework\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $namespace = 'Thinkwinds\Framework\Repositories\Repository';
        $this->app->bind('Thinkwinds\Framework\Contracts\Repository', $namespace);
    }
}
