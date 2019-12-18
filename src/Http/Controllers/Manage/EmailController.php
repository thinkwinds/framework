<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Thinkwinds\Framework\Libraries\ThinkwindsEmail;

class EmailController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'index'=>['name'=>tw_lang('thinkwinds::manage.email.config'),'url'=>'manage.config.email.index'],
            'test'=>['name'=>tw_lang('thinkwinds::manage.email.test'),'url'=>'manage.config.email.test'],
        ];
    }

    public function index(Request $request)
    {
    	$config = tw_config('email');
        $this->tw_data['navs'] = $this->getNavs('index');
    	return $this->loadTemplate('email.index', ['config'=>$config]);
    }

    public function save(Request $request)
    {
    	$arrRequest = $request->all();
    	$data =[
            ['name'=>'host', 'value'=>$arrRequest['host']],
            ['name'=>'port', 'value'=>$arrRequest['port']],
            ['name'=>'from', 'value'=>$arrRequest['from']],
            ['name'=>'from.name', 'value'=>$arrRequest['fromName']],
    		['name'=>'auth', 'value'=>tw_switch($arrRequest, 'auth')],
    		['name'=>'user', 'value'=>$arrRequest['user']],
            ['name'=>'password', 'value'=>$arrRequest['password']],
    	];
        $configData = [
            'MAIL_HOST' => $arrRequest['host'] ? trim($arrRequest['host']) : '',
            'MAIL_PORT' => $arrRequest['port'] ? trim($arrRequest['port']) : 25,
            'MAIL_USERNAME' => $arrRequest['user'] ? trim($arrRequest['user']) : '',
            'MAIL_PASSWORD' => $arrRequest['password'] ? trim($arrRequest['password']) : '',
            'MAIL_FROM_ADDRESS' => $arrRequest['from'] ? trim($arrRequest['from']) : '',
            'MAIL_FROM_NAME' => $arrRequest['fromName'] ?  trim($arrRequest['fromName']) : ''
        ];
        $oldConfig = tw_config('email');
    	tw_save_config('email', $data);
        tw_updateEnvInfo($configData);
        $this->addOperationLog(tw_lang('thinkwinds::manage.config.email.update'),'', tw_config('email'), $oldConfig);
        return $this->showMessage('thinkwinds::public.save.success');
    }

    public function test(Request $request)
    {
        $config = tw_config('email');
        $this->tw_data['navs'] = $this->getNavs('test');
        return $this->loadTemplate('email.test', ['config'=>$config]);
    }

    public function testSubmit(Request $request)
    {
        $toemail = $request->get('toemail');
        $validator = Validator::make($request->all(), [
            'toemail' => 'required|email'
        ],[
            'toemail.required'=>tw_lang('thinkwinds::manage.email.toemail.empty'),
            'toemail.email'=>tw_lang('thinkwinds::manage.email.toemail.error')
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $flag = ThinkwindsEmail::sendMail(['email'=>$toemail, 'title'=>tw_lang('thinkwinds::manage.email.test.title')], 'thinkwinds::mail.test');
        if(!$flag) 
        {
            $this->addOperationLog(tw_lang('thinkwinds::public.to').$toemail.tw_lang('thinkwinds::manage.email.test.success'));
            return $this->showMessage('thinkwinds::public.send.success');
        } else {
            $this->addOperationLog(tw_lang('thinkwinds::public.to').$toemail.tw_lang('thinkwinds::manage.email.test.error'));
            return $this->showMessage('thinkwinds::public.send.error');
        }
    }
}

