<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Thinkwinds\Framework\Model\ManageLoginLogModel;
use Thinkwinds\Framework\Model\ManageOperationLogModel;

class LogController extends BasicController
{

    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'request'=>['name'=>tw_lang('thinkwinds::manage.request.log'),'url'=>'manage.log.request'],
            'operation'=>['name'=>tw_lang('thinkwinds::manage.operation.log'),'url'=>'manage.log.operation'],
            'login'=>['name'=>tw_lang('thinkwinds::manage.login.log'),'url'=>'manage.log.login'],
        ];
    }

    public function logRequest(Request $request)
    {
        if($request->get('_ajax'))
        {
            $data = $list = $args = array();
            $time = $request->get('time');
            $uri = $request->get('uri');
            $ip = $request->get('ip');
            $username = $request->get('username');
            $args['time'] = $time ? $time : tw_tdtime();
            $times = tw_str2time($time);
            $times = $times ? $times : tw_time();
            $file = base_path('storage/thinkwinds/requestlog/'. tw_time2str($times, 'Ym') . '/'.tw_time2str($times, 'd').'.log');
            $file = @file_get_contents($file);
            $page = max(1, (int)$request->get('page'));
            $perPage = $this->paginate;
            if($file) 
            {
                $data = @explode(PHP_EOL, $file);
                $data = explode(PHP_EOL, $file);
                $data = $data ? array_reverse($data) : array();
                unset($data[0]);
                foreach ($data as $k => $v)  
                {
                    $data[$k] = unserialize($v);
                    if($username && $data[$k]['username'] != $username) 
                    {
                        unset($data[$k]);
                    }
                    if($ip && $data[$k]['ip'] != $ip) 
                    {
                        unset($data[$k]);
                    }
                    if($uri && $data[$k]['uri'] != $uri) 
                    {
                        unset($data[$k]);
                    }
                    if(isset($data[$k])){
                        $data[$k]['_data'] = json_encode($data[$k]['data']);
                        $data[$k]['times'] = tw_time2str($data[$k]['times'], 'Y-m-d H:i:s');
                    }
                }
            }
            $total = count($data);
            $item = array_slice($data, ($page-1)*$perPage, $perPage);
            $paginator =new LengthAwarePaginator($item, $total, $perPage, $page, ['pageName'=>'page']);
            $paginator->setPath('request')->appends($args);
            $list = $paginator->toArray()['data'];
            $this->addMessage($paginator, 'list');
            return $this->showMessage('thinkwinds::public.successful');
        }
        $this->tw_data['navs'] = $this->getNavs('request');
    	return $this->loadTemplate('log.request');
    }

    public function logOperation(Request $request)
    {
        if($request->get('_ajax')) 
        {
            $ip = $request->input('ip');
            $stime = $request->input('stime');
            $etime = $request->input('etime');
            $username = $request->input('username');
            $OperationLog = ManageOperationLogModel::where('id', '>', 0);
            if($ip) 
            {
                $OperationLog->where('ip', $ip);
            }
            if($username) 
            {
                $OperationLog->where('username', $username);
            }
            if($stime) 
            {
                $stime = tw_str2time($stime);
                $OperationLog->where('times', '>=', $stime);
            }
            if($etime) 
            {
                $etime = tw_str2time($etime);
                $OperationLog->where('times', '<=', $etime);
            }
            $list = $OperationLog->orderby('times', 'desc')->paginate($this->paginate);
            foreach ($list as $key => $value) 
            {
                $list[$key]['times'] = tw_time2str($value['times'], 'Y-m-d H:i:s');
                $list[$key]['viewurl'] = route('manage.log.operationView', ['id'=>$value['id']]);
            }
            $this->addMessage($list, 'list');
            return $this->showMessage('thinkwinds::public.successful');
        }
        $view = [
            'navs'=>$this->getNavs('operation')
        ];
        return $this->loadTemplate('log.operation', $view);
    }

    public function logOperationView($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = ManageOperationLogModel::where('id', $id)->first();
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $info['olddata'] = unserialize($info['olddata']);
        $info['newdata'] = unserialize($info['newdata']);
        if(!$info['status']) 
        {
            $editData = [
                'status'=>1,
                'suid'=>tw_manager('uid'),
                'susername'=> tw_manager('username'),
                'stimes'=> tw_time()
            ];
            ManageOperationLogModel::where('id', $id)->update($editData);
        }
        $view = [
            'info'=>$info
        ];
        return $this->loadTemplate('log.operation_view', $view);
    }

    public function logLogin(Request $request)
    {
        if($request->get('_ajax')){
            $ip = $request->input('ip');
            $username = $request->input('username');
            $stime = $request->input('stime');
            $etime = $request->input('etime');
            $LoginLog = ManageLoginLogModel::where('id', '>', 0);
            if($ip) 
            {
                $LoginLog->where('ip', $ip);
            }
            if($username) 
            {
                $LoginLog->where('username', $username);
            }
            if($stime) 
            {
                $stime = tw_str2time($stime);
                $LoginLog->where('times', '>=', $stime);
            }
            if($etime) 
            {
                $etime = tw_str2time($etime);
                $LoginLog->where('times', '<=', $etime);
            }
            $list = $LoginLog->orderby('times', 'desc')->paginate($this->paginate);
            foreach ($list as $key => $value) 
            {
                $list[$key]['times'] = tw_time2str($value['times'], 'Y-m-d H:i:s');
            }
            $this->addMessage($list, 'list');
            return $this->showMessage('thinkwinds::public.successful');
        }
        $this->tw_data['navs'] = $this->getNavs('login');
        return $this->loadTemplate('log.login');
    }
}

