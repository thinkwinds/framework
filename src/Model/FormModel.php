<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Thinkwinds\Framework\Libraries\ThinkwindsDb;

class FormModel extends Model
{
    protected $table = 'form';
    protected $fillable = [
        'module', 'relatedid', 'name', 'table', 'setting', 'times'
    ];
    public $timestamps = false;

    public static function addForm($data = [])
    {
        $data['relatedid'] = isset($data['relatedid']) ? $data['relatedid'] : 0;
    	$postData = [
    		'module'=> isset($data['module']) ? $data['module'] : 'site',
    		'relatedid'=> $data['relatedid'],
    		'name'=> $data['name'],
    		'table'=> $data['table'],
            'times'=> tw_time(),
    		'setting'=> tw_array2str($data['setting'])
    	];
    	if(!self::hasFormOrTable($data['table'], $data['module'], $data['relatedid'])) 
        {
    		return false;
    	}
        $id = FormModel::insertGetId($postData);
        FormModel::createSql($id, $postData);
        return $id;
    }

    public static function hasFormOrTable($table, $module = 'site', $relatedid = 0) 
    {
    	if(FormModel::where('table', $table)->where('module', $module)->where('relatedid', $relatedid)->limit(1)->count())
        {
    		return false;
    	}
        $thinkwindsDb = new ThinkwindsDb();
    	if($thinkwindsDb->hasTable($table)) 
        {
    		return false;
    	}
    	return true;
    }

    public static function createSql($id, $data) 
    {
        $thinkwindsDb = new ThinkwindsDb();
    	if($thinkwindsDb->hasTable($data['table'])) 
        {
    		return false;
    	}
        $thinkwindsDb->createTable($data['table'], function(Blueprint $table)
        {
            $table->increments('id')->comment('ID');
            $table->integer('created_uid')->default(0)->comment();
            $table->integer('created_time')->default(0)->comment();
            $table->string('created_ip', 150)->default('')->comment();
            $table->string('created_port')->default('')->comment();
            $table->integer('vieworder')->default(0)->comment();
        });
    }

    public static function deleteForm($table, $module = 'site', $relatedid = 0)
    {
    	$formInfo = FormModel::where('table', $table)->where('module', $module)->where('relatedid', $relatedid)->first();
    	if(!$formInfo) 
        {
    		return false;
    	}
        FormModel::where('table', $table)->where('module', $module)->where('relatedid', $relatedid)->delete();
        $thinkwindsDb = new ThinkwindsDb();
    	if($thinkwindsDb->hasTable($table)) 
        {
    		$thinkwindsDb->dropTable($table);
    	}
        FieldsModel::where('relatedtable', $table)->where('module', $module)->where('relatedid', $formInfo['id'])->delete();
        FieldsModel::setCache($table);
        FieldsModel::setCache('all');
    	return true;
    }

    static function getForms($module = 'all')
    {
        $cacheName = 'form:'.$module;
        if (!Cache::has($cacheName)) 
        {
            $data = self::setCache($module);
        } else {
            $data = Cache::get($cacheName);
        }
        return $data;
    }

    static function getForm($id = 0, $module = 'all')
    {
        if(!$id) return [];
        $forms = self::getForms($module);
        if(!$forms || !isset($forms['list'][$id])) return [];
        return $forms['list'][$id];
    }

    static function setCache($module = 'all', $result = true) 
    {
        $cacheData = [
            'list'=>[],
            'table'=>[],
            'relatedid'=>[]
        ];
        if($module === 'all') 
        {
            $data = FormModel::where('id', '>', 0)->orderBy('id', 'desc')->get();
        } else {
            $data = FormModel::where('module', $module)->orderBy('id', 'desc')->get();
        }
        foreach ($data as $key => $value) 
        {
            $cacheData['list'][$value['id']] = [
                'id'=>trim($value['id']),
                'name'=>trim($value['name']),
                'table'=>trim($value['table']),
                'relatedid'=>trim($value['relatedid']),
                'setting'=>tw_str2array($value['setting']),
                'times'=>$value['times'],
                'times_str'=>tw_time2str($value['times']),
                'module'=>trim($value['module'])
            ];
            $cacheData['table'][$value['table']] = $value['id'];
            if($value['relatedid']) 
            {
                $cacheData['relatedid'][$value['relatedid']] = $value['id'];
            }
        }
        $cacheName = 'form:'.$module;
        Cache::forget($cacheName);
        Cache::forever($cacheName, $cacheData);
        if(!$result) 
        {
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }
}