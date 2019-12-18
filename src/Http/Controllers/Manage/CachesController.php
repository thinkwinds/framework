<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;

class CachesController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'index'=>['name'=>tw_lang('thinkwinds::manage.caches.setting'),'url'=>'manage.caches.index']
        ];
    }

    public function index(Request $request)
    {
    	$config = tw_config('caches');
        if(!isset($config['driver']) || !$config['driver']) 
        {
            $config['driver'] = 'file';
        }
        $this->tw_data['navs'] = $this->getNavs('index');
    	return $this->loadTemplate('caches.config', ['config'=>$config]);
    }

    public function config(Request $request)
    {
        $config = tw_config('caches');
        if(!isset($config['driver']) || !$config['driver']) 
        {
            $config['driver'] = 'file';
        }
        $this->tw_data['navs'] = $this->getNavs('index');
        return $this->loadTemplate('caches.config', ['config'=>$config]);
    }

    public function save(Request $request)
    {
        $arrRequest = $request->all();
        $oldConfig = tw_config('caches');
        $arrRequest['driver'] = $arrRequest['driver'] ? $arrRequest['driver'] : 'file';
        if($arrRequest['driver'] == 'memcached') 
        {
            if(!isset($oldConfig['memdusername']) || !$oldConfig['memdusername']) 
            {
                return $this->showError('thinkwinds::manage.caches.save.error.001', 5);
            }
        }
        if($arrRequest['driver'] == 'redis') 
        {
            if(!isset($oldConfig['redishost']) || !$oldConfig['redishost']) 
            {
                return $this->showError('thinkwinds::manage.caches.save.error.002', 5);
            }
        }
        $data =[
            ['name'=>'driver', 'value'=>trim($arrRequest['driver'])]
        ];
        tw_save_config('caches', $data);
        $configData = [
            'CACHE_DRIVER'=>$arrRequest['driver']
        ];
        tw_updateEnvInfo($configData);
        $this->addOperationLog(tw_lang('thinkwinds::manage.caches.driver'),'', tw_config('caches'), $oldConfig);
        return $this->showMessage('thinkwinds::public.save.success', 5);
    }

    public function memcachedConfig(Request $request)
    {
        $config = tw_config('caches');
        $this->navs['memcached'] = ['name'=>tw_lang('thinkwinds::manage.caches.memcached.setting'),'url'=>'manage.caches.memcachedConfig'];
        $this->tw_data['navs'] = $this->getNavs('memcached');
        return $this->loadTemplate('caches.memcached', ['config'=>$config]);
    }

    public function memcachedConfigSave(Request $request) 
    {
        $arrRequest = $request->all();
        $postData =[
            ['name'=>'memdpsid', 'value'=>$arrRequest['memdpsid'], 'issystem'=>1],
            ['name'=>'memdhost', 'value'=>$arrRequest['memdhost'], 'issystem'=>1],
            ['name'=>'memdport', 'value'=>$arrRequest['memdport'], 'issystem'=>1],
            ['name'=>'memdusername', 'value'=>$arrRequest['memdusername'], 'issystem'=>1],
            ['name'=>'memdpassword', 'value'=>$arrRequest['memdpassword'], 'issystem'=>1]
        ];
        $oldConfig = tw_config('caches');
        tw_save_config('caches', $postData);
        $configData = [
            'MEMCACHED_PERSISTENT_ID'=>$arrRequest['memdpsid'],
            'MEMCACHED_USERNAME'=>$arrRequest['memdusername'],
            'MEMCACHED_PASSWORD'=>$arrRequest['memdpassword'],
            'MEMCACHED_HOST'=>$arrRequest['memdhost'],
            'MEMCACHED_PORT'=>$arrRequest['memdport']
        ];
        tw_updateEnvInfo($configData);
        $this->addOperationLog(tw_lang('thinkwinds::manage.caches.memcached.update'),'', tw_config('sms'), $oldConfig);
        return $this->showMessage('thinkwinds::public.save.success');
    }

    public function redisConfig(Request $request)
    {
        $config = tw_config('caches');
        $this->navs['redis'] = ['name'=>tw_lang('thinkwinds::manage.caches.redis.setting'),'url'=>'manage.caches.redisConfig'];
        $this->tw_data['navs'] = $this->getNavs('redis');
        return $this->loadTemplate('caches.redis', ['config'=>$config]);
    }

    public function redisConfigSave(Request $request) 
    {
        $arrRequest = $request->all();
        $postData =[
            ['name'=>'redishost', 'value'=>$arrRequest['host'], 'issystem'=>1],
            ['name'=>'redisport', 'value'=>$arrRequest['port'], 'issystem'=>1],
            ['name'=>'redispassword', 'value'=>$arrRequest['password'], 'issystem'=>1]
        ];
        $oldConfig = tw_config('caches');
        tw_save_config('caches', $postData);
        $configData = [
            'REDIS_PASSWORD'=>$arrRequest['password'],
            'REDIS_HOST'=>$arrRequest['host'],
            'REDIS_PORT'=>$arrRequest['port']
        ];
        tw_updateEnvInfo($configData);
        $this->addOperationLog(tw_lang('thinkwinds::manage.caches.redis.update'),'', tw_config('sms'), $oldConfig);
        return $this->showMessage('thinkwinds::public.save.success');
    }
}