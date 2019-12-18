<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\FormModel;
use Thinkwinds\Framework\Model\FieldsModel;
use Thinkwinds\Framework\Model\FormContentModel;
use Thinkwinds\Framework\Libraries\ThinkwindsFields;

class FormController extends BasicController
{
    public $module = 'default';
    public $relatedid = 0;
    public function __construct(Request $request)
    {
        parent::__construct();
        $module = $request->get('module');
        $relatedid = (int)$request->get('relatedid');
        if($module) 
        {
            $this->module = $module;
        }
        if($relatedid) 
        {
            $this->relatedid = $relatedid;
        }
        $this->navs = [
            'index'=>['name'=>tw_lang('thinkwinds::manage.form'), 'url'=>route('manage.form.index', ['module'=>$this->module, 'relatedid'=>$this->relatedid])],
            'add'=>['name'=>tw_lang('thinkwinds::manage.form.add'), 'url'=>route('manage.form.add', ['module'=>$this->module, 'relatedid'=>$this->relatedid]), 'class'=>'J_dialog', 'title'=>tw_lang('thinkwinds::manage.form.add')],
            'cache'=>['name'=>tw_lang('thinkwinds::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manage.form.cache', ['module'=>$this->module, 'relatedid'=>$this->relatedid])]
        ];
        $this->tw_data['module'] = $this->module;
        $this->tw_data['relatedid'] = $this->relatedid;
    }

