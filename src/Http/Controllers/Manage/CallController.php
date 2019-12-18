<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\CallBlockModel;
use Thinkwinds\Framework\Libraries\ThinkwindsCall;

class CallController extends BasicController
{

    public function __construct(Request $request)
    {
        parent::__construct();
    }

    public function block(Request $request)
    {
        $this->navs = [
            'block'=>['name'=>tw_lang('thinkwinds::manage.call.block'), 'url'=>route('manage.call.block')],
            'blockAdd'=>['name'=>tw_lang('thinkwinds::manage.call.block.add'), 'url'=>route('manage.call.block.add'), 'class'=>'', 'title'=>tw_lang('thinkwinds::manage.special.add')],
            'cache'=>['name'=>tw_lang('thinkwinds::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manage.special.cache')]
        ];
        $thinkwindsCall = new ThinkwindsCall();
        $listQuery = CallBlockModel::where('id', '>', 0);
        $list = $listQuery->orderby('times', 'desc')->paginate($this->paginate);
        $view = [
            'list'=>$list,
            'module'=>$thinkwindsCall->getCallModule(),
            'type'=>$thinkwindsCall->getCallType(),
            'navs'=>$this->getNavs('block')
        ];
    	return $this->loadTemplate('thinkwinds::manage.call.block', $view);
    }

    public function blockAdd(Request $request)
    {
        $this->navs = [
            'block'=>['name'=>tw_lang('thinkwinds::manage.call.block'), 'url'=>route('manage.call.block')],
            'blockAdd'=>['name'=>tw_lang('thinkwinds::manage.call.block.add'), 'url'=>route('manage.call.block.add'), 'class'=>'', 'title'=>tw_lang('thinkwinds::manage.special.add')],
            'cache'=>['name'=>tw_lang('thinkwinds::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manage.special.cache')]
        ];
        $step = (int)$request->get('step');
        $type = $request->get('type');
        $thinkwindsCall = new ThinkwindsCall();
        if($step == 2)
        {
            $validator = Validator::make($request->all(), [
                'type' => 'required'
            ],[
                'type.required'=>tw_lang('thinkwinds::manage.call.block.add.error.001')
            ]);
            if ($validator->fails()) 
            {
                return $this->showError($validator->errors(), 'manage.call.module.add', 2);
            }
            $typeInfo = $thinkwindsCall->getCallType($type);
            if (!$typeInfo) 
            {
                return $this->showError('thinkwinds::manage.call.type.no', 'manage.call.module.add', 2);
            }
            $callTypeInfo = $thinkwindsCall->get($typeInfo['module'], $type);
            if (!$callTypeInfo) 
            {
                return $this->showError('thinkwinds::manage.call.type.no', 'manage.call.module.add', 2);
            }
            $decorator = $callTypeInfo->decorateAddConfigures();
            $upsetting['cycle'] = 15;
            return $this->loadTemplate('thinkwinds::manage.call.block_add2', [
                'navs'=>$this->getNavs('blockAdd'),
                'type'=>$type,
                'decorator'=>$decorator,
                'configure'=>$callTypeInfo->getConfigure(),
                'callTypeInfo'=>$callTypeInfo,
                'vConfigures'=>[],
                'upsetting'=>$upsetting
            ]);
        }
        $types = $thinkwindsCall->getCallType();
        return $this->loadTemplate('thinkwinds::manage.call.block_add', [
            'types'=>$types,
            'navs'=>$this->getNavs('blockAdd')
        ]);
    }

