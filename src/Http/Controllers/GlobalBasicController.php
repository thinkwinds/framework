<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class GlobalBasicController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected   $_route = '';
    public      $tw_data = [];
    public      $tw_client = [
        'mobile'=>false,
        'app'=>false,
        'wxapp'=>false
    ];

    public function __construct()
    {
        $this->_route = Route::currentRouteName();
        $this->tw_client['mobile'] = tw_is_mobile();
    }

    //================================================信息显示区==========================================================//
    
    /**
     * 添加显示内容 **
     *
     * @param  $message 可以是array，也可以使string
     * @param string $str 键名
     * @param return null
     */
    protected function addMessage($message = array(), $str = '')
    {
        if(!$str) return;
        $this->tw_data[$str] = $message;
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
        $viewDatas = isset($this->tw_data) ? $this->tw_data : [];
        $viewData = [
            'message'=>$message,
            'referer'=>$routeName,
            'state' => $state,
            'with' => $with
        ];
        $viewData = array_merge($viewData, $viewDatas);
        if(substr_count($_SERVER['HTTP_ACCEPT'], 'application/json')) 
        {
            if($routeName && !preg_match('|^http://|', $routeName) && !preg_match('|^https://|', $routeName)) 
            {
                $routeName = $routeName ? route($routeName) : '';
            }
            $viewData['referer'] = $routeName;
            return response()->json($viewData);
        }
        if($with == 1) 
        {                                            //跳转指定链接提示
            if(preg_match('|^http://|', $routeName) || preg_match('|^https://|', $routeName)) 
            {
                return redirect($routeName)->with($viewData);
            }
            return redirect()->route($routeName)->with($viewData);
        } else if($with == 2) {                                       //表单提交错误提示
            if(preg_match('|^http://|', $routeName) || preg_match('|^https://|', $routeName)) 
            {
                return redirect($routeName)
                    ->withErrors($message)
                    ->withInput();
            }                               //表单提交错误提示
            if($routeName) 
            {
                return redirect()->route($routeName)
                    ->withErrors($message)
                    ->withInput();
            }
            return back()
                ->withErrors($message)
                ->withInput();
        } else if($with == 5) {                                     //返回上一级提示
            return back()->with($viewData);
        }
        if($this->tw_client['mobile']) 
        {
            return $this->loadTemplate('thinkwinds::wap.tips', $viewData);
        }
        return $this->loadTemplate('thinkwinds::common.tips', $viewData);
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
        if(substr_count($tpl, '::') ) {
            return view($tpl, $data);
        }
        return view($tpl, $data);
    }
}
