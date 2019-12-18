<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Thinkwinds\Framework\Model\RoleModel;

class ManageMenuModel extends Model
{
    protected $table = 'manage_menu';
    protected $fillable = [
        'name', 'ename', 'icon', 'url', 'parent', 'parents', 'level', 'module'
    ];
    public $timestamps = false;

    static function addInfo($data, $parent, $module = 'manage') 
    {
        if($parent) 
        {
            $parentInfo = ManageMenuModel::where('id', $parent)->first();
            if($parentInfo['level'] == 1) 
            {
                $parent = $parentInfo['ename'];
                $parents = '';
            } else if($parentInfo['level'] == 2){
                $parent = $parentInfo['parent'];
                $parents = $parentInfo['ename'];
            }
            $level = $parentInfo['level'] + 1;
        } else {
            $parent = 'root';
            $parents = '';
            $level = 1;
            $data['url'] = '';
        }
        if($level == 3)
        {

        }
        $postData = [
            'name'=>trim($data['name']),
            'ename'=>trim($data['ename']),
            'url'=>trim($data['url']),
            'icon'=>trim($data['icon']),
            'module'=>$module,
            'parent'=> $parent,
            'parents'=> $parents,
            'level'=> $level
        ];
        ManageMenuModel::insert($postData);
        self::setCache($module);
    }

    static function editInfo($id, $data, $parent, $menu)
    {
        if($parent && ($menu['level'] == 3 || !ManageMenuModel::where('parents', $menu['ename'])->where('parent', $menu['parent'])->count())) 
        {
            $parentInfo = ManageMenuModel::where('id', $parent)->first();
            if($parentInfo['level'] == 1)
            {
                $parent = $parentInfo['ename'];
                $parents = '';
            } else if($parentInfo['level'] == 2){
                $parent = $parentInfo['parent'];
                $parents = $parentInfo['ename'];
            }
            $level = $parentInfo['level'] + 1;
        } else if($parent && $menu['level'] == 2) {
            $parentInfo = ManageMenuModel::where('id', $parent)->first();
            if($parentInfo['level'] == 1) 
            {
                $parent = $parentInfo['ename'];
                $parents = '';
                $level = $parentInfo['level'] + 1;
                if(ManageMenuModel::where('parents', $menu['ename'])->where('parent', $menu['parent'])->count())
                {
                   ManageMenuModel::where('parents', $menu['ename'])->where('parent', $menu['parent'])->update(['parent'=>$parent, 'parents'=>$menu['ename']]); 
                }
            } else if($parentInfo['level'] == 2 && !ManageMenuModel::where('parents', $menu['ename'])->where('parent', $menu['parent'])->count()){
                $parent = $parentInfo['parent'];
                $parents = $parentInfo['ename'];
                $level = $parentInfo['level'] + 1;
            } else if($parentInfo['level'] == 2 && ManageMenuModel::where('parents', $menu['ename'])->where('parent', $menu['parent'])->count()){
                $parent = $menu['parent'];
                $parents = $menu['parents'];
                $level = $menu['level'];
            }
        }
        if(!$parent && $menu['level'] == 2) 
        {
            $parent = 'root';
            $parents = '';
            $level = 1;
            $data['url'] = '';
            if(ManageMenuModel::where('parents', $menu['ename'])->where('parent', $menu['parent'])->count())
            {
               ManageMenuModel::where('parents', $menu['ename'])->where('parent', $menu['parent'])->update(['parent'=>$menu['ename'], 'parents'=>'','level'=>$menu['level']]); 
            }
        }
        if($menu['level'] == 1 && ManageMenuModel::where('parents', $menu['ename'])->where('parent', $menu['parent'])->count()) 
        {
            $parent = 'root';
            $parents = '';
            $level = 1;
            $data['url'] = '';
        }
        if($menu['level'] == 1 && ManageMenuModel::where('parents', '')->where('parent', $menu['parent'])->count()) 
        {
            $parent = 'root';
            $parents = '';
            $level = 1;
            $data['url'] = '';
        }
        $postData = [
            'name'=>trim($data['name']),
            'ename'=>trim($data['ename']),
            'url'=>trim($data['url']),
            'icon'=>trim($data['icon']),
            'parent'=> $parent,
            'parents'=> $parents,
            'level'=> $level
        ];
        ManageMenuModel::where('id', $id)->update($postData);
        self::setCache($menu['module']);
    }

    static  function getList($module = 'manage')
    {
        $menus = tw_keyBy(self::getData($module), 'ename');
        $_menus = [];
        foreach ($menus as $key => $menu)
        {
            if($menu['level'] == 1) 
            {
                $_menus[$key] = ['id'=>$menu['id'], 'name'=>$menu['name'], 'ename'=>$menu['ename'], 'icon'=>$menu['icon'], 'parent'=>$menu['parent'], 'url'=>$menu['url'], 'level'=>$menu['level'], 'module'=>$menu['module']];
            } else if($menu['level'] == 2) {
                $_menus[$menu['parent']]['items'][$key] = ['id'=>$menu['id'], 'name'=>$menu['name'], 'ename'=>$menu['ename'], 'icon'=>$menu['icon'], 'parent'=>$menu['parent'], 'url'=>$menu['url'], 'level'=>$menu['level'], 'module'=>$menu['module']];
            } else if($menu['level'] == 3) {
                $_menus[$menu['parent']]['items'][$menu['parents']]['items'][$key] = ['id'=>$menu['id'], 'name'=>$menu['name'], 'ename'=>$menu['ename'], 'icon'=>$menu['icon'], 'parent'=>$menu['parent'], 'url'=>$menu['url'], 'level'=>$menu['level'], 'module'=>$menu['module']];
            }
        }
        return $_menus;
    }

    static function getAll($module = 'manage')
    {
        $menus = self::verifyMenuConfig(tw_keyBy(self::getData($module), 'ename'));
        return $menus;
    }
    
    /**
     * 递归的方式调用,将复合的节点设置合并为单节点设置方式
     * 
     * @param array $menus
     * @return array
     */
    static function verifyMenuConfig($menus)
    {
        $menus = thinkwinds_widget('s_manage_menu', $menus, true);
        $_menus = [];
        foreach ($menus as $key => $menu)
        {
            if($menu['level'] == 1) 
            {
                $_menus[$key] = ['id'=>$key, 'name'=>$menu['name'], 'icon'=>$menu['icon'], 'parent'=>$menu['parent']];
            } else {
                if($menu['level'] == 2 && !$menu['url']) 
                {
                    $_menus[$menu['parent']]['items'][$key] = ['id'=>$key, 'name'=>$menu['name'], 'parent'=>$menu['parent']];
                } else if($menu['level'] == 3) {
                    if(!preg_match('|^http://|', $menu['url'])) 
                    {
                        $menu['url'] = route($menu['url']);
                    }
                    $_menus[$menu['parent']]['items'][$menu['parents']]['items'][$key] = ['id'=>$key, 'name'=>$menu['name'], 'parent'=>$menu['parent'], 'url'=>$menu['url']];
                } else {
                    if(!preg_match('|^http://|', $menu['url'])) 
                    {
                        $menu['url'] = route($menu['url']);
                    }
                    $_menus[$menu['parent']]['items'][$key] = ['id'=>$key, 'name'=>$menu['name'], 'parent'=>$menu['parent'], 'url'=>$menu['url']];
                }
            }
        }
        return $_menus;
    }

    //======================================================================================================
    static function getMenu($users = [])
    {
        $menuTables = self::getAll();
        if ($users && $users['gid'] !== '99') 
        {
            $roleAuths = RoleModel::getInfo($users['gid']);
            $auths = isset($roleAuths['auths']) ? $roleAuths['auths'] : array();
            foreach ($menuTables as $key => $value) 
            {
                if(isset($value['items']) && $value['items']) 
                {
                    foreach ($value['items'] as $k => $val) 
                    {
                        if(isset($val['items']) && $val['items']) 
                        {
                            foreach ($val['items'] as $ks => $v) 
                            {
                                if (isset($v['url']) && !in_array($ks, (array) $auths))  
                                {   
                                    unset($menuTables[$key]['items'][$k]['items'][$ks]);
                                } 
                            }
                        }  else if (isset($val['url']) && !in_array($k, (array) $auths)) {   
                            unset($menuTables[$key]['items'][$k]);
                        } 
                    }
                } else {
                    unset($menuTables[$key]);
                }
            }
        }
        foreach ($menuTables as $key => $value) 
        {
            if (isset($value['items']) && empty($value['items'])) 
            {
                unset($menuTables[$key]);
            } else if (isset($value['items']) && !$value['items']) {
                unset($menuTables[$key]);
            } else {
                if(isset($value['items']) && $value['items']) 
                {
                    foreach ($value['items'] as $k => $val) 
                    {
                        if (isset($val['items']) && empty($val['items'])) 
                        {
                            unset($menuTables[$key]['items'][$k]);
                        } else if ((!isset($val['items']) || !$val['items']) && !isset($val['url'])) {
                            unset($menuTables[$key]['items'][$k]);
                        }
                    }
                }   
            }
        }
        foreach ($menuTables as $key => $value) 
        {
            if ((isset($value['items']) && empty($value['items'])) || (!isset($value['items']) || !$value['items'])) 
            {
                unset($menuTables[$key]);
            }
        }
        return $menuTables;
    }

    static function getData($module = 'manage')
    {
        if (!Cache::has($module.'Menu')) 
        {
            $data = self::setCache($module);
        } else {
            $data = Cache::get($module.'Menu');
        }
        return $data;
    }

    static function setCache($module = 'manage', $result = true) 
    {
        $cacheData = [];
        $data = ManageMenuModel::where('module', $module)->get();
        foreach ($data as $key => $value) 
        {
            $cacheData[$key] = [
                'id'=>trim($value['id']),
                'name'=>trim($value['name']),
                'ename'=>trim($value['ename']),
                'icon'=>trim($value['icon']),
                'url'=>$value['url'],
                'parent'=>$value['parent'],
                'parents'=>$value['parents'],
                'level'=>$value['level'],
                'module'=>$value['module']
            ];
        }
        Cache::forever($module.'Menu', $cacheData);
        if(!$result) {
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }
}