    public function index(Request $request)
    {
        $data = FormModel::getForms($this->module);
        $view = [
            'list'=>$data['list'],
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('thinkwinds::manage.form.index', $view);
    }

    public function add(Request $request)
    {
        return $this->loadTemplate('thinkwinds::manage.form.add');
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'table' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.form.name.empty'),
            'table.required'=>tw_lang('thinkwinds::manage.form.table.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $form = FormModel::hasFormOrTable('form_'.$request->get('table'), $this->module, $this->relatedid);
        if(!$form) 
        {
            return $this->showError('thinkwinds::manage.form.one');
        }
        $setting = [
            'mobile'=>$request->get('mobile'),
            'email'=>$request->get('email'),
            'email_content'=>$request->get('emailcontent')
        ];
        $psotData = [
            'name'=>$request->get('name'),
            'table'=>'form_'.$request->get('table'),
            'module'=>$this->module,
            'relatedid'=>$this->relatedid,
            'setting'=>$setting
        ];
        FormModel::addForm($psotData);
        FormModel::setCache($this->module);
        FormModel::setCache('all');
        $this->addOperationLog(tw_lang('thinkwinds::manage.form.add').':'.trim($request->get('name')), '', $psotData, [], []);
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function edit($id, Request $request)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = FormModel::getForm($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $view = [
            'id'=> $id,
            'info'=> $info,
        ];
        return $this->loadTemplate('thinkwinds::manage.form.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = FormModel::getForm($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.form.name.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $setting = [
            'mobile'=>$request->get('mobile'),
            'email'=>$request->get('email'),
            'email_content'=>$request->get('emailcontent')
        ];
        $psotData = [
            'name'=>$request->get('name'),
            'setting'=>tw_array2str($setting)
        ];
        FormModel::where('id', $id)->update($psotData);
        FormModel::setCache($this->module);
        FormModel::setCache('all');
        $this->addOperationLog(tw_lang('thinkwinds::manage.form.edit').':'.$id, '', [
            'name'=>$request->get('name'),
            'mobile'=>$request->get('mobile'),
            'email'=>$request->get('email'),
            'email_content'=>$request->get('emailcontent')
        ], []);
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }

    public function delete($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id', 5);
        }
        $info = FormModel::getForm($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', 5);
        }
        FormModel::deleteForm(trim($info['table']), $info['module'], $info['relatedid']);
        FormModel::setCache($this->module);
        FormModel::setCache('all');
        $this->addOperationLog(tw_lang('thinkwinds::manage.form.delete').':'.$id, '', array(), $info);
        return $this->showMessage('thinkwinds::public.delete.success', 5); 
    }

    public function cache() 
    {
        FormModel::setCache($this->module);
        FormModel::setCache('all');
        $this->addOperationLog(tw_lang('thinkwinds::manage.form.cache'));
        return $this->showMessage('thinkwinds::public.successful', 5); 
    }

    // 内容管理
    public function content($formid, Request $request) 
    {
        if(!$formid) 
        {
            return $this->showError('thinkwinds::public.no.id', '', 5);
        }
        $info = FormModel::getForm($formid);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', '', 5);
        }
        $commonFormContentModel = new FormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $type = $request->input('type');
        $uid = $request->input('uid');
        $stime = $request->input('stime');
        $etime = $request->input('etime');
        $listQuery = $commonFormContentModel->where('id', '>', 0);
        $args = ['status'=>0, 'type'=>''];
        if($uid) 
        {
            $args['uid'] = $uid;
            $listQuery->where('created_uid', $uid);
        }
        if($stime) 
        {
            $args['stime'] = $stime;
            $stime = tw_str2time($stime);
            $listQuery->where('created_time', '>=', $stime);
        }
        if($etime) 
        {
            $args['etime'] = $etime;
            $etime = tw_str2time($etime);
            $listQuery->where('created_time', '<=', $etime);
        }
        $list = $listQuery->orderby('created_time', 'desc')->paginate($this->paginate);
        $showFields = FieldsModel::getManageContentListShowFields($info['table']);
        $fields = FieldsModel::getFields($info['table'], true);
        $thinkwindsFields = new ThinkwindsFields();
        foreach ($list as $key => $value) {
            $list[$key] = $thinkwindsFields->field_format_value($fields, $value->toArray());
        }
        $this->navs = [];
        $this->navs['content'] = ['name'=>$info['name'].tw_lang('thinkwinds::manage.form.content'), 'url'=>route('manage.form.content', ['formid'=>$formid])];
        $this->navs['contentAdd'] = ['name'=>tw_lang('thinkwinds::public.add'), 'url'=>route('manage.form.contentAdd', ['formid'=>$formid])];
        $view = [
            'formid'=> $formid,
            'info'=> $info,
            'list'=>$list,
            'args'=>$args,
            'showFields'=>$showFields,
            'navs'=>$this->getNavs('content')
        ];
        return $this->loadTemplate('thinkwinds::manage.form.content', $view);
    }

    public function contentAdd($formid, Request $request) 
    {
        if(!$formid) 
        {
            return $this->showError('thinkwinds::public.no.id', '', 5);
        }
        $info = FormModel::getForm($formid);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', '', 5);
        }
        $thinkwindsFields = new ThinkwindsFields();
        $thinkwindsFields->isadmin = true;
        $fields = FieldsModel::getFields($info['table']);
        $inputHtml = $thinkwindsFields->input_html($fields);
        $this->navs = [];
        $this->navs['content'] = ['name'=>$info['name'].tw_lang('thinkwinds::manage.form.content'), 'url'=>route('manage.form.content', ['formid'=>$formid])];
        $this->navs['contentAdd'] = ['name'=>$info['name'].tw_lang('thinkwinds::public.add'), 'url'=>route('manage.form.contentAdd', ['formid'=>$formid])];
        $view = [
            'id'=> $formid,
            'info'=> $info,
            'inputHtml'=>$inputHtml,
            'navs'=>$this->getNavs('contentAdd')
        ];
        return $this->loadTemplate('thinkwinds::manage.form.content_add', $view);
    }

