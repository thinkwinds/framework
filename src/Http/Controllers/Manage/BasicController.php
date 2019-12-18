<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Thinkwinds\Framework\Model\ManageOperationLogModel;

class BasicController extends Controller
{
	public $navs = [];                    //内页导航
    public $paginate = 20;
    public $tw_data = [];                //传递给模版的共享内容
    protected $lav_route = '';                 //路由名称

    public function __construct()
    {
        tw_checkInstall();
        $this->lav_route = Route::currentRouteName();
        $this->addMessage(trans('thinkwinds::manage.title'), 'seo_title');
    }
    
    /**
     * 添加显示内容 **
     *
     * @param  $message 可以是array，也可以使string
     * @param string $str 键名
     * @param return null
     */
    protected function addMessage($message = null, $str = '')
    {
        if(!$str) return;
        $this->tw_data[$str] = $message;
    }

    /**
     * 加载模版
     *
     * @param string $tpl
     * @param array $data
     * @return template
     */

    public function loadTemplate($tpl, $data = [], $tw_data = true)
    {
        $tw_data && $data = $data + $this->tw_data;
        if(substr_count($tpl,'::') ) 
        {
            return view($tpl, $data);
        }
        return view('thinkwinds::manage.'.$tpl, $data);
    }

    public function getNavs($current = '', $ibutton = false)
    {
    	if(!$this->navs) return ;
    	$html = '<div class="tnav" style="border:0px;background: initial;">';
        if(!$ibutton){
            $html = '<div class="tnav">';
            if(isset($this->navs['return'])) {
                if(!preg_match('|^http://|', $this->navs['return']['url']) && !preg_match('|^https://|', $this->navs['return']['url'])) {
                   $this->navs['return']['url'] = route($this->navs['return']['url']);
                }
                $html .= '<div class="return"><a href="'.$this->navs['return']['url'].'"><i class="hstui-icon hstui-icon-undo1"></i>'.$this->navs['return']['name'].'</a></div>';
            }
            $html .= '<ul class="cc">';
        }
		foreach ($this->navs as $key=>$nav) 
        {
            if($key != 'return') 
            {
                $nav['current'] = $key == $current ? 'current' : '';
                if(!preg_match('|^http://|', $nav['url']) && !preg_match('|^https://|', $nav['url'])) 
                {
                   $nav['url'] = route($nav['url']);
                }
                $nav['class'] = isset($nav['class']) ? $nav['class'] : '';
                $nav['id'] = isset($nav['id']) ? ' class="nav_'.$nav['id'].'" ' : '';
                $nav['title'] = isset($nav['title']) ? $nav['title'] : '';
                if(!$ibutton)
                {
                    $html .='<li class="'.$nav['current'].'"><a href="'.$nav['url'].'" title="'.$nav['title'].'" class="'.$nav['class'].'" '.$nav['id'].'>'.$nav['name'].'</a></li>';
                } else {
                    $html .='<a href="'.$nav['url'].'" title="'.$nav['title'].'"  class="hstui-button hstui-button-xs hstui-button-primary hstui-margin-right-xs '.$nav['class'].'" '.$nav['id'].'>'.$nav['name'].'</a>';
                }
            }
		}
        if(!$ibutton)
        {
            $html .= '</ul>';
        }
    	$html .='</div>';
    	return $html;
    }

    public function addOperationLog($remark = '', $change = '', $newdata = [], $olddata = [])
    {
        if(tw_config('safe', 'operation')) return ;
        return ManageOperationLogModel::addLog(tw_manager(), $remark, $change, $newdata, $olddata);
    }

    public function showError($message = '', $routeName = '', $with = 0)
    {
        if(in_array($routeName, [1, 2, 3, 5])) 
        {
            $with = $routeName;
            $routeName = '';
        }
        return $this->showMessage($message, $routeName, $with, 'fail');
    }

    public function showMessage($message = '', $routeName = '', $with = 0, $state='success') 
    {
        if(in_array($routeName, [1, 2, 3, 5])) 
        {
            $with = $routeName;
            $routeName = '';
        }
        if($with != 2) 
        {
            $message = tw_lang($message);
        }
        if($routeName && !preg_match('|^http://|', $routeName) && !$with) 
        {
            $routeName = $routeName ? route($routeName) : '';
        }
        $viewData = [
            'message'=>$message,
            'referer'=>$routeName,
            'state' => $state,
            'with' => $with
        ];
        $viewDatas = isset($this->tw_data) ? $this->tw_data : [];
        $viewData = array_merge($viewData, $viewDatas);
        if(substr_count($_SERVER['HTTP_ACCEPT'], 'application/json')) 
        {
            if($routeName && !preg_match('|^http://|', $routeName)) 
            {
                $routeName = $routeName ? route($routeName) : '';
            }
            $viewData['referer'] = $routeName;
            return response()->json($viewData);
        }
        if($with == 1) 
        {
            if(preg_match('|^http://|', $routeName)) 
            {
                return redirect($routeName)->with($viewData);
            }
            return redirect()->route($routeName)->with($viewData);
        } else if($with == 2) {
            if(preg_match('|^http://|', $routeName)) 
            {
                return redirect($routeName)
                    ->withErrors($message)
                    ->withInput();
            }
            return redirect()->route($routeName)
                ->withErrors($message)
                ->withInput();
        } else if($with == 5) {
            return back()->with($viewData);
        }
        return $this->loadTemplate('common.tips', $viewData);
    }
}
