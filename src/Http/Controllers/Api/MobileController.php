<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Api;

use Thinkwinds\Framework\Http\Controllers\Api\BasicController as ApiBaseController;

use Illuminate\Http\Request;
use App\Modules\Account\Model\UsersModel;
use Thinkwinds\Framework\Libraries\ThinkwindsSms;
/**
* 
*/
class MobileController extends ApiBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function send(Request $request) 
    {
        $mobile = $request->get('mobile');
        $type = $request->get('type');
        if(!$mobile) {
            return $this->message(hst_lang('hstcms::public.enter.one.mobile'), '-101');
        }
        if(!$type) {
            return $this->message(hst_lang('hstcms::public.send.error'), '-102');
        }
        if($type == 'login' || $type == 'findpw') {
            if(!UsersModel::where('mobile', $mobile)->first()) {
                return $this->message(hst_lang('account::public.username.error'), '-102');
            }
        }
        if($type == 'register') {
            if(UsersModel::where('mobile', $mobile)->first()) {
                return $this->message(hst_lang('account::public.mobile.has.used'), '-102');
            }
        }
        $uid = '';
        $HstcmsSms = new HstcmsSms();
        $result = $HstcmsSms->sendMobileMessage($mobile, $type, [], $uid);
        if (hst_message_verify($result)) return $this->message($result['message'], '-103');
        return $this->message(hst_lang('hstcms::public.send.success'));
    }
}