<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Providers;

use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
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
        $generators = [
            'command.make.thinkwinds'                   => \Thinkwinds\Framework\Console\Generators\MakeInstallCommand::class,
            'command.make.thinkwinds.manage.founder'    => \Thinkwinds\Framework\Console\Generators\MakeManageFounderCommand::class,
            'command.make.thinkwinds.api'               => \Thinkwinds\Framework\Console\Generators\MakeApiCommand::class,
        ];
        foreach ($generators as $slug => $class) 
        {
            $this->app->singleton($slug, function ($app) use ($slug, $class) 
            {
                return $app[$class];
            });
            $this->commands($slug);
        }
    }
}
