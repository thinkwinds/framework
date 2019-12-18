<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Auth;
use Illuminate\Database\Eloquent\Model;

class SmsModel extends Model
{
    protected $table = 'sms_logs';
    protected $fillable = [
        'id', 'uid', 'type', 'note', 'content', 'mobile', 'times', 'status', 'sendnum', 'code', 'rtype', 'requestid', 'jstimes', 'stimes'
    ];
    public $timestamps = false;

    static function addInfo($mobile, $type, $code, $content = '', $note = '', $rtype = '', $requestid = 0, $uid = 0) 
    {
        $postData = [
            'mobile'=>$mobile,
            'type'=>$type,
            'code'=>$code,
            'uid'=>isset($uid) && $uid ? $uid : (int)Auth::id(),
            'note'=>$note,
            'content'=>$content,
            'sendnum'=>1,
            'status'=>1,
            'requestid'=>(string)$requestid,
            'rtype'=>(string)$rtype,
            'times'=> tw_time()
        ];
        SmsModel::insert($postData);
        return true;
    }

    static function getPlatform($k = '') 
    {
        $platforms = [
            'huasituo' => [
                'alias'=>'huasituo',
                'name'=>tw_lang('thinkwinds::manage.huasituo.sms'),
                'desc'=>tw_lang('thinkwinds::manage.huasituo.sms.tips'),
                'surl'=>route('manage.sms.cloud.config'),
                'components'=>'Thinkwinds\Framework\Libraries\ThinkwindsSmsApi'
            ]
        ];
        $platforms = thinkwinds_widget('s_sms', $platforms, true);
        if($k) {
            return isset($platforms[$k]) ? $platforms[$k] : [];
        }
        return $platforms;
    }

    static function getType($k = '')
    {
        $types = [
            'code'=>[
                'name'=>tw_lang('thinkwinds::public.captcha'),
                'num'=>'100',
                'content'=>'',
                'desc'=> '',
                'descs'=>tw_lang('thinkwinds::manage.sms.content.r'),
            ],
            'register'=>[
                'name'=>tw_lang('thinkwinds::public.register'),
                'num'=>'10',
                'content'=>'',
                'desc'=>tw_lang('thinkwinds::manage.sms.register.tips'),
                'descs'=>tw_lang('thinkwinds::manage.sms.content.r'),
            ],
            'login'=>[
                'name'=>tw_lang('thinkwinds::public.login'),
                'num'=>'15',
                'content'=>'',
                'desc'=>tw_lang('thinkwinds::manage.sms.login.tips'),
                'descs'=>tw_lang('thinkwinds::manage.sms.content.r'),
            ],
            'findpw'=>[
                'name'=>tw_lang('thinkwinds::public.findpw'),
                'num'=>'10',
                'content'=>'',
                'desc'=>tw_lang('thinkwinds::manage.sms.findpw.tips'),
                'descs'=>tw_lang('thinkwinds::manage.sms.content.r'),
            ],
        ];
        $types = thinkwinds_widget('s_sms_types', $types, true);
        if($k && isset($types[$k])) 
        {
            return $types[$k];
        }
        return $types;
    }
}