    public function contentAddSave($formid, Request $request) 
    {
        if(!$formid) {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = FormModel::getForm($formid);
        if(!$info) {
            return $this->showError('thinkwinds::public.no.data');
        }
        $thinkwindsFields = new ThinkwindsFields();
        $thinkwindsFields->isadmin = true;
        $fields = FieldsModel::getFields($info['table']);
        $result = $thinkwindsFields->validate_filter($request, $fields);
        if($result['status'] == 'error') {
            return $this->showError($result['error'], 2);
        }
        $psotData = $result['data'][$info['table']];
        $psotData['created_time'] = tw_time();
        $psotData['created_ip'] = tw_ip();
        $psotData['created_port'] = tw_port();
        $psotData['vieworder'] = 0;
        $commonFormContentModel = new FormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $id = $commonFormContentModel->insertGetId($psotData);
        if($id) {
            $thinkwindsFields->saveAttach($id, $request, $fields);
        }
        return $this->showMessage('thinkwinds::public.add.success', route('manage.form.content', ['formid'=>$formid])); 
    }

    public function contentEdit($formid, $id, Request $request) 
    {
        if(!$formid || !$id) {
            return $this->showError('thinkwinds::public.no.id', '', 5);
        }
        $info = FormModel::getForm($formid);
        if(!$info) {
            return $this->showError('thinkwinds::public.no.data', '', 5);
        }
        $commonFormContentModel = new FormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $infos = $commonFormContentModel->where('id', $id)->first();
        if(!$infos) {
            return $this->showError('thinkwinds::public.no.data', '', 5);
        }

        $thinkwindsFields = new ThinkwindsFields();
        $thinkwindsFields->isadmin = true;
        $fields = FieldsModel::getFields($info['table']);
        $inputHtml = $thinkwindsFields->input_html($fields, $infos, false, 'id');

        $this->navs = [];
        $this->navs['content'] = ['name'=>$info['name'].tw_lang('thinkwinds::manage.form.content'), 'url'=>route('manage.form.content', ['formid'=>$formid])];
        $this->navs['contentAdd'] = ['name'=>$info['name'].tw_lang('thinkwinds::public.add'), 'url'=>route('manage.form.contentAdd', ['formid'=>$formid])];
        $this->navs['contentEdit'] = ['name'=>tw_lang('thinkwinds::public.edit'), 'url'=>route('manage.form.contentEdit', ['formid'=>$formid, 'id'=>$id])];
        $view = [
            'id'=> $id,
            'formid'=> $formid,
            'info'=> $info,
            'infos'=>$infos,
            'inputHtml'=>$inputHtml,
            'navs'=>$this->getNavs('contentEdit')
        ];
        return $this->loadTemplate('thinkwinds::manage.form.content_edit', $view);
    }

    public function contentEditSave($formid, Request $request) 
    {
        $id = $request->get('id');
        if(!$formid || !$id) {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = FormModel::getForm($formid);
        if(!$info) {
            return $this->showError('thinkwinds::public.no.data');
        }
        $commonFormContentModel = new FormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $fields = FieldsModel::getFields($info['table']);
        $infos = $commonFormContentModel->where('id', $id)->first();
        if(!$infos) {
            return $this->showError('thinkwinds::public.no.data', '', 5);
        }

        $thinkwindsFields = new ThinkwindsFields();
        $thinkwindsFields->isadmin = true;
        $result = $thinkwindsFields->validate_filter($request, $fields, $infos);
        if($result['status'] == 'error') {
            return $this->showError($result['error'], 2);
        }
        $psotData = $result['data'][$info['table']];
        $psotData['vieworder'] = 0;
        $commonFormContentModel->where('id', $id)->update($psotData);
        if($id) {
            $thinkwindsFields->saveAttach($id, $request, $fields);
        }
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }

    public function contentDelete($formid, $id, Request $request)
    {
        if(!$formid || !$id) {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = FormModel::getForm($formid);
        if(!$info) {
            return $this->showError('thinkwinds::public.no.data');
        }
        $commonFormContentModel = new FormContentModel();
        $commonFormContentModel->setTable($info['table']);
        $commonFormContentModel->where('id', $id)->delete();
        return $this->showMessage('thinkwinds::public.delete.success', 5); 
    }

}

