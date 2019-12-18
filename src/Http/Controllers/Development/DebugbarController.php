<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Development;

use Cache;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;

class DebugbarController extends BaseController
{

	public function index(Request $request)
	{
		$this->editContent();
		$view = [
			'seo_title'=>'开发调试中心'
		];
		return $this->loadTemplate('thinkwinds::development.debugbar_index', $view);
	}

	public function editContent()
	{
        $cacheName = 'development:debugbar';
        $files = new Filesystem();
        $path = realpath(__DIR__.'/../../../../../../barryvdh/laravel-debugbar/src/LaravelDebugbar.php');
        $content = $files->get($path);
        if(!substr_count($content, 'by thinkwinds.com')) 
        {
            $content = str_replace("use Symfony\Component\HttpFoundation\Response;","use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;//20180907 by thinkwinds.com",$content);
            $content = str_replace('$renderedContent = $renderer->renderHead() . $renderer->render();','$renderedContent = $renderer->renderHead() . $renderer->render();
        if(Route::currentRouteName() != \'development.debugbar.index\') $renderedContent = \'\';//20180907 by thinkwinds.com',$content);
            $files->put($path, $content);
        }
        Cache::forever($cacheName, 1);
    }

    public function deleteContent()
    {
        $cacheName = 'development:debugbar';
        $files = new Filesystem();
        $path = realpath(__DIR__.'/../../../../../../barryvdh/laravel-debugbar/src/LaravelDebugbar.php');
        $content = $files->get($path);
        $content = str_replace("use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;//20180907 by thinkwinds.com","use Symfony\Component\HttpFoundation\Response;",$content);
        $content = str_replace('$renderedContent = $renderer->renderHead() . $renderer->render();
        if(Route::currentRouteName() != \'development.debugbar.index\') $renderedContent = \'\';//20180907 by thinkwinds.com','$renderedContent = $renderer->renderHead() . $renderer->render();',$content);
        $files->put($path, $content);
        Cache::forever($cacheName, 0);
        Cache::forget($cacheName);
	}
}