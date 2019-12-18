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
use Thinkwinds\Framework\Model\ManageUserModel;
use Thinkwinds\Framework\Model\ManageLoginLogModel;

class AuthController extends BasicController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 后台登录页面
     */
    public function login()
    {
        if (Session::get('manager')) 
        {
            return redirect()->route('manage.index.index');
        }
        $this->addMessage(tw_lang('thinkwinds::manage.login.title'), 'seo_title');
        return $this->loadTemplate('login');
    }

    /**
     * @param Request $request
     */
    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|between:6,16|string'
        ],[
            'username.required'=>tw_lang('thinkwinds::public.username.empty'),
            'password.required'=> tw_lang('thinkwinds::public.password.empty'),
            'password.between' => tw_lang('thinkwinds::public.password.length.tips')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator, 'manage.auth.login', 2);
        }
        if (!ManageUserModel::checkPassword($request->get('username'), $request->get('password'))) 
        {
            ManageLoginLogModel::addLog(['uid'=>0, 'username'=>$request->get('username')], tw_lang('thinkwinds::public.password.error'));
            return $this->showError(['password'=> tw_lang('thinkwinds::public.password.error')], 'manage.auth.login', 2);
        }
        $user = ManageUserModel::where('username', $request->get('username'))->first();
        if($user['status'] == 1) 
        {
            ManageLoginLogModel::addLog($user, tw_lang('thinkwinds::manage.user.disable'));
            return $this->showError(['password'=> tw_lang('thinkwinds::manage.user.disable')], 'manage.auth.login', 2);
        }
        if($user['gid'] != '99') 
        {
            $ips = @tw_config('safe', 'manage.login.ips');
            $ips = isset($ips) ? empty($ips) ? array() : explode(',', $ips) : '';
            if($ips && !tw_verifyip(tw_ip(), $ips)) 
            {
                return $this->showError(['username'=> tw_lang('thinkwinds::manage.safe.ip.no.auth')], 'manage.auth.login', 2);
            }
        }
        ManageLoginLogModel::addLog($user, tw_lang('thinkwinds::public.login.success'));
        ManageUserModel::managerDoLogin($user);
        return redirect()->route('manage.index.index');
    }

    /**
     * 后台登出
     */
    public function logout()
    {
        ManageLoginLogModel::addLog(tw_manager(), tw_lang('thinkwinds::public.logout.success'));
        Session::forget('manager');
        return redirect()->route('manage.auth.login');
    }
}
