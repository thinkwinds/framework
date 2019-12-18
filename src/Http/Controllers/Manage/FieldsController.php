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
use Thinkwinds\Framework\Libraries\ThinkwindsFields;

class FieldsController extends BasicController
{
    public $relatedid = 0;
    public $rname = 'form';
    public $formInfo = null;
    public $relatedtable = '';
    public $module = 'default';
    public $thinkwindsFields = null;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->rname = $request->get('rname');
        $this->relatedtable = $request->get('relatedtable');
        $this->relatedid = (int)$request->get('relatedid');
        $this->tw_data['rname'] = $this->rname;
        $this->tw_data['relatedid'] = $this->relatedid;
        $this->tw_data['relatedtable'] = $this->relatedtable;
        $this->thinkwindsFields = new ThinkwindsFields();
        if($this->rname == 'form') 
        {
            $this->formInfo = FormModel::getForm($this->relatedid);
            if($this->formInfo) 
            {
                $this->relatedtable = $this->formInfo['table'];
                $this->module = $this->formInfo['module'];
            }
        } else {
            $this->module = $this->rname;
        }
        $this->navs = [
            'index'=>['name'=>tw_lang('thinkwinds::manage.fields.manage'), 'url'=>route('manage.fields.index', [
                'rname' => $this->rname,
                'relatedid' => $this->relatedid,
                'relatedtable' => $this->relatedtable
            ])],
            'add'=>['name'=>tw_lang('thinkwinds::manage.fields.add'), 'url'=>route('manage.fields.add', [
                'rname' => $this->rname,
                'relatedid' => $this->relatedid,
                'relatedtable' => $this->relatedtable
            ])]
        ];
    }

    public function index(Request $request)
    {
        if($this->rname == 'form') 
        {
            if(!$this->formInfo) 
            {
                    return $this->showError('thinkwinds::manage.form.no.info');
            }
            $fields = FieldsModel::getFields($this->formInfo['table'], $this->formInfo['module']);
        } else {
            $fields = FieldsModel::getFields($this->relatedtable, $this->module);
        }
        $view = [
            'list'=>$fields,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('thinkwinds::manage.fields.index', $view);
    }

    public function save(Request $request)
    {
        $vieworder = $request->get('vieworder');
        foreach ($vieworder as $id => $value) 
        {
            FieldsModel::where('id', $id)->update(['vieworder'=>$value]);
        }
        FieldsModel::setCache($this->relatedtable);
        FieldsModel::setCache('all');
        $this->addOperationLog(tw_lang('thinkwinds::manage.fields.update.vieworder'), '', [], []);
        return $this->showMessage('thinkwinds::public.add.success', 5); 
    }

    public function add(Request $request)
    {
        $view = [
            'fieldTypes'=> $this->thinkwindsFields->type(),
            'navs'=>$this->getNavs('add')
        ];
        return $this->loadTemplate('thinkwinds::manage.fields.add', $view);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'fieldname' => 'required',
            'fieldtype' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.fields.name.empty'),
            'fieldname.required'=>tw_lang('thinkwinds::manage.fields.fieldname.empty'),
            'fieldtype.required'=>tw_lang('thinkwinds::manage.fields.type.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $ismain = $request->get('ismain');
        if($this->rname == 'form') 
        {
            if(!$this->formInfo) 
            {
                return $this->showError('thinkwinds::manage.form.no.info');
            }
            $ismain = 1;
        }
        if(!FieldsModel::hasFieldOrColumn([
            'relatedtable'=>$this->relatedtable,
            'module'=>$this->module,
            'fieldname'=>$request->get('fieldname')
        ])) 
        {
            return $this->showError('thinkwinds::manage.fields.one');
        }
        if (!$this->relatedtable) 
        {
            return $this->showError('thinkwinds::fields.relatedtable.error');
        }
        $setting = $request->get('setting');
        $setting['validate']['isedit'] = (int)tw_switch($request->all(), 'isedit');
        $setting['option']['isfrontshow'] = (int)tw_switch($request->all(), 'isfrontshow');
        $psotData = [
            'name'=>$request->get('name'),
            'fieldtype'=>$request->get('fieldtype'),
            'fieldname'=>$request->get('fieldname'),
            'vieworder'=>(int)$request->get('vieworder'),
            'ismshow'=>(int)tw_switch($request->all(), 'ismshow'),
            'issearch'=>(int)tw_switch($request->all(), 'issearch'),
            'disabled'=>(int)tw_switch($request->all(), 'disabled', true),
            'ismain'=>$ismain,
            'relatedtable'=>$this->relatedtable,
            'module'=>$this->module,
            'relatedid'=>$this->relatedid,
            'setting'=>$setting
        ];
        FieldsModel::addField($psotData);
        FieldsModel::setCache('all');
        FieldsModel::setCache($this->relatedtable);
        $this->addOperationLog(tw_lang('thinkwinds::manage.fields.add').':'.trim($request->get('name')), '', $psotData, []);
        return $this->showMessage('thinkwinds::public.add.success', '', 5); 
    }

    public function edit($id, Request $request)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = FieldsModel::getField($id);
        if(!$info) {
            return $this->showError('thinkwinds::public.no.data');
        }
        $this->navs['edit'] = ['name'=>tw_lang('thinkwinds::manage.fields.edit'), 'url'=>route('manage.fields.edit', [
                'id' => $id,
                'rname' => $this->rname,
                'relatedtable' => $this->relatedtable,
                'relatedid' => $this->relatedid
            ])];
        $view = [
            'id'=> $id,
            'info'=> $info,
            'fieldTypes'=> $this->thinkwindsFields->type(),
            'navs'=>$this->getNavs('edit')
        ];
        return $this->loadTemplate('thinkwinds::manage.fields.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = FieldsModel::getField($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.fields.name.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        if($this->rname == 'form') 
        {
            $formInfo = FormModel::getForm($this->relatedid);
            if(!$formInfo) 
            {
                return $this->showError('thinkwinds::manage.form.no.info');
            }
        }
        $setting = $request->get('setting');
        $setting['validate']['isedit'] = (int)tw_switch($request->all(), 'isedit');
        $setting['option']['isfrontshow'] = (int)tw_switch($request->all(), 'isfrontshow');
        $psotData = [
            'name'=>$request->get('name'),
            'vieworder'=>(int)$request->get('vieworder'),
            'ismshow'=>(int)tw_switch($request->all(), 'ismshow'),
            'issearch'=>(int)tw_switch($request->all(), 'issearch'),
            'disabled'=>(int)tw_switch($request->all(), 'disabled', true),
            'setting'=>tw_array2str($setting)
        ];
        FieldsModel::where('id', $id)->update($psotData);
        FieldsModel::setCache('all');
        FieldsModel::setCache($this->relatedtable);
        $this->addOperationLog(tw_lang('thinkwinds::manage.fields.edit').':'.$id, '', [
            'name'=>$request->get('name'),
            'vieworder'=>$request->get('vieworder'),
            'ismshow'=>(int)tw_switch($request->all(), 'ismshow'),
            'issearch'=>(int)tw_switch($request->all(), 'issearch'),
            'disabled'=>(int)tw_switch($request->all(), 'disabled', true)
        ], []);
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }

    public function delete($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id', 5);
        }
        $info = FieldsModel::getField($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', 5);
        }
        FieldsModel::deleteField($id);
        FieldsModel::setCache('all');
        FieldsModel::setCache($info['relatedtable']);
        $this->addOperationLog(tw_lang('thinkwinds::manage.fields.delete').':'.$id, '', [], $info);
        return $this->showMessage('thinkwinds::public.delete.success', 5); 
    }

    public function cache() 
    {
        FieldsModel::setCache('all');
        $this->addOperationLog(tw_lang('thinkwinds::manage.fields.cache'));
        return $this->showMessage('thinkwinds::public.successful', 5); 
    }
}