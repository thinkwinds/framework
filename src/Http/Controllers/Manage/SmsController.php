<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\SmsModel;
use Thinkwinds\Framework\Libraries\ThinkwindsSmsApi;

class SmsController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'index'=>['name'=>tw_lang('thinkwinds::manage.sms.platform'),'url'=>'manage.sms.index'],
            'config'=>['name'=>tw_lang('thinkwinds::manage.sms.setting'),'url'=>'manage.sms.config'],
            'log'=>['name'=>tw_lang('thinkwinds::manage.sms.send.log'),'url'=>'manage.sms.log'],
        ];
    }

    public function index(Request $request)
    {
    	$config = tw_config('sms');
        if(!isset($config['platform']) || !$config['platform']) 
        {
            $config['platform'] = 'twcloud';
        }
        $platforms = SmsModel::getPlatform();
        $this->tw_data['navs'] = $this->getNavs('index');
    	return $this->loadTemplate('sms.index', ['config'=>$config, 'platforms'=>$platforms]);
    }

    public function save(Request $request)
    {
        $arrRequest = $request->all();
        $arrRequest['platform'] = $arrRequest['platform'] ? $arrRequest['platform'] : 'huasituo';
        $data =[
            ['name'=>'platform', 'value'=>trim($arrRequest['platform'])]
        ];
        $oldConfig = tw_config('sms');
        tw_save_config('sms', $data);
        $this->addOperationLog(tw_lang('thinkwinds::manage.sms.platform'),'', tw_config('sms'), $oldConfig);
        return $this->showMessage('thinkwinds::public.save.success');
    }

    public function config(Request $request)
    {
        $config = tw_config('sms');
        $this->tw_data['navs'] = $this->getNavs('config');
        $types = SmsModel::getType();
        return $this->loadTemplate('sms.config', ['config'=>$config, 'types'=>$types]);
    }

    public function configSave(Request $request) 
    {
        $arrRequest = $request->all();
        $types = SmsModel::getType();
        $data = [];
        if($types)
        {
            foreach ($types as $key => $value) 
            {
                $data['types'][$key]['status'] = tw_switch($arrRequest, $key);
                $data['types'][$key]['content'] = $request->get('types')[$key]['content'];
            }
        }
        $postData =[
            ['name'=>'types', 'value'=>$data['types'], 'issystem'=>1],
            ['name'=>'codelength', 'value'=>$arrRequest['codelength'], 'issystem'=>1],
            ['name'=>'product', 'value'=>$arrRequest['product'], 'issystem'=>1]
        ];
        $oldConfig = tw_config('sms');
        tw_save_config('sms', $postData);
        $this->addOperationLog(tw_lang('thinkwinds::manage.sms.update'),'', tw_config('sms'), $oldConfig);
        return $this->showMessage('thinkwinds::public.save.success');
    }

    public function hstsmsConfig(Request $request)
    {
        $config = tw_config('sms');
        $this->navs = [
            'hstsmsConfig'=>['name'=>tw_lang('thinkwinds::manage.sms.setting'),'url'=>'manage.sms.cloud.config'],
            'payHstsms'=>['name'=>tw_lang('thinkwinds::manage.sms.purchase'),'url'=>'manage.sms.cloud.buy'],
        ];
        $ThinkwindsSmsApi = new ThinkwindsSmsApi();
        $result = $ThinkwindsSmsApi->getSurplus();
        $this->viewData['navs'] = $this->getNavs('hstsmsConfig');
        return $this->loadTemplate('sms.hstsms', ['config'=>$config, 'surplus'=>$result]);
    }

    public function hstsmsConfigSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hstsmsappid' => 'required',
            'hstsmskey' => 'required',
            'hstsmssign' => 'required',
        ],[
            'hstsmsappid.required'=>tw_lang('thinkwinds::manage.sms.hstsmsappid.empty'),
            'hstsmskey.required'=>tw_lang('thinkwinds::manage.sms.hstsmskey.empty'),
            'hstsmssign.required'=>tw_lang('thinkwinds::manage.sms.hstsmssign.empty'),
        ]);
        if ($validator->fails()) {
            return $this->showError($validator->errors(), 2);
        }
        $arrRequest = $request->all();
        $data =[
            ['name'=>'hstsmsappid', 'value'=>trim($arrRequest['hstsmsappid'])],
            ['name'=>'hstsmskey', 'value'=>trim($arrRequest['hstsmskey'])],
            ['name'=>'hstsmssign', 'value'=>trim($arrRequest['hstsmssign'])],
        ];
        $oldConfig = tw_config('sms');
        tw_save_config('sms', $data);
        $this->addOperationLog(tw_lang('thinkwinds::manage.sms.hstsms.seeting'),'', tw_config('sms'), $oldConfig);
        return $this->showMessage('thinkwinds::public.save.success');

    }

    public function hstsmsBuy(Request $request) 
    {
        $config = tw_config('sms');
        $this->navs = [
            'hstsmsConfig'=>['name'=>tw_lang('thinkwinds::manage.sms.setting'),'url'=>'manage.sms.cloud.config'],
            'payHstsms'=>['name'=>tw_lang('thinkwinds::manage.sms.purchase'),'url'=>'manage.sms.cloud.buy'],
        ];
        $ThinkwindsSmsApi = new ThinkwindsSmsApi();
        $result = $ThinkwindsSmsApi->getSurplus();

        $this->viewData['navs'] = $this->getNavs('payHstsms');
        return $this->loadTemplate('sms.hstsms_buy', ['config'=>$config, 'surplus'=>$result]);
    }

    public function hstsmsBuys(Request $request) 
    {
        $ThinkwindsSmsApi = new ThinkwindsSmsApi();
        $result = $ThinkwindsSmsApi->getPay($request->get('money'));
        return redirect($result);
    }

    public function log(Request $request)
    {
        $type = $request->input('type');
        $status = $request->input('status');
        $uid = $request->input('uid');
        $mobile = $request->input('mobile');
        $stime = $request->input('stime');
        $etime = $request->input('etime');
        $listQuery = SmsModel::where('id', '>', 0);
        $args = ['status'=>0, 'type'=>''];
        if($uid) 
        {
            $args['uid'] = $uid;
            $listQuery->where('uid', $uid);
        }
        if($mobile) 
        {
            $args['mobile'] = $mobile;
            $listQuery->where('mobile', $mobile);
        }
        if($type) 
        {
            $args['type'] = $type;
            $listQuery->where('type', $type);
        }
        if($status) 
        {
            $args['status'] = $status;
            if ($status == 9) 
            {
                $status = 0;
            }
            $listQuery->where('status', $status);
        }
        if($stime) 
        {
            $args['stime'] = $stime;
            $stime = tw_str2time($stime);
            $listQuery->where('times', '>=', $stime);
        }
        if($etime) 
        {
            $args['etime'] = $etime;
            $etime = tw_str2time($etime);
            $listQuery->where('times', '<=', $etime);
        }
        $list = $listQuery->orderby('times', 'desc')->paginate($this->paginate);
        $this->tw_data['navs'] = $this->getNavs('log');
        $types = SmsModel::getType();
        $view = [
            'list'=>$list,
            'args'=>$args,
            'types'=>$types
        ];
        return $this->loadTemplate('thinkwinds::manage.sms.log', $view);
    }

    public function logView($id, Request $request) 
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = SmsModel::where('id', $id)->first();
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $this->navs['view'] = ['name'=>tw_lang('hstsms::public.log.view'), 'url'=>route('manage.sms.logView', ['id'=>$id])];
        $view = [
            'info'=>$info,
            'navs'=>$this->getNavs('view')
        ];
        return $this->loadTemplate('thinkwinds::manage.sms.log_view', $view);
    }
}

