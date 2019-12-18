<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Libraries\ThinkwindsSign;
use Thinkwinds\Framework\Libraries\ThinkwindsCurl;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;

use Thinkwinds\Framework\Libraries\ThinkwindsCall;

class TestController extends BaseController
{
    public function index() 
    {
        $ThinkwindsCall = new ThinkwindsCall();
        $ThinkwindsCallType = $ThinkwindsCall->get('system', 'html');
        return $this->loadTemplate('thinkwinds::test.index');
    }

    public function api() 
    {
        $appid = '1847220978';
        $Secret = 'voiggoxucwcf85p0s9k8ezgux5mq900t';
        $uri = 'area/get/id/by/name';
        $me = 'get';
        $data = [
            'areaid'=>'0',
            'province'=>'四川省',
            'city'=>'达州市',
            'area'=>'大竹县',
        ];
        $ThinkwindsSign = new ThinkwindsSign();
        $sign = $ThinkwindsSign->createSign($data, $Secret);
        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';
        $ThinkwindsCurl = new ThinkwindsCurl();
        $ThinkwindsCurl->url = url('api'.'/'.$uri);
        $ThinkwindsCurl->isHeaders = true;
        $ThinkwindsCurl->setHeader([
            'appid'=>$appid
        ]);
        if($me == 'get') 
        {
            $ThinkwindsCurl->get($data);
        } else if($me == 'post') {
            $ThinkwindsCurl->post($data);
        }
        $result = $ThinkwindsCurl->data(true);
        print_r($ThinkwindsCurl->headers());
        echo $ThinkwindsCurl->data(false).PHP_EOL.PHP_EOL;
        print_r($result);
    }

    //钩子测试页面
    public function widget(Request $request) 
    {
        $data = thinkwinds_widget('s_test_arr', ['a'=>1], true);
        return $this->loadTemplate('thinkwinds::test.widget', ['data'=>$data]);
    }

    //验证码测试页面
    public function captcha(Request $request)
    {
        return $this->loadTemplate('thinkwinds::test.captcha');
    }

    //验证码测试提交
    public function captchaCheck(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ],[
            'code.required'=>tw_lang('thinkwinds::captcha.please.enter.the.verification.code')
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput();
        }
    }
}