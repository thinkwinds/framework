<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Thinkwinds\Framework\Model\RoleModel;
use Thinkwinds\Framework\Model\ManageUserModel;
use Thinkwinds\Framework\Model\ManageLoginLogModel;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $manager = $request->session()->get('manager');
        if(!$manager) 
        {
            return redirect()->route('manage.auth.login');
        }
        $managers = decrypt($manager);
        list($uid, $username, $mobile, $email, $time) = explode('|', $managers);
        $uinfo = ManageUserModel::getUser($uid);
        if(!$uinfo)
        {
            $request->session()->forget('manager');
            return redirect()->route('manage.auth.login');
        }
        if($uinfo['status'] == 1) 
        {
            $request->session()->forget('manager');
            ManageLoginLogModel::addLog(tw_manager(), tw_lang('thinkwinds::manage.user.disable.log'));
            return redirect()->route('manage.auth.login')->withInput()->withErrors(['password'=> tw_lang('thinkwinds::manage.user.disable')]);
        }
        $loginCitme = tw_config('safe', 'manage.login.ctime') ? tw_config('safe', 'manage.login.ctime') : 30;
        if((tw_time() - $time) > $loginCitme*60 && !Session::get('manager_locked')) 
        {
            ManageLoginLogModel::addLog(tw_manager(), tw_lang('thinkwinds::manage.ctime.logout'));
            $request->session()->forget('manager');
            return redirect()->route('manage.auth.login');
        }
        Session::put('manager', encrypt($uinfo['uid'].'|'.$uinfo['username'].'|'.$uinfo['mobile'].'|'.$uinfo['email'].'|'.tw_time()));
        $route = Route::currentRouteName();
        if(Session::get('manager_locked')) 
        {
            if($route && !in_array($route, ['manage.index.locked', 'manage.index.unLocked', 'manage.index.doLocked'])) 
            {
                if(substr_count($_SERVER['HTTP_ACCEPT'], 'application/json')) 
                {
                    $viewData = [
                        'message'=> tw_lang('thinkwinds::public.lockeds')
                    ];
                    return response()->json($viewData);
                }
                return redirect()->route('manage.index.locked');
            }
        }
        if($uinfo['gid'] != '99') 
        {
            $ips = @tw_config('safe', 'manage.login.ips');
            $ips = isset($ips) ? empty($ips) ? array() : explode(',', $ips) : '';
            if($ips && !tw_verifyip(tw_ip(), $ips)) 
            {
                //ajax提交还没写
                Session::forget('manager');
                return $this->showError(['username'=> tw_lang('thinkwinds::manage.no.auth')], 'manage.auth.login', 2);
            }
            $roleInfo = RoleModel::getInfo($uinfo['gid']);
            if($route && !in_array($route, ['manage.index.index', 'manage.index.home', 'manage.index.userInfoEdit', 'manage.index.userInfoEditSave']) && !in_array($route, $roleInfo['auths'])) 
            {
                if(substr_count($_SERVER['HTTP_ACCEPT'], 'application/json')) 
                {
                    $viewData = [
                        'message'=> tw_lang('thinkwinds::manage.no.auth'),
                        'referer'=> '',
                        'state' => 'fail',
                        'with' => 0
                    ];
                    return response()->json($viewData);
                }
                //ajax提交还没写
                return back()->with(['state'=>'error', 'message'=> tw_lang('thinkwinds::manage.no.auth')]);
            }
        }
        $request->attributes->add(['managerInfo'=>$uinfo]);    //添加参数
        return $next($request);
    }
}
