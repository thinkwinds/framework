<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\AreaModel;

class AreaController extends BasicController
{
    public $module = 'default';
    public $relatedid = 0;

    public function __construct(Request $request)
    {
        parent::__construct();
        $module = $request->get('module');
        if($module) 
        {
            $this->module = $module;
        }
        $this->navs = [
            'index'=>['name'=>tw_lang('thinkwinds::manage.area.manage'), 'url'=>route('manage.area.index')],
            'update'=>['name'=>tw_lang('thinkwinds::manage.area.update'), 'url'=>route('manage.area.index', ['isupdate'=>1,'areaid'=>$request->get('areaid')])],
            'cache'=>['name'=>tw_lang('thinkwinds::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manage.area.cache')]
        ];
        $this->tw_data['module'] = $this->module;
    }

    public function index(Request $request)
    {
        $areaid = (int)$request->get('areaid');
        $areaInfo = [];
        if($areaid) 
        {
            $areaInfo = AreaModel::getInfoByAreaid($areaid);
            if($areaInfo) 
            {
                foreach ($areaInfo['joinids'] as $key => $value) 
                {
                    $this->navs['index'.$value] = ['name'=>$areaInfo['joinnames'][$key], 'url'=>route('manage.area.index', ['areaid'=>$value])];
                }
            }
        }
        $this->navs['add'] = ['name'=>tw_lang('thinkwinds::public.add'), 'url'=>route('manage.area.add', ['areaid'=>$areaid]), 'class'=>'J_dialog', 'title'=>tw_lang('thinkwinds::public.add')];
        $list = AreaModel::getSubByAreaid($areaid);
        if($request->get('isupdate')) 
        {
            $pinfo = AreaModel::getInfoByAreaid($areaid);
            foreach ($list as $key => $value) 
            {
                AreaModel::where('areaid', $value['areaid'])->update([
                    'joinname'=>trim(isset($pinfo['joinname']) ? $pinfo['joinname'] . '|' . $value['name'] : $value['name'] , '|'),
                    'initials'=>tw_word2pinyin($value['name'], false, true, false, true)
                ]);
            }
            return $this->showMessage('thinkwinds::manage.area.update.success', 5);
        }
        $view = [
            'list'=>$list,
            'navs'=>$this->getNavs('index'.($areaid ? $areaid : ''))
        ];
	   return $this->loadTemplate('thinkwinds::manage.area.index', $view);
    }

    public function add(Request $request)
    {
        $view = [
            'areaid'=>$request->get('areaid')
        ];
        return $this->loadTemplate('thinkwinds::manage.area.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'areaid' => 'required',
            'name' => 'required'
        ],[
            'areaid.required'=>tw_lang('thinkwinds::manage.area.areaid.empty'),
            'name.required'=>tw_lang('thinkwinds::manage.area.name.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $parentid = $request->get('parentid');
        $areaid = $request->get('areaid');
        $info = AreaModel::getInfoByAreaid($areaid);
        if($info) 
        {
            return $this->showError('thinkwinds::manage.area.areaid.one');
        }
        $pinfo = AreaModel::getInfoByAreaid($parentid);
        $psotData = [
            'name'=>$request->get('name'),
            'areaid'=>$request->get('areaid'),
            'parentid'=>$request->get('parentid'),
            'zip'=>(int)$request->get('zip'),
            'vieworder'=>0,
            'joinname'=>isset($pinfo['joinname']) ? trim($pinfo['joinname'] . '|' . $request->get('name'), '|') : $request->get('name'),
            'initials'=>tw_word2pinyin($request->get('name'), false, true, false, true)
        ];
        AreaModel::updateData($areaid, $psotData);
        AreaModel::setCacheInfo($areaid);
        AreaModel::setCacheSubByAreaid(0);
        AreaModel::setCacheSubByAreaid($areaid);
        AreaModel::setCacheCityAll();
        $this->addOperationLog(tw_lang('thinkwinds::manage.area.add').':'.trim($request->get('name')), '', $psotData, []);
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function edit($areaid, Request $request)
    {
        if(!$areaid) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = AreaModel::where('areaid', $areaid)->first();
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $view = [
            'areaid'=> $areaid,
            'info'=> $info,
        ];
        return $this->loadTemplate('thinkwinds::manage.area.edit', $view);
    }

    public function editSave(Request $request)
    {
        $areaid = $request->get('areaid');
        if(!$areaid) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = AreaModel::getInfo($areaid);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.area.name.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $pinfo = AreaModel::getInfoByAreaid($info['parentid']);
        $psotData = [
            'name'=>$request->get('name'),
            'zip'=>(int)$request->get('zip'),
            'joinname'=>trim(isset($pinfo['joinname']) ? $pinfo['joinname'] . '|' . $request->get('name') : $request->get('name') , '|'),
            'initials'=>tw_word2pinyin($request->get('name'), false, true, false, true)
        ];
        AreaModel::where('areaid', $areaid)->update($psotData);
        AreaModel::setCacheInfo($areaid);
        AreaModel::setCacheSubByAreaid(0);
        AreaModel::setCacheSubByAreaid($areaid);
        AreaModel::setCacheCityAll();
        $this->addOperationLog(tw_lang('thinkwinds::manage.area.edit').':'.$areaid, '', $psotData, $info);
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }

    public function delete($areaid, Request $request)
    {
        if(!$areaid) 
        {
            return $this->showError('thinkwinds::public.no.id', 5);
        }
        $info = AreaModel::getInfoByAreaid($areaid, true);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', 5);
        }
        if($info['sublist']) 
        {
            return $this->showError('thinkwinds::manage.area.delete.001', 5);
        }
        unset($info['sublist']);
        AreaModel::where('areaid', $areaid)->delete();
        AreaModel::setCacheInfo($areaid);
        AreaModel::setCacheSubByAreaid(0);
        AreaModel::setCacheSubByAreaid($areaid);
        AreaModel::setCacheCityAll();
        $this->addOperationLog(tw_lang('thinkwinds::manage.area.delete').':'.$info['name'], '', [], $info);
        return $this->showMessage('thinkwinds::public.delete.success', 5); 
    }

    public function cache(Request $request)
    {
        AreaModel::setCacheSubByAreaid(0, true);
        AreaModel::setCacheCityAll();
        return $this->showMessage('thinkwinds::public.successful', 5); 
    }
}