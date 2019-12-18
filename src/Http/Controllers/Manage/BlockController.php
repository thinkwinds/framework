<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\BlockModel;
use Thinkwinds\Framework\Model\AttachmentModel;

class BlockController extends BasicController
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
            'index'=>['name'=>tw_lang('thinkwinds::manage.block'), 'url'=>route('manage.block.index', ['module'=>$this->module])],
            'add'=>['name'=>tw_lang('thinkwinds::public.add'), 'url'=>route('manage.block.add', ['module'=>$this->module]), 'class'=>'J_dialog', 'title'=>tw_lang('thinkwinds::manage.special.add')],
            'cache'=>['name'=>tw_lang('thinkwinds::public.update.cache'), 'class'=>'J_ajax_refresh', 'url'=>route('manage.special.cache', ['module'=>$this->module])]
        ];
        $this->tw_data['module'] = $this->module;
    }

    public function index(Request $request)
    {
        $listQuery = BlockModel::where('id', '>', 0);
        $args = [];
        $list = $listQuery->orderby('times', 'desc')->paginate($this->paginate);
        $view = [
            'list'=>$list,
            'args'=>$args,
            'navs'=>$this->getNavs('index')
        ];
    	return $this->loadTemplate('thinkwinds::manage.block.index', $view);
    }

    public function add(Request $request)
    {
        return $this->loadTemplate('thinkwinds::manage.block.add', [
        ]);
    }

    public function addSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required'
        ],[
            'name.required'=>tw_lang('thinkwinds::manage.block.name.empty'),
            'type.required'=>tw_lang('thinkwinds::manage.type.empty')
        ]);
        if ($validator->fails()) 
        {
            return $this->showError($validator->errors(), 2);
        }
        $content = $request->get('content');
        $type = $request->get('type');
        $image = $request->get('image');
        $link = $request->get('link');
        $contents = [
            'image'=>$image ? $image['aid'] : 0,
            'link'=>$link
        ];
        if($type == 'image') 
        {
            $content = serialize($contents);
        }
        if($type == 'html') 
        {
            $content = $request->get('contentv');
        }
        $psotData = [
            'name'=>$request->get('name'),
            'type'=>$type,
            'content'=>$content,
            'isopen'=>(int)tw_switch($request->all(), 'isopen'),
            'times'=>tw_time()
        ];
        $id = BlockModel::insertGetId($psotData);
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.error');
        }
        if($contents['image']) {
            AttachmentModel::updateAttach($contents['image'], $id);
        }
        BlockModel::setCache($id);
        $this->addOperationLog(tw_lang('thinkwinds::public.add','thinkwinds::public.block').':'.trim($request->get('name')), '', $psotData, []);
        return $this->showMessage('thinkwinds::public.add.success'); 
    }

    public function edit($id, Request $request)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = BlockModel::getInfo($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $view = [
            'id'=> $id,
            'info'=> $info,
        ];
        return $this->loadTemplate('thinkwinds::manage.block.edit', $view);
    }

    public function editSave(Request $request)
    {
        $id = $request->get('id');
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = BlockModel::getInfo($id);
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
        $content = $request->get('content');
        $type = $request->get('type');
        $image = $request->get('image');
        $link = $request->get('link');
        $contents = [
            'image'=>isset($image['aid']) && $image['aid'] ? $image['aid'] : 0,
            'link'=>$link
        ];
        if($type == 'image') 
        {
            $content = serialize($contents);
        }
        if($type == 'html') 
        {
            $content = $request->get('contentv');
        }
        $psotData = [
            'name'=>$request->get('name'),
            'type'=>$type,
            'content'=>$content,
            'isopen'=>(int)tw_switch($request->all(), 'isopen'),
            'times'=>tw_time()
        ];
        BlockModel::where('id', $id)->update($psotData);
        if($contents['image']) 
        {
            AttachmentModel::updateAttach($contents['image'], $id);
        }
        BlockModel::setCache($id);
        $this->addOperationLog(tw_lang('thinkwinds::manage.edit').':'.$id, '', $psotData, $info);
        return $this->showMessage('thinkwinds::public.edit.success'); 
    }

    public function delete($id, Request $request)
    {
        if(!$id) 
        {
            return $this->showError('thinkwinds::public.no.id', 5);
        }
        $info = BlockModel::getCache($id);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', 5);
        }
        BlockModel::deleteBlock($id);
        AttachmentModel::deleteAttachByAppId('block', $info['id']);
        $this->addOperationLog(tw_lang('thinkwinds::public.delete').':'.$id, '', [], $info);
        return $this->showMessage('thinkwinds::public.delete.success', 5); 
    }

    public function cache() 
    {
        BlockModel::setCache(0);
        $this->addOperationLog(tw_lang('thinkwinds::public.cache'));
        return $this->showMessage('thinkwinds::public.successful', 5); 
    }
}