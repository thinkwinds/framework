<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\ManageMenuModel;
use Thinkwinds\Framework\Model\RoleUriModel;


class MenuController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function nav(Request $request)
    {
        $this->navs = [
            'nav'=>['name'=>tw_lang('thinkwinds::public.menu'), 'url'=>'manage.menu.nav'],
            'role'=>['name'=>tw_lang('thinkwinds::manage.role.uri'), 'url'=>'manage.menu.role'],
            'add'=>['name'=>tw_lang('thinkwinds::public.add', 'thinkwinds::public.menu'), 'url'=>'manage.menu.navAdd', 'class'=>'J_dialog', 'title'=>tw_lang('thinkwinds::public.add', 'thinkwinds::public.menu')]
        ];
        $menus = ManageMenuModel::getList();
        $view = [
            'menus'=>$menus,
            'navs'=>$this->getNavs('nav')
        ];
    	return $this->loadTemplate('menu.nav', $view);
    }

    public function navAdd(Request $request)
    {
        $menus = ManageMenuModel::getList();
        $view = [
            'menus'=>$menus
        ];
        return $this->loadTemplate('menu.nav_add', $view);
    }

    public function navAddSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ename' => 'required',
        ],[
            'name.required'=>tw_lang('thinkwinds::public.name.empty'),
            'ename.required' => tw_lang('thinkwinds::public.ename.empty'),
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $menu = ManageMenuModel::where('ename', trim($request->get('ename')))->first();
        if($menu) 
        {
            return $this->showError('thinkwinds::public.ename.noone', 2);
        }
        $parent = trim($request->get('parent'));
        $data = [
            'name'=>trim($request->get('name')),
            'ename'=>trim($request->get('ename')),
            'url'=>trim($request->get('url')),
            'icon'=>trim($request->get('icon'))
        ];
        ManageMenuModel::addInfo($data, $parent);
        $this->addOperationLog(tw_lang('thinkwinds::manage.menu.nav.add').':'.trim($request->get('name')), '', $data, []);
        ManageMenuModel::setCache();
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function navEdit($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $menu = ManageMenuModel::where('id', $id)->first();
        if(!$menu) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $menus = ManageMenuModel::getList();
        $view = [
            'id'=>$id,
            'info'=>$menu,
            'menus'=>$menus
        ];
        return $this->loadTemplate('menu.nav_edit', $view);
    }

    public function navEditSave(Request $request)
    {
        $id = (int)$request->get('id');
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $menu = ManageMenuModel::where('id', $id)->first();
        if(!$menu) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ename' => 'required',
        ],[
            'name.required'=>tw_lang('thinkwinds::public.name.empty'),
            'ename.required' => tw_lang('thinkwinds::public.ename.empty'),
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $_menu = ManageMenuModel::where('ename', trim($request->get('ename')))->first();
        if($_menu && $_menu['id'] != $id) 
        {
            return $this->showError('thinkwinds::public.ename.noone');
        }

        $parent = trim($request->get('parent'));
        $data = [
            'name'=>trim($request->get('name')),
            'ename'=>trim($request->get('ename')),
            'url'=>trim($request->get('url')),
            'icon'=>trim($request->get('icon'))
        ];
        ManageMenuModel::editInfo($id, $data, $parent, $menu);
        $this->addOperationLog(tw_lang('thinkwinds::manage.menu.nav.edit').':'.$data['name'], '', $data, $menu->toArray());
        ManageMenuModel::setCache();
        return $this->showMessage('thinkwinds::public.save.success'); 
    }

    public function navDelete($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $menu = ManageMenuModel::where('id', $id)->first();
        if(!$menu) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        ManageMenuModel::where('id', $id)->delete();
        $this->addOperationLog(tw_lang('thinkwinds::manage.menu.nav.delete').':'.$menu['name'], '', array(), $menu->toArray());
        ManageMenuModel::setCache();
        return $this->showMessage('thinkwinds::public.delete.success'); 
    }
    // ====================================
    public function role(Request $request)
    {
        if($request->get('_ajax')) 
        {
            $ename = $request->input('ename');
            $parent = $request->input('parent');
            $uri = $request->input('uri');
            $query = RoleUriModel::where('id', '>', 0);
            if($ename) 
            {
                $query->where('ename', $ename);
            }
            if($uri) 
            {
                $query->where('uri', $uri);
            }
            if($parent) 
            {
                $query->where('parent', $parent);
            }
            $list = $query->orderby('id', 'desc')->paginate($this->paginate);
            $this->addMessage($list, 'list');
            return $this->showMessage('thinkwinds::public.successful');
        }
        $view = [
            'navs'=>$this->getNavs('operation')
        ];
        $this->navs = [
            'nav'=>['name'=>tw_lang('thinkwinds::public.menu'), 'url'=>'manage.menu.nav'],
            'role'=>['name'=>tw_lang('thinkwinds::manage.role.uri'), 'url'=>'manage.menu.role'],
            'add'=>['name'=>tw_lang('thinkwinds::public.add', 'thinkwinds::manage.role.uri'), 'url'=>'manage.menu.roleAdd', 'class'=>'J_dialogs', 'title'=>tw_lang('thinkwinds::public.add', 'thinkwinds::manage.role.uri')]
        ];
        $view = [
            'navs'=>$this->getNavs('role')
        ];
        return $this->loadTemplate('menu.role', $view);
    }

    public function roleAdd(Request $request)
    {
        $id = $request->get('id');
        $info = [];
        if($id) 
        {
            $info = RoleUriModel::where('id', $id)->first();
        }
        $view = [
            'info'=>$info
        ];
        return $this->loadTemplate('menu.role_add', $view);
    }

    public function roleAddSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ename' => 'required',
            'uri' => 'required',
            'parent' => 'required',
        ],[
            'name.required'=>tw_lang('thinkwinds::public.name.empty'),
            'ename.required' => tw_lang('thinkwinds::public.ename.empty'),
            'uri.required' => tw_lang('thinkwinds::public.uri.empty'),
            'parent.required' => tw_lang('thinkwinds::public.ascription.empty'),
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $roleUri = RoleUriModel::where('ename', trim($request->get('ename')))->first();
        if($roleUri) 
        {
            return $this->showError('thinkwinds::public.ename.noone');
        }
        $data = [
            'name'=>trim($request->get('name')),
            'ename'=>trim($request->get('ename')),
            'uri'=>trim($request->get('uri')),
            'remark'=>trim($request->get('remark')),
            'parent'=>trim($request->get('parent'))
        ];
        RoleUriModel::addInfo($data);
        $this->addOperationLog(tw_lang('thinkwinds::manage.role.uri.add').':'.trim($request->get('name')), '', $data, []);
        RoleUriModel::setCache();
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function roleEdit($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = RoleUriModel::where('id', $id)->first();
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $view = [
            'id'=>$id,
            'info'=>$info
        ];
        return $this->loadTemplate('menu.role_edit', $view);
    }

    public function roleEditSave(Request $request)
    {
        $id = (int)$request->get('id');
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $roleUri = RoleUriModel::where('id', $id)->first();
        if(!$roleUri) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ename' => 'required',
            'uri' => 'required',
            'parent' => 'required',
        ],[
            'name.required'=>tw_lang('thinkwinds::public.name.empty'),
            'ename.required' => tw_lang('thinkwinds::public.ename.empty'),
            'uri.required' => tw_lang('thinkwinds::public.uri.empty'),
            'parent.required' => tw_lang('thinkwinds::public.ascription.empty'),
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $info = RoleUriModel::where('ename', trim($request->get('ename')))->first();
        if($info && $info['id'] != $id) 
        {
            return $this->showError('thinkwinds::public.ename.noone');
        }
        $data = [
            'name'=>trim($request->get('name')),
            'ename'=>trim($request->get('ename')),
            'uri'=>trim($request->get('uri')),
            'remark'=>trim($request->get('remark')),
            'parent'=>trim($request->get('parent'))
        ];
        RoleUriModel::editInfo($id, $data);
        $this->addOperationLog(tw_lang('thinkwinds::manage.role.uri.edit').':'.$data['name'], '', $data, $roleUri->toArray());
        RoleUriModel::setCache();
        return $this->showMessage('thinkwinds::public.save.success'); 
    }

    public function roleDelete($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = ManageMenuModel::where('id', $id)->first();
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        RoleUriModel::where('id', $id)->delete();
        $this->addOperationLog(tw_lang('thinkwinds::manage.role.uri.delete').':'.$info['name'], '', array(), $info->toArray());
        RoleUriModel::setCache();
        return $this->showMessage('thinkwinds::public.delete.success'); 
    }
}

