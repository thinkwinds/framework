<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\SpecialModel;

class SpecialController extends BasicController
{
    public $relatedid = 0;
    public $module = 'default';

    public function __construct(Request $request)
    {
        parent::__construct();
        $module = $request->get('module');
        if($module) 
        {
            $this->module = $module;
        }
        $this->navs = [
            'index'=>['name'=>tw_lang('thinkwinds::manage.special.manage'), 'url'=>route('manage.special.index', ['module'=>$this->module])],
            'add'=>['name'=>tw_lang('thinkwinds::manage.special.add'), 'url'=>route('manage.special.add', ['module'=>$this->module]), 'class'=>'J_dialog', 'title'=>tw_lang('thinkwinds::manage.special.add')],
            'cache'=>['name'=>tw_lang('thinkwinds::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manage.special.cache', ['module'=>$this->module])]
        ];
        $this->tw_data['module'] = $this->module;
    }

    public function index(Request $request)
    {
        $data = SpecialModel::getData($this->module, 'lists');
        $view = [
            'list'=>$data,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('thinkwinds::manage.special.index', $view);
    }

    public function add(Request $request)
    {
        $view = [
        ];
        return $this->loadTemplate('thinkwinds::manage.special.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'dir' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.special.name.empty'),
            'dir.required'=>tw_lang('thinkwinds::manage.special.dir.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $dirinfo = SpecialModel::hasSpecial($request->get('dir'), $this->module);
        if($dirinfo) 
        {
            return $this->showError('thinkwinds::manage.special.dir.one');
        }
        $psotData = [
            'name'=>$request->get('name'),
            'title'=>$request->get('title'),
            'module'=>$this->module,
            'keywords'=>$request->get('keywords'),
            'description'=>$request->get('description'),
            'domain'=>$request->get('domain'),
            'style'=>$request->get('style'),
            'dir'=>$request->get('dir'),
            'content'=>(string)$request->get('content'),
            'isopen'=>(int)tw_switch($request->all(), 'isopen'),
            'header'=>(int)tw_switch($request->all(), 'header'),
            'footer'=>(int)tw_switch($request->all(), 'footer'),
        ];
        $id = SpecialModel::insertGetId($psotData);
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.error');
        }
        SpecialModel::setCache($this->module);
        SpecialModel::setCache('all');
        SpecialModel::addInfo($id, $psotData);
        $this->addOperationLog(tw_lang('thinkwinds::manage.special.add').':'.trim($request->get('name')), '', $psotData, []);
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function edit($id, Request $request)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = SpecialModel::getInfo($id, $this->module);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $view = [
            'id'=> $id,
            'info'=> $info,
        ];
        return $this->loadTemplate('thinkwinds::manage.special.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = SpecialModel::getInfo($id, $this->module);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.special.name.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $dirinfo = SpecialModel::hasSpecial($request->get('dir'), $this->module, $id);
        if($dirinfo) 
        {
            return $this->showError('thinkwinds::manage.special.dir.one');
        }
        $psotData = [
            'name'=>$request->get('name'),
            'title'=>$request->get('title'),
            'keywords'=>$request->get('keywords'),
            'description'=>$request->get('description'),
            'style'=>$request->get('style'),
            'domain'=>$request->get('domain'),
            'dir'=>$request->get('dir'),
            'content'=>(string)$request->get('content'),
            'isopen'=>(int)tw_switch($request->all(), 'isopen'),
            'header'=>(int)tw_switch($request->all(), 'header'),
            'footer'=>(int)tw_switch($request->all(), 'footer'),
        ];
        SpecialModel::where('id', $id)->update($psotData);
        SpecialModel::setCache($this->module);
        SpecialModel::setCache('all');
        $this->updateSeo($id, $psotData['title'], $psotData['keywords'], $psotData['description']);
        $this->addOperationLog(tw_lang('thinkwinds::manage.special.edit').':'.$id, '', $psotData, $info);
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }

    public function delete($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id', 5);
        }
        $info = SpecialModel::getInfo($id, $this->module);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', 5);
        }
        SpecialModel::deleteSpecial($id);
        SpecialModel::setCache($this->module);
        SpecialModel::setCache('all');
        $this->addOperationLog(tw_lang('thinkwinds::manage.special.delete').':'.$id, '', [], $info);
        return $this->showMessage('thinkwinds::public.delete.success', 5); 
    }

    public function cache() 
    {
        SpecialModel::setCache($this->module);
        SpecialModel::setCache('all');
        $this->addOperationLog(tw_lang('thinkwinds::manage.special.cache'));
        return $this->showMessage('thinkwinds::public.successful', 5); 
    }

    public function updateSeo($param = 0, $title = '', $keywords = '', $description = '') 
    {
        if(config('websys.version')) 
        {
            return websys_updateSeo('area', 'custom', $param, $title, $keywords, $description);
        } 
        return false;
    }
}