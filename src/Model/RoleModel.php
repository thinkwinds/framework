<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table = 'role';
    protected $fillable = [
        'id', 'name', 'auths', 'module'
    ];
    public $timestamps = false;

    static function getInfo($id)
    {
        $info = RoleModel::where('id', $id)->first();
        $info['auths'] = explode(',', $info['auths']);
        return $info;
    }

    static function getRoles($module = 'manage')
    {
        $cacheName = $module.'Role';
        if (!Cache::has($cacheName)) 
        {
            $data = self::setCache($module);
        } else {
            $data = Cache::get($cacheName);
        }
        return $data;
    }

    static function setCache($module = 'manage', $result = true) 
    {
        $cacheData = [];
        $data = RoleModel::where('module', $module)->orderBy('id', 'desc')->get();
        foreach ($data as $key => $value) 
        {
            $cacheData[$value['id']] = [
                'id'=>trim($value['id']),
                'name'=>trim($value['name']),
                'auths'=>trim($value['auths']),
                'module'=>trim($value['module'])
            ];
        }
        $cacheName = $module.'Role';
        Cache::forever($cacheName, $cacheData);
        if(!$result) 
        {
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }
}
