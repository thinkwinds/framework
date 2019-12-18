<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;

class WidgetModel extends Model
{
    protected $table = 'widget';
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
            'times'=> tw_time(),
            'module'=> $module
        ];
        WidgetModel::insert($postData);
        WidgetModel::setCache();
    }

    static function editInfo($name, $description = '', $document = '')
    {
        $postData = [
            'description'=> $description,
            'document'=> $document
        ];
        WidgetModel::where('name', $name)->update($postData);
        WidgetModel::setCache();
    }

    static function del($name = '', $module = '')
    {
        if(!$name && !$module) 
        {
            return false;
        }
        if($module) 
        {
            $widgets = WidgetModel::where('module', $module)->select('name')->get()->toArray();
            WidgetModel::where('module', $module)->delete();
            foreach ($widgets as $key => $value) 
            {
                WidgetInjectModel::del('widget_name', $value['name']);
            }
            WidgetInjectModel::del('alias', 'mod_'.$module);
        } else {
            WidgetModel::where('name', $name)->delete();
            WidgetInjectModel::del('widget_name', $name);
        }
        WidgetModel::setCache();
        return true;
    }

    static function getAll($id = 1)
    {   
        $cacheName = 'WidgetAll'.$id;
        if (!Cache::has($cacheName)) 
        {
            $data = self::setCache($id);
        } else {
            $data = Cache::get($cacheName);
        }
        return $data;
    }

    static function setCache($id = 0)
    {
        $allWidget1 = WidgetModel::where('name', '!=', '')->orderBy('times', 'desc')->get()->toArray();
        $allWidgets = [];
        foreach ($allWidget1 as $key => $value) 
        {
            $allWidgets[$value['name']] = ['name'=>$value['name'], 'description'=>$value['description']];
        }
        $WidgetAll2 = [];
        if($allWidgets) 
        {
            foreach ($allWidgets as $key => $value) 
            {
                $WidgetAll2[] = $value;
            }
        }
        Cache::forever('WidgetAll2', $WidgetAll2);
        Cache::forever('WidgetAll1', $allWidget1);
        if($id) {
            return $id == 1 ? $allWidget1 : $WidgetAll2;
        }
        return [$allWidget1, $WidgetAll2];
    }
}