    public function blockAddSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.call.block.name.empty'),
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $name = $request->get('name');
        $type = $request->get('type');
        $configures = $request->get('configures');
        $upsetting = $request->get('upsetting');
        $thinkwindsCall = new ThinkwindsCall();
        $typeInfo = $thinkwindsCall->getCallType($type);
        if (!$typeInfo) 
        {
            return $this->showError('thinkwinds::manage.call.type.no', 'manage.call.block.add', 2);
        }
        $callTypeInfo = $thinkwindsCall->get($typeInfo['module'], $type);
        if (!$callTypeInfo)
        {
            return $this->showError('thinkwinds::manage.call.type.no', 'manage.call.block.add', 2);
        }
        $configures = $callTypeInfo->decorateSaveConfigures($configures);
        $psotData = [
            'name'=>$request->get('name'),
            'type'=>$type,
            'module'=>$typeInfo['module'],
            'configures'=>serialize($configures),
            'upsetting'=>serialize($upsetting),
            'isopen'=>1,
            'times'=>tw_time()
        ];
        $id = CallBlockModel::insertGetId($psotData);
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.error');
        }
        $this->addOperationLog(tw_lang('thinkwinds::manage.call.block.add').':'.trim($request->get('name')), '', $psotData, []);
        return $this->showMessage('thinkwinds::public.add.success', 'manage.call.block'); 
    }

    public function blockEdit($id, Request $request)
    {
        if(!$id)
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = CallBlockModel::getInfo($id);
        if(!$info)
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $thinkwindsCall = new ThinkwindsCall();
        $typeInfo = $thinkwindsCall->getCallType($info['type']);
        if (!$typeInfo)
        {
            return $this->showError('thinkwinds::manage.call.type.no', 'manage.call.module.add', 2);
        }
        $callTypeInfo = $thinkwindsCall->get($typeInfo['module'], $info['type']);
        if (!$callTypeInfo)
        {
            return $this->showError('thinkwinds::manage.call.type.no', 'manage.call.module.add', 2);
        }
        $this->navs = [
            'blockData'=>['name'=>tw_lang('thinkwinds::manage.call.block.data'), 'url'=>route('manage.call.block.data', ['id'=>$id])],
            'blockEdit'=>['name'=>tw_lang('thinkwinds::manage.call.block.edit'), 'url'=>route('manage.call.block.edit', ['id'=>$id])]
        ];
        $decorator = $callTypeInfo->decorateEditConfigures($info);
        return $this->loadTemplate('thinkwinds::manage.call.block_edit', [
            'navs'=>$this->getNavs('blockEdit'),
            'id'=>$id,
            'info'=>$info,
            'decorator'=>$decorator,
            'configure'=>$callTypeInfo->getConfigure(),
            'callTypeInfo'=>$callTypeInfo,
            'vConfigures'=>$info['configures'],
            'upsetting'=>$info['upsetting']
        ]);
    }

    public function blockEditSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = CallBlockModel::getInfo($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.call.block.name.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $name = $request->get('name');
        $type = $request->get('type');
        $module = $request->get('module');
        $configures = $request->get('configures');
        $upsetting = $request->get('upsetting');
        $thinkwindsCall = new ThinkwindsCall();
        $typeInfo = $thinkwindsCall->getCallType($type);
        if (!$typeInfo) 
        {
            return $this->showError('thinkwinds::manage.call.type.no', 'manage.call.module.add', 2);
        }
        $callTypeInfo = $thinkwindsCall->get($typeInfo['module'], $type);
        if (!$callTypeInfo)
        {
            return $this->showError('thinkwinds::manage.call.type.no', 'manage.call.module.add', 2);
        }
        $configures = $callTypeInfo->decorateSaveConfigures($configures);
        $psotData = [
            'name'=>$request->get('name'),
            'type'=>$type,
            'module'=>$typeInfo['module'],
            'configures'=>serialize($configures),
            'upsetting'=>serialize($upsetting),
            'isopen'=>1
        ];
        CallBlockModel::where('id', $id)->update($psotData);
        $this->addOperationLog(tw_lang('thinkwinds::manage.edit').':'.$id, '', $psotData, $info);
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }

    public function delete($id, Request $request)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id', 5);
        }
        $info = CallBlockModel::getInfo($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', 5);
        }
        CallBlockModel::where('id', $id)->delete();
        $this->addOperationLog(tw_lang('thinkwinds::public.delete').':'.$id, '', [], $info);
        return $this->showMessage('thinkwinds::public.delete.success', 5); 
    }

    public function blockData($id)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = CallBlockModel::getInfo($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $this->navs = [
            'blockData'=>['name'=>tw_lang('thinkwinds::manage.call.block.data'), 'url'=>route('manage.call.block.data', ['id'=>$id])],
            'blockEdit'=>['name'=>tw_lang('thinkwinds::manage.call.block.edit'), 'url'=>route('manage.call.block.edit', ['id'=>$id])]
        ];
        $view = [
            'info'=>$info,
            'navs'=>$this->getNavs('blockData')
        ];
        return $this->loadTemplate('thinkwinds::manage.call.block_data', $view);
    }
}