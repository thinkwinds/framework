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


class UserController extends BasicController
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
        $users = ManageUserModel::getUsers();
        $roles = RoleModel::getRoles();
        $this->navs['add'] = ['name'=>tw_lang('thinkwinds::public.add').tw_lang('thinkwinds::public.user'), 'url'=>'manage.user.add', 'class'=>'J_dialog', 'title'=>tw_lang('thinkwinds::public.add').tw_lang('thinkwinds::public.user')];
        $view = [
            'users'=>$users,
            'roles'=>$roles,
            'navs'=>$this->getNavs('user')
        ];
    	return $this->loadTemplate('user.index', $view);
    }

    public function add(Request $request)
    {
        $roles = RoleModel::getRoles();
        $view = [
            'roles'=>$roles,
        ];
        return $this->loadTemplate('user.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gid' => 'required',
            'username' => 'required',
            'password' => 'required|between:6,16|string',
            'name' => 'required',
            //'email' => 'required|email',
            'mobile' => 'required'
        ],[
            'gid.required'=>tw_lang('thinkwinds::manage.enter.one.role.name'),
            'username.required'=>tw_lang('thinkwinds::public.username.empty'),
            'password.required'=>tw_lang('thinkwinds::public.password.empty'),
            'password.between' => tw_lang('thinkwinds::public.password.length.tips'),
            'name.required' => tw_lang('thinkwinds::public.realname.empty'),
            'mobile.required'=>tw_lang('thinkwinds::public.mobile.empty'),
            //'email.required'=>tw_lang('thinkwinds::public.email.empty'),
            //'email.email'=>tw_lang('thinkwinds::public.email.error')
        ]);

        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }

        if ($request->get('gid') < 1) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.select.role'));
        }
        $user = ManageUserModel::where('username', trim($request->get('username')))->first();
        if($user) 
        {
            return $this->showError('thinkwinds::manage.founder.username.noone');
        }
        $salt = tw_random(6);
        $postData = [
            'username'=>trim($request->get('username')),
            'password'=>trim(tw_md5(trim($request->get('password')), $salt)),
            'salt'=>$salt,
            'name'=>trim($request->get('name')),
            'mobile'=>trim($request->get('mobile')),
            'email'=>trim($request->get('email')),
            'weixin'=>trim($request->get('weixin')),
            'qq'=>trim($request->get('qq')),
            'status'=>tw_switch($request, 'status', true),
            'gid'=>trim($request->get('gid'))
        ];
        ManageUserModel::insert($postData);
        ManageUserModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::manage.founder.add').':'.trim($request->get('username')), '', $postData, []);
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function edit($uid)
    {
        if(!$uid) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $user = ManageUserModel::where('uid', $uid)->first();
        if(!$user) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $roles = RoleModel::getRoles();
        $view = [
            'info'=>$user,
            'uid'=>$uid,
            'roles'=>$roles
        ];
        return $this->loadTemplate('user.edit', $view);
    }

    public function editSave(Request $request)
    {
        $uid = (int)$request->get('uid');
        if(!$uid) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $user = ManageUserModel::where('uid', $uid)->first();
        if(!$user) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            //'password' => 'between:6,16|string',
            'name' => 'required',
            //'email' => 'required|email',
            'mobile' => 'required',
        ],[
            //'password.required'=>tw_lang('thinkwinds::public.password.empty'),
            //'password.between' => tw_lang('thinkwinds::public.password.length.tips'),
            'name.required' => tw_lang('thinkwinds::public.realname.empty'),
            'mobile.required'=>tw_lang('thinkwinds::public.mobile.empty'),
            //'email.required'=>tw_lang('thinkwinds::public.email.empty'),
            //'email.email'=>tw_lang('thinkwinds::public.email.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        if ($request->get('gid') < 1) 
        {
            return $this->showError(tw_lang('thinkwinds::manage.select.role'));
        }
        $editData = [
            'name'=>trim($request->get('name')),
            'mobile'=>trim($request->get('mobile')),
            'email'=>trim($request->get('email')),
            'weixin'=>trim($request->get('weixin')),
            'qq'=>trim($request->get('qq')),
            'status'=>tw_switch($request, 'status', true),
            'gid'=>trim($request->get('gid'))
        ];
        if($request->get('password')) 
        {
            $editData['password'] = trim(tw_md5(trim($request->get('password')), $user['salt']));
        }
        ManageUserModel::where('uid', $uid)->update($editData);
        ManageUserModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::manage.founder.user.edit').':'.$user['username'], '', $editData, $user->toArray());
        return $this->showMessage('thinkwinds::public.save.success'); 
    }

    public function delete($uid)
    {
        if(!$uid) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $user = ManageUserModel::where('uid', $uid)->first();
        if(!$user) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        if($uid == tw_manager('uid')) 
        {
            return $this->showError('thinkwinds::manage.founder.delete.my');
        }
        ManageUserModel::where('uid', $uid)->delete();
        ManageUserModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::manage.founder.user.delete').':'.$user['username'], '', [], $user->toArray());
        return $this->showMessage('thinkwinds::public.delete.success'); 
    }
}

