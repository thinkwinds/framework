<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Thinkwinds\Framework\Libraries\ThinkwindsSign;
use Thinkwinds\Framework\Helpers\Api\ApiResponse;

class ApiService
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $appid = $request->headers->get('appid') ? $request->headers->get('appid') : $request->get('appid');
        if(!$appid) 
        {
            return $this->message('Appid does not exist', '-1');
        }
        $app = tw_api_app($appid);
        if(!$app) 
        {
            return $this->message('Appid does not exist', '-2');
        }
        if($app && $app['status']) 
        {
            return $this->message('Appid A suspension of use', '-3');
        }
        if(config('thinkwinds.apiSign'))
        {
            $sign = $request->get('sign');
            if(!$sign) 
            {
                return $this->message('Sign Error', '-4');
            }
            $all = $request->all();
            $checkSign = false;
            $thinkwindsSign = new ThinkwindsSign();
            $checkSign = $thinkwindsSign->verifySign($all, $app['secret']);
            if(!$checkSign) 
            {
                return $this->message('Sign Error', '-5');
            }
        }
        $request->attributes->add(['apiAppInfo'=>$app]);    //添加参数
        return $next($request);
    }
}
