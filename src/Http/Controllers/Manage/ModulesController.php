<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Thinkwinds\Framework\Model\ModulesModel;

use Module;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class ModulesController extends BasicController
{
    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
        $this->navs = [
            'index'=>['name'=>tw_lang('thinkwinds::manage.modules.manage'), 'url'=>'manage.modules.index'],
            'uninstalls'=>['name'=>tw_lang('thinkwinds::manage.modules.uninstalls'), 'url'=>'manage.modules.uninstalls'],
            'cache'=>['name'=>tw_lang('thinkwinds::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>'manage.modules.cache']
        ];
    }

    public function index(Request $request)
    {
        $list = ModulesModel::getData();
        $view = [
            'list'=>$list,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('modules.index', $view);
    }

    //设置状态
    public function enableds(Request $request) 
    {
        $slug = $request->get('slug');
        $enableds = $request->get('enableds');
        if(!$slug) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.no.ext'), 2);
        }
        $module = $this->getLocalModules($slug);
        if(!$module) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.no.ext'), 2);
        }
        $moduleInfo = ModulesModel::where('slug', $slug)->first();
        if(!$moduleInfo) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.no.ext'), 2);
        }
        $moduleInstallLog = Module::where('slug', $slug);
        if(!$moduleInstallLog) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.no.ext'), 2);
        }
        $postData = [
            'enabled'=>$enableds
        ];
        ModulesModel::where('slug', $slug)->update($postData);
        if($enableds == 1)
        {
            Module::enable($slug);
        } else {
            Module::disable($slug);
        }
        ModulesModel::setCache();
        return $this->showMessage('thinkwinds::public.success', 2);
    }

    //未安装
    public function uninstalls(Request $request) 
    {
        $list = $this->getLocalModules();
        foreach ($list as $key => $value) 
        {
            if(ModulesModel::where('slug', $value['slug'])->count() && Module::where('slug', $value['slug'])) 
            {
                unset($list[$key]);
            }
        }
        $view = [
            'list'=>$list,
            'navs'=>$this->getNavs('uninstalls')
        ];
        return $this->loadTemplate('modules.uninstalls', $view);
    }

    //安装
    public function doinstalls(Request $request) 
    {
        $slug = $request->get('slug');
        if(!$slug) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.no.ext'), 2);
        }
        $module = $this->getLocalModules($slug);
        if(!$module) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.no.ext'), 2);
        }
        $moduleInfo = ModulesModel::where('slug', $slug)->first();
        $moduleInstallLog = Module::where('slug', $slug)->toArray();
        if($moduleInfo && $moduleInstallLog) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.install.donet'), 2);
        }
        $postData = [
            'name'=>$module['name'],
            'slug'=>$module['slug'],
            'description'=>$module['description'],
            'times'=>tw_time(),
            'version'=>$module['version'],
            'enabled'=>1,
        ];
        if(!$moduleInfo) 
        {
            ModulesModel::insertGetId($postData);
        } else {
            ModulesModel::where('slug', $slug)->update($postData);
        }
        if(!$moduleInstallLog) 
        {
            Artisan::call('module:optimize');
            Artisan::call('module:migrate', [
                'slug'=>$slug
            ]);
            Artisan::call('module:seed', [
                'slug'=>$slug
            ]);
        } else {
            $enabled = 1;
            ModulesModel::where('slug', $slug)->update(['enabled'=>$enabled]);
            Module::enable($slug);
            Artisan::call('module:migrate:refresh', [
                'slug'=>$slug,
                '--pretend'=>true
            ]);
            Artisan::call('module:migrate:refresh', [
                'slug'=>$slug,
                '--seed'=>true
            ]);
        }
        Artisan::call('thinkwinds:widget:cache', [
            '--p'=>'Modules/'.ucfirst($slug),
            '--f'=>'app'
        ]);
        ModulesModel::setCache();
        return $this->showMessage('thinkwinds::public.install.success',2);
    }

    //卸载
    public function douninstall(Request $request) 
    {   
        $slug = $request->get('slug');
        if(!$slug) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.no.ext'));
        }
        $module = $this->getLocalModules($slug);
        if(!$module) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.no.ext'));
        }
        $moduleInfo = ModulesModel::where('slug', $slug)->first();
        if(!$moduleInfo) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.modules.no.ext'));
        }
        $moduleInstallLog = Module::where('slug', $slug);
        if($moduleInstallLog) 
        {
            Module::disable($slug);
        }
        ModulesModel::where('slug', $slug)->delete();
        Artisan::call('module:migrate:rollback', [
            'slug'=>$slug
        ]);
        Artisan::call('thinkwinds:widget:cache', [
            '--p'=>'Modules/'.ucfirst($slug),
            '--f'=>'app',
            '--t'=>'delete'
        ]);
        ModulesModel::setCache();
        return $this->showMessage('thinkwinds::public.success');
    }

    //更新缓存
    public function cache(Request $request) 
    {
        ModulesModel::setCache();
        return $this->showMessage('thinkwinds::public.install.success',2);
    }

    //获取模块目录有哪些模块
    public function getLocalModules($slug = '') 
    {
        $path    = app_path('Modules');
        $modules = $this->files->glob($path.'/*/module.json');
        $list = [];
        foreach ($modules as $module) 
        {
            $moduleJson = json_decode($this->files->get($module), true);
            $list[$moduleJson['slug']] = $moduleJson;
        }
        if($slug) 
        {
            return isset($list[$slug]) ? $list[$slug] : [];
        }
        return $list;
    }
}

