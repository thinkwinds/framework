<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSiteStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!tw_config('site', 'vstate')) 
        {
            return redirect()->route('thinkwinds.close');
        }
        return $next($request);
    }
}
