<?php 

namespace Huasituo\Hook\Model;

use Huasituo\Hook\Model\HookInjectModel;

use Illuminate\Database\Eloquent\Model;
use Cache;

class HookModel extends Model
{
    protected $table = 'hook';

    protected $fillable = [
        'name', 'description', 'document', 'module', 'issystem'
    ];
    public $timestamps = false;

    static function addInfo($name, $description = '', $document = '', $issystem = 0, $module = 'system')
    {
        $postData = [
            'name'=> $name,
            'description'=> $description,
            'document'=> $document,
            'issystem'=> $issystem,
            'times'=> hst_time(),
            'module'=> $module
        ];
        HookModel::insert($postData);
        HookModel::setCache();
    }

    static function editInfo($name, $description = '', $document = '')
    {
        $postData = [
            'description'=> $description,
            'document'=> $document
        ];
        HookModel::where('name', $name)->update($postData);
        HookModel::setCache();
    }

    static function del($name = '', $module = '')
    {
        if(!$name && !$module) {
            return false;
        }
        if($module) {
            $hooks = HookModel::where('module', $module)->select('name')->get()->toArray();
            HookModel::where('module', $module)->delete();
            foreach ($hooks as $key => $value) {
                HookInjectModel::del('hook_name', $value['name']);
            }
            HookInjectModel::del('alias', 'mod_'.$module);
        } else {
            HookModel::where('name', $name)->delete();
            HookInjectModel::del('hook_name', $name);
        }
        HookModel::setCache();
        return true;
    }

    static function getAll($id = 1)
    {   
        $cacheName = 'hookAll'.$id;
        if (!Cache::has(md5($cacheName))) {
            $data = self::setCache($id);
        } else {
            $data = Cache::get(md5($cacheName));
        }
        return $data;
    }

    static function setCache($id = 0)
    {
        $allHook1 = HookModel::where('name', '!=', '')->orderBy('times', 'desc')->get()->toArray();
        $allHooks = [];
        $defHooks = config('hook.default.hookList');
        foreach ($allHook1 as $key => $value) {
            $allHooks[$value['name']] = ['name'=>$value['name'], 'description'=>$value['description']];
        }
        if($allHooks) {
            $defHooks = array_merge($defHooks, $allHooks);
        }
        $allHook2 = [];
        foreach ($defHooks as $key => $value) {
            $allHook2[] = $value;
        }
        Cache::forever(md5('hookAll2'), $allHook2);
        Cache::forever(md5('hookAll1'), $allHook1);
        if($id) {
            return $id == 1 ? $allHook1 : $allHook2;
        }
        return [$allHook1, $allHook2];
    }
}
