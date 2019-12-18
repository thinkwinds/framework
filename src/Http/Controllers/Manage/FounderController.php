<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\ManageUserModel;

class FounderController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'add'=>['name'=>tw_lang('thinkwinds::manage.founder.add'), 'url'=>'manage.founder.add', 'class'=>'J_dialog', 'title'=>tw_lang('thinkwinds::manage.founder.add')]
        ];
    }

    public function index(Request $request)
    {
        $founders = ManageUserModel::getFounder();
        $view = [
            'founders'=>$founders,
            'navs'=>$this->getNavs('index', true)
        ];
    	return $this->loadTemplate('founder.index', $view);
    }

    public function add(Request $request)
    {
        return $this->loadTemplate('founder.add');
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|between:6,16|string',
            'name' => 'required',
            //'email' => 'required|email',
            'mobile' => 'required',
        ],[
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
            'gid'=>99
        ];
        ManageUserModel::insert($postData);
        ManageUserModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::manage.founder.add').':'.trim($request->get('username')), '', $postData, []);
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function edit($uid, Request $request)
    {
        if(!$uid) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $user = ManageUserModel::getUser($uid);
        if(!$user) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $view = [
            'info'=>$user,
            'uid'=>$uid
        ];
        return $this->loadTemplate('founder.edit', $view);
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
            //'password.required'=>tw_lang('thinkwinds::manage.user.password.empty'),
            //'password.between' => tw_lang('thinkwinds::manage.user.password.length.tips'),
            'name.required' => tw_lang('thinkwinds::public.realname.empty'),
            'mobile.required'=>tw_lang('thinkwinds::public.mobile.empty'),
            //'email.required'=>tw_lang('thinkwinds::public.email.empty'),
            //'email.email'=>tw_lang('thinkwinds::public.email.error')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $editData = [
            'name'=>trim($request->get('name')),
            'mobile'=>trim($request->get('mobile')),
            'email'=>trim($request->get('email')),
            'weixin'=>trim($request->get('weixin')),
            'qq'=>trim($request->get('qq')),
            'status'=>tw_switch($request, 'status', true)
        ];
        if($request->get('password')) 
        {
            $editData['password'] = trim(tw_md5(trim($request->get('password')), $user['salt']));
        }
        ManageUserModel::where('uid', $uid)->update($editData);
        ManageUserModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::manage.founder.edit').':'.$user['username'], '', $editData, $user->toArray());
        return $this->showMessage('thinkwinds::public.edit.success'); 
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
        $count = ManageUserModel::where('gid', 99)->count();
        if($count < 2) 
        {
            return $this->showError('thinkwinds::manage.founder.one');
        }
        ManageUserModel::where('uid', $uid)->delete();
        ManageUserModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::manage.founder.delete').':'.$user['username'], '', [], $user->toArray());
        return $this->showMessage('thinkwinds::public.delete.success'); 
    }
}

