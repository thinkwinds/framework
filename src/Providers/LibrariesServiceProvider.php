<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class LibrariesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the libraries services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the libraries services.
     *
     * @return void
     */
    public function register()
    {
        $file = $this->app->make(Filesystem::class);
        $path    = realpath(__DIR__.'/../Libraries');

        $libraries = $file->glob($path.'/*.php');
        foreach ($libraries as $v) 
        {
            require_once($v);
        }
        $libraries2 = $file->glob($path.'/ThinkwindsApi/*.php');
        foreach ($libraries2 as $v) 
        {
            require_once($v);
        }
        $libraries3 = $file->glob($path.'/ThinkwindsApi/Request/*.php');
        foreach ($libraries3 as $v) 
        {
            require_once($v);
        }
        $fields = $file->glob($path.'/Fields/*.php');
        foreach ($fields as $v) 
        {
            require_once($v);
        }
        $alipays = $file->glob($path.'/Alipay/*.php');
        foreach ($alipays as $v) 
        {
            require_once($v);
        }
    }
}