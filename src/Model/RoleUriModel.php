<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;

class RoleUriModel extends Model
{
    protected $table = 'role_uri';
    protected $fillable = [
        'id', 'name', 'ename', 'uri', 'parent', 'remark', 'module'
    ];
    public $timestamps = false;

    static function getList($module = 'manage')
    {
        $cacheName = $module.'RoleUri';
        if (!Cache::has($cacheName)) 
        {
            $data = self::setCache($module);
        } else {
            $data = Cache::get($cacheName);
        }
        $data = thinkwinds_widget('s_role_uri', $data, true);
        return $data;
    }

    static function getRoleUriDatas($module = 'manage')
    {
        $roleUris = RoleUriModel::getList();
        $roleDatas = [];
        foreach ($roleUris as $key => $value) 
        {
            $roleDatas[$value['parent']][] = ['name'=>$value['name'], 'ename'=>$value['ename'], 'uri'=>$value['uri']];
        }
        return $roleDatas;
    }

    static function addInfo($data, $module = 'manage') 
    {
        $postData = [
            'name'=>trim($data['name']),
            'ename'=>trim($data['ename']),
            'uri'=>trim($data['uri']),
            'parent'=>$data['parent'],
            'remark'=>$data['remark'],
            'module'=>$module,
        ];
        RoleUriModel::insert($postData);
        self::setCache($module);
    }

    static function editInfo($id, $data, $module = 'manage') 
    {
        $postData = [
            'name'=>trim($data['name']),
            'ename'=>trim($data['ename']),
            'uri'=>trim($data['uri']),
            'remark'=>$data['remark'],
            'parent'=>$data['parent']
        ];
        RoleUriModel::where('id', $id)->update($postData);
        self::setCache($module);
    }

    static function setCache($module = 'manage', $result = true) 
    {
        $cacheData = [];
        $data = RoleUriModel::where('module', $module)->orderBy('id', 'desc')->get();
        foreach ($data as $key => $value) 
        {
            $cacheData[$value['ename']] = [
                // 'id'=>trim($value['id']),
                'name'=>trim($value['name']),
                'ename'=>trim($value['ename']),
                'uri'=>trim($value['uri']),
                'remark'=>$value['remark'],
                'parent'=>$value['parent'],
                'module'=>$value['module']
            ];
        }
        $cacheName = $module.'RoleUri';
        Cache::forever($cacheName, $cacheData);
        if(!$result) 
        {
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }
}
