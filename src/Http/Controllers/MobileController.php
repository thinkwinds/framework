<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Libraries\ThinkwindsSms;
use App\Modules\Account\Model\UsersModel;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;

class MobileController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function send(Request $request) 
    {
        $mobile = $request->get('mobile');
        $type = $request->get('type');
        if(!$mobile) 
        {
            return $this->showError(tw_lang('thinkwinds::public.enter.one.mobile'));
        }
        if(!$type) 
        {
            return $this->showError(tw_lang('thinkwinds::public.send.error'));
        }
        $user = UsersModel::getUsers($mobile, 'mobile', false);
        $uid = '';
        if(!Auth::id() && $user) 
        {
            $uid = $user['id']; 
        }
        $ThinkwindsSms = new ThinkwindsSms();
        $result = $ThinkwindsSms->sendMobileMessage($mobile, $type, [], $uid);
        if (tw_message_verify($result)) return $this->showError($result['message']);
        return $this->showMessage('Hstcms::public.send.success');
    }

    public function verify(Request $request) 
    {
        $mobile = $request->get('mobile');
        $type = $request->get('type');
        $mobileCode = $request->get('mobile_code');
        if(!$mobile) 
        {
            return $this->showError(tw_lang('thinkwinds::public.enter.one.mobile'));
        }
        if(!$mobileCode) 
        {
            return $this->showError(tw_lang('thinkwinds::public.enter.one.mobile.code'));
        }
        if(!$type) 
        {
            return $this->showError(tw_lang('thinkwinds::public.verification.failure'));
        }
        $ThinkwindsSms = new ThinkwindsSms();
        $result = $ThinkwindsSms->checkVerify($mobile, $mobileCode, $type);
        if (tw_message_verify($result))  return $this->showError($result['message']);
        return $this->showMessage('Hstcms::public.send.success');
    }
}