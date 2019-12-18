<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
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
        $this->registerInstallCommand();
        $this->registerInfoCommand();
        $this->registerSeedCommand();
        $this->registerCacheCommand();
        $this->registerHookCommand();
    }
    /**
     * Register the thinkwinds.install command.
     */
    protected function registerInstallCommand()
    {
        $this->app->singleton('command.thinkwinds.install', function ($app) {
            return new \Thinkwinds\Framework\Console\Commands\ThinkwindsInstallCommand($app['thinkwinds']);
        });
        $this->commands('command.thinkwinds.install');
    }

    /**
     * Register the thinkwinds.info command.
     */
    protected function registerInfoCommand()
    {
        $this->app->singleton('command.thinkwinds.info', function ($app) {
            return new \Thinkwinds\Framework\Console\Commands\ThinkwindsInfoCommand($app['thinkwinds']);
        });
        $this->commands('command.thinkwinds.info');
    }

    /**
     * Register the module:seed command.
     */
    protected function registerSeedCommand()
    {
        $this->app->singleton('command.thinkwinds.seed', function ($app) {
            return new \Thinkwinds\Framework\Console\Commands\ThinkwindsSeedCommand($app['thinkwinds']);
        });
        $this->commands('command.thinkwinds.seed');
    }

    /**
     * Register the module:cache command.
     */
    protected function registerCacheCommand()
    {
        $this->app->singleton('command.thinkwinds.cache', function ($app) {
            return new \Thinkwinds\Framework\Console\Commands\ThinkwindsCacheCommand($app['thinkwinds']);
        });
        $this->commands('command.thinkwinds.cache');
    }

    protected function registerHookCommand()
    {
        $this->app->singleton('command.thinkwinds.widget.cache', function ($app) {
            $file = $this->app->make(Filesystem::class);
            return new \Thinkwinds\Framework\Console\Commands\ThinkwindsWidgetCacheCommand($file);
        });
        $this->commands('command.thinkwinds.widget.cache');

        $this->app->singleton('command.thinkwinds.widget.list', function ($app) {
            return new \Thinkwinds\Framework\Console\Commands\ThinkwindsWidgetListCommand($app['thinkwinds']);
        });
        $this->commands('command.thinkwinds.widget.list');
        
        $this->app->singleton('command.thinkwinds.widget.manage', function ($app) {
            return new \Thinkwinds\Framework\Console\Commands\ThinkwindsWidgetManageCommand($app['thinkwinds']);
        });
        $this->commands('command.thinkwinds.widget.manage');
    }
}
