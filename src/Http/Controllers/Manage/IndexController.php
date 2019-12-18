<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Thinkwinds\Framework\Model\RoleModel;
use Thinkwinds\Framework\Model\ManageMenuModel;
use Thinkwinds\Framework\Model\ManageUserModel;
use Thinkwinds\Framework\Model\ManageLoginLogModel;

class IndexController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $user = tw_manager();
        $menus = ManageMenuModel::getMenu($user);
        $view = [
            'menus' => json_encode($menus),
            'userInfo'=>$user
        ];
        $locked = Session::get('manager_locked');
        if($locked) 
        {
            return redirect()->route('manage.index.locked');
        }
    	return $this->loadTemplate('index', $view);
    }

    public function home(Request $request)
    {
        $user = tw_manager();
        $view = [
            'userInfo'=>$user
        ];
        return $this->loadTemplate('home', $view);
    }

    public function locked(Request $request)
    {
        $user = tw_manager();
        $menus = ManageMenuModel::getMenu($user);
        $view = [
            'menus' => json_encode($menus),
            'userInfo'=>$user
        ];
        $locked = Session::get('manager_locked');
        return $this->loadTemplate('locked', $view);  
    }

    public function doLocked(Request $request)
    {
        Session::put('manager_locked', 1);
        return $this->showMessage('thinkwinds::public.successful');       
    }

    public function unLocked(Request $request)
    {
        $uid = tw_manager('uid');
        $user = ManageUserModel::getUser($uid);
        if(!$user) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'password' => 'required|between:6,16|string'
        ],[
            'password.required'=> tw_lang('thinkwinds::public.password.empty'),
            'password.between' => tw_lang('thinkwinds::public.password.length.tips')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator, 'manage.index.locked', 2);
        }
        if (!ManageUserModel::checkPassword($user['username'], $request->get('password'))) 
        {
            ManageLoginLogModel::addLog(['uid'=>$user['uid'], 'username'=>$user['username']], tw_lang('thinkwinds::public.unLocked.password.error'));
            return $this->showError(['password'=> tw_lang('thinkwinds::public.unLocked.password.error')], 'manage.index.locked', 2);
        }
        ManageLoginLogModel::addLog($user, tw_lang('thinkwinds::public.unLocked.success'));
        Session::put('manager_locked', 0);
        return redirect()->route('manage.index.index');
    }

    public function customSet(Request $request)
    {

    }

    public function userInfoEdit($uid, Request $request)
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
        if($user['uid'] != tw_manager('uid')) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $view = [
            'info'=>$user,
            'uid'=>$uid
        ];
        return $this->loadTemplate('user.edit_info', $view);
    }

    public function userInfoEditSave(Request $request)
    {
        $uid = (int)$request->get('uid');
        if(!$uid) {
            return $this->showError('thinkwinds::public.no.id');
        }
        $user = ManageUserModel::where('uid', $uid)->first();
        if(!$user) {
            return $this->showError('thinkwinds::public.no.data');
        }
        if($user['uid'] != tw_manager('uid')) {
            return $this->showError('thinkwinds::public.no.id');
        }
        $validator = Validator::make($request->all(), [
            //'password' => 'between:6,16|string',
            'name' => 'required',
            'mobile' => 'required',
        ],[
            //'password.required'=>tw_lang('thinkwinds::manage.user.password.empty'),
            //'password.between' => tw_lang('thinkwinds::manage.user.password.length.tips'),
            'name.required' => tw_lang('thinkwinds::public.realname.empty'),
            'mobile.required'=>tw_lang('thinkwinds::public.mobile.empty')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $editData = [
            'name'=>trim($request->get('name')),
            'mobile'=>trim($request->get('mobile')),
            'email'=>trim($request->get('email')),
            'weixin'=>trim($request->get('weixin')),
            'qq'=>trim($request->get('qq'))
        ];
        if($request->get('password')) {
            $editData['password'] = trim(tw_md5(trim($request->get('password')), $user['salt']));
        }
        ManageUserModel::where('uid', $uid)->update($editData);
        ManageUserModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::manage.founder.user.edit').':'.$user['username'], '', $editData, $user);
        if($request->get('password')) {
            ManageLoginLogModel::addLog(tw_manager(), tw_lang('thinkwinds::manage.founder.user.edit').tw_lang('thinkwinds::manage.logout.success'));
            Session::forget('manager');
            return $this->showMessage('thinkwinds::public.edit.success', route('manage.auth.login')); 
        }
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }
}

