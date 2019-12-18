<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\RoleModel;
use Thinkwinds\Framework\Model\RoleUriModel;
use Thinkwinds\Framework\Model\ManageUserModel;
use Thinkwinds\Framework\Model\ManageMenuModel;

class RoleController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'user'=>['name'=>tw_lang('thinkwinds::public.user'), 'url'=>'manage.user.index'],
            'role'=>['name'=>tw_lang('thinkwinds::public.role'), 'url'=>'manage.role.index']
        ];
    }

    public function index(Request $request)
    {
        $roles = RoleModel::get();
        $this->navs['add'] = ['name'=>tw_lang('thinkwinds::public.add', 'thinkwinds::public.role'), 'url'=>'manage.role.add'];
        $view = [
            'roles'=>$roles,
            'navs'=>$this->getNavs('role')
        ];
    	return $this->loadTemplate('role.index', $view);
    }

    public function add(Request $request)
    {
        $menus = ManageMenuModel::getMenu();
        $roleUriDatas = RoleUriModel::getRoleUriDatas();
        $this->navs['add'] = ['name'=>tw_lang('thinkwinds::public.add', 'thinkwinds::public.role'), 'url'=>'manage.role.add'];
        $view = [
            'navs'=>$this->getNavs('add'),
            'menus'=>$menus,
            'roleUriDatas'=>$roleUriDatas
        ];
        return $this->loadTemplate('role.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.role.name.empty'),
        ]);
        if ($validator->fails())
        {
            return $this->showError($validator->errors(), 2);
        }
        $role = RoleModel::where('name', trim($request->get('name')))->first();
        if($role) 
        {
            return $this->showError('thinkwinds::manage.role.name.one');
        }
        $postData = [
            'module'=>'manage',
            'name'=>trim($request->get('name')),
            'auths'=>implode(',', (array) $request->get('auths'))
        ];
        RoleModel::insert($postData);
        RoleModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::public.add', 'thinkwinds::public.role').':'.trim($request->get('name')), '', $postData, []);
        return $this->showMessage('thinkwinds::public.add.success', 'manage.role.index');
    }

    public function edit($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = RoleModel::where('id', $id)->first();
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $info['auths'] = explode(',', $info['auths']);
        $this->navs['edit'] = ['name'=>tw_lang('thinkwinds::manage.role.edit'), 'url'=>route('manage.role.edit', ['id'=>$id])];
        $menus = ManageMenuModel::getMenu();
        $roleUriDatas = RoleUriModel::getRoleUriDatas();
        $view = [
            'navs'=>$this->getNavs('edit'),
            'info'=>$info,
            'id'=>$id,
            'menus'=>$menus,
            'roleUriDatas'=>$roleUriDatas
        ];
        return $this->loadTemplate('role.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $role = RoleModel::where('id', $id)->first();
        if(!$role) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.role.name.empty'),
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $editData = [
            'name'=>trim($request->get('name')),
            'auths'=>implode(',', (array) $request->get('auths'))
        ];
        RoleModel::where('id', $id)->update($editData);
        RoleModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::manage.role.edit').':'.trim($request->get('name')), '', $editData, $role->toArray());
        return $this->showMessage('thinkwinds::public.edit.success');
    }

    public function delete($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $role = RoleModel::where('id', $id)->first();
        if(!$role) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $userCount = ManageUserModel::where('gid', $id)->count();
        if($userCount) 
        {
            return $this->showError('thinkwinds::manage.role.delete.error.001');
        }
        RoleModel::where('id', $id)->delete();
        RoleModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::manage.role.delete').':'.$role['name'], '', [], $role->toArray());
        return $this->showMessage('thinkwinds::public.delete.success');
    }
}

