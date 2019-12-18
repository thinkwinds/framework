<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Thinkwinds\Framework\Model\WidgetModel;

use Validator;
use Illuminate\Http\Request;

class WidgetController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
        $this->navs = [
            'index'=>['name'=>tw_lang('thinkwinds::public.widget'), 'url'=>'manage.widget.index'],
            'add'=>['name'=>tw_lang('thinkwinds::widget.add'), 'url'=>'manage.widget.add', 'class'=>'J_dialog', 'title'=>tw_lang('thinkwinds::widget.add')],
            'cache'=>['name'=>tw_lang('thinkwinds::public.update.cache'), 'url'=>'manage.widget.cache']
        ];
    }

    public function index(Request $request)
    {
        $list = WidgetModel::getAll(1);
        $view = [
            'list'=>$list,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('thinkwinds::manage.widget.index', $view);
    }

    public function add(Request $request)
    {
        return $this->loadTemplate('thinkwinds::manage.widget.add');
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'document' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::public.name.empty'),
            'document.required'=>tw_lang('thinkwinds::widget.document.empty')
        ]);

        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $widget = WidgetModel::where('name', trim($request->get('name')))->first();
        if($widget) 
        {
            return $this->showError('thinkwinds::name.noone');
        }
        WidgetModel::addInfo(trim($request->get('name')), trim($request->get('description')), trim($request->get('document')));
        $this->addOperationLog(tw_lang('thinkwinds::widget.add').':'.trim($request->get('name')), '', ['name'=>trim($request->get('name')), 'description'=>trim($request->get('description')), 'document'=>trim($request->get('document'))], []);
        WidgetModel::setCache();
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function edit($name)
    {
        if(!$name) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $widget = WidgetModel::where('name', $name)->first();
        if(!$widget) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $view = [
            'name'=> $name,
            'info'=> $widget
        ];
        return $this->loadTemplate('thinkwinds::manage.widget.edit', $view);
    }

    public function editSave(Request $request)
    {
        $name = $request->get('name');
        if(!$name) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $widget = WidgetModel::where('name', $name)->first();
        if(!$widget) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'document' => 'required'
        ],[
            'document.required'=>tw_lang('thinkwinds::widget.document.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        WidgetModel::editInfo(trim($request->get('name')), trim($request->get('description')), trim($request->get('document')));
        $this->addOperationLog(tw_lang('thinkwinds::widget.edit').':'.$widget['name'], '', ['name'=>trim($request->get('name')), 'description'=>trim($request->get('description')), 'document'=>trim($request->get('document'))], $widget->toArray());
        WidgetModel::setCache();
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }

    public function delete($name)
    {
        if(!$name) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $widget = WidgetModel::where('name', $name)->first();
        if(!$widget) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        WidgetModel::del(trim($name));
        $this->addOperationLog(tw_lang('thinkwinds::widget.delete').':'.$name, '', [], $widget->toArray());
        WidgetModel::setCache();
        return $this->showMessage('thinkwinds::public.delete.success'); 
    }

    public function cache() 
    {
        WidgetModel::setCache();
        $this->addOperationLog(tw_lang('thinkwinds::widget.cache'));
        return $this->showMessage('thinkwinds::public.successful', 'manage.widget.index', 1); 
    }
}