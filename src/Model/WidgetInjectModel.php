<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;

class WidgetInjectModel extends Model
{
    protected $table = 'widget_inject';
    protected $fillable = [
        'widget_name', 'alias', 'files', 'class', 'fun', 'description', 'issystem'
    ];
    public $timestamps = false;

    static function addInfo($widget_name, $alias, $files, $class, $fun, $description = '', $issystem = 0)
    {
        $postData = [
            'times'=> tw_time(),
            'widget_name'=> $widget_name,
            'alias'=> 'mod_'.$alias,
            'files'=> $files,
            'class'=> $class,
            'fun'=> $fun,
            'description'=> $description,
            'issystem'=> $issystem
        ];
        WidgetInjectModel::insert($postData);
        WidgetInjectModel::setAllCache();
        WidgetInjectModel::setCache();
    }

    static function editInfo($id, $widget_name, $alias, $files, $class, $fun, $description = '')
    {
        $postData = [
            'widget_name'=> $widget_name,
            'alias'=> 'mod_'.$alias,
            'files'=> $files,
            'class'=> $class,
            'fun'=> $fun,
            'description'=> $description
        ];
        WidgetInjectModel::where('id', $id)->update($postData);
        WidgetInjectModel::setAllCache();
        WidgetInjectModel::setCache();
    }

    static function del($t = 'id', $v = '')
    {
        if(!in_array($t, ['id', 'widget_name', 'alias'])) 
        {
            return false;
        }
        WidgetInjectModel::where($t, $v)->delete();
        WidgetInjectModel::setAllCache();
        WidgetInjectModel::setCache();
        return true;
    }

    static function getAll()
    {
        if (!Cache::has('widgetInjectAll')) 
        {
            $data = self::setAllCache();
        } else {
            $data = Cache::get('widgetInjectAll');
        }
        return $data;
    }

    static function setAllCache()
    {
        $widgetInject = WidgetInjectModel::where('id', '>', 0)->orderBy('id', 'desc')->get()->toArray();
        Cache::forever('widgetInjectAll', $widgetInject);
        return $widgetInject;
    }

    static function setCache()
    {
        $widget = WidgetModel::getAll(2);
        $data = [];
        foreach ($widget as $key => $value) 
        {
            if(WidgetInjectModel::where('widget_name', $value['name'])->count()) 
            {
                $data[$value['name']] = WidgetInjectModel::where('widget_name', $value['name'])->select(['widget_name','files', 'class', 'fun'])->get()->toArray();
            }
        }
        Cache::forever('widgetInject', $data);
        return $data;
    }
}
