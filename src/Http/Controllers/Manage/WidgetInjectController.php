<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\WidgetModel;
use Thinkwinds\Framework\Model\WidgetInjectModel;


class WidgetInjectController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($widget_name, Request $request)
    {
        $this->navs = [
            'return'=>['name'=>tw_lang('thinkwinds::public.go.back'), 'url'=>route('manage.widget.index')],
            'index'=>['name'=>tw_lang('thinkwinds::widget.inject'), 'url'=>route('manage.widget.inject.index', ['name'=>$widget_name])],
            'add'=>['name'=>tw_lang('thinkwinds::widget.add.inject'), 'url'=>route('manage.widget.inject.add', ['name'=>$widget_name]), 'title'=>tw_lang('thinkwinds::widget.add.inject'), 'class'=>'J_dialog']
        ];
        $widget = WidgetModel::where('name', $widget_name)->first();
        $list = WidgetInjectModel::where('widget_name', $widget_name)->get()->toArray();
        $view = [
            'widget_name'=>$widget_name,
            'list'=>$list,
            'info'=>$widget,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('thinkwinds::manage.widget.inject_index', $view);
    }

    public function add($widget_name, Request $request)
    {
        if(!$widget_name) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $widget = WidgetModel::where('name', $widget_name)->first();
        if(!$widget) 
        {
            return $this->showError('thinkwinds::widget.empty');
        }
        $view = [
            'widget_name'=>$widget_name
        ];
        return $this->loadTemplate('thinkwinds::manage.widget.inject_add', $view);
    }

    public function addSave($widget_name, Request $request)
    {
        $widget = WidgetModel::where('name', $widget_name)->first();
        if(!$widget) 
        {
            return $this->showError('thinkwinds::widget.empty');
        }
        $validator = Validator::make($request->all(), [
            'alias' => 'required',
            'files' => 'required',
            'class' => 'required',
            'fun' => 'required'
        ],[
            'alias.required'=>tw_lang('thinkwinds::widget.alias.empty'),
            'files.required'=>tw_lang('thinkwinds::widget.files.empty'),
            'class.required'=>tw_lang('thinkwinds::widget.class.empty'),
            'fun.required'=>tw_lang('thinkwinds::widget.fun.empty'),
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $widgetInject = WidgetInjectModel::where('widget_name', trim($widget_name))->where('alias', $request->get('alias'))->first();
        if($widgetInject) 
        {
            return $this->showError('thinkwinds::widget.inject.noone');
        }
        WidgetInjectModel::addInfo(trim($widget_name), trim($request->get('alias')), trim($request->get('files')), trim($request->get('class')), trim($request->get('fun')), trim($request->get('description')));

        $this->addOperationLog(tw_lang('thinkwinds::widget.add.inject').':'.trim($widget_name).trim($request->get('alias')), '', ['widget_name'=>trim($widget_name), 'alias'=>trim($request->get('alias')), 'files'=>trim($request->get('files')), 'description'=>trim($request->get('description')), 'class'=>trim($request->get('class')), 'fun'=>trim($request->get('fun'))], []);
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function edit($widget_name, $id)
    {
        if(!$widget_name || !$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $widget = WidgetModel::where('name', $widget_name)->first();
        if(!$widget) 
        {
            return $this->showError('thinkwinds::widget.empty');
        }
        $widgetInject = WidgetInjectModel::where('widget_name', $widget_name)->where('id', $id)->first();
        if(!$widgetInject) 
        {
            return $this->showError('thinkwinds::widget.no.inject');
        }
        $view = [
            'widget_name'=> $widget_name,
            'id'=> $id,
            'info'=> $widgetInject,
        ];
        return $this->loadTemplate('thinkwinds::manage.widget.inject_edit', $view);
    }

    public function editSave($widget_name, Request $request)
    {
        $id = $request->get('id');
        if(!$widget_name || !$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $widget = WidgetModel::where('name', $widget_name)->first();
        if(!$widget) 
        {
            return $this->showError('thinkwinds::widget.empty');
        }
        $widgetInject = WidgetInjectModel::where('widget_name', $widget_name)->where('id', $id)->first();
        if(!$widgetInject) 
        {
            return $this->showError('thinkwinds::widget.no.inject');
        }
        $validator = Validator::make($request->all(), [
            'alias' => 'required',
            'files' => 'required',
            'class' => 'required',
            'fun' => 'required'
        ],[
            'alias.required'=>tw_lang('thinkwinds::widget.alias.empty'),
            'files.required'=>tw_lang('thinkwinds::widget.files.empty'),
            'class.required'=>tw_lang('thinkwinds::widget.class.empty'),
            'fun.required'=>tw_lang('thinkwinds::widget.fun.empty'),
        ]);

        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $widgetInject = WidgetInjectModel::where('widget_name', trim($widget_name))->where('alias', $request->get('alias'))->first();
        if($widgetInject && $widgetInject['id'] != $id) 
        {
            return $this->showError('thinkwinds::widget.inject.noone');
        }

        WidgetInjectModel::editInfo($id, trim($widget_name), trim($request->get('alias')), trim($request->get('files')), trim($request->get('class')), trim($request->get('fun')), trim($request->get('description')));
        $this->addOperationLog(tw_lang('thinkwinds::widget.edit.inject').':'.$widget_name.trim($request->get('alias')), '', ['widget_name'=>trim($widget_name), 'alias'=>trim($request->get('alias')), 'files'=>trim($request->get('files')), 'description'=>trim($request->get('description')), 'class'=>trim($request->get('class')), 'fun'=>trim($request->get('fun'))], $widgetInject->toArray());
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }

    public function delete($widget_name, $id)
    {
        if(!$widget_name || !$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $widget = WidgetModel::where('name', $widget_name)->first();
        if(!$widget) 
        {
            return $this->showError('thinkwinds::widget.empty');
        }
        $widgetInject = WidgetInjectModel::where('widget_name', $widget_name)->where('id', $id)->first();
        if(!$widgetInject) 
        {
            return $this->showError('thinkwinds::widget.no.inject');
        }
        WidgetInjectModel::del('id', $id);
        $this->addOperationLog(tw_lang('thinkwinds::widget.delete.inject').':'.$widget_name.$widgetInject['alias'], '', [], $widgetInject->toArray());
        return $this->showMessage('thinkwinds::public.delete.success'); 
    }
}