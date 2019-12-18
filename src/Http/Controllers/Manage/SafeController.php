<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Illuminate\Http\Request;

class SafeController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
    	$config = tw_config('safe');
    	return $this->loadTemplate('safe.index', ['config'=>$config]);
    }

    public function save(Request $request)
    {
    	$arrRequest = $request->all();
        $ips = str_replace(array("\r\n", "\r", "\n", ";"), ",", $arrRequest['safeIps']);
        $ips = trim($ips, ' ,');
    	$data =[
    		['name'=>'manage.request', 'value'=>tw_switch($arrRequest, 'request'), 'issystem'=>1],
    		['name'=>'manage.operation', 'value'=>tw_switch($arrRequest, 'operation'), 'issystem'=>1],
    		['name'=>'manage.login.ips', 'value'=>$ips, 'issystem'=>1],
            ['name'=>'manage.login.ctime', 'value'=>$arrRequest['loginCtime'], 'issystem'=>1],
    	];
        $oldConfig = tw_config('safe');
    	tw_save_config('safe', $data);
        $this->addOperationLog(tw_lang('thinkwinds::manage.safe.update'),'', tw_config('safe'), $oldConfig);
        return $this->showMessage('thinkwinds::public.save.success');
    }
}

