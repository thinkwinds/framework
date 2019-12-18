<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Middleware;

use Closure;
use Illuminate\Filesystem\Filesystem;

class RequestLog
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
        if(tw_config('safe', 'manage.request')) 
        {
            $RequestLogDir = base_path('storage/thinkwinds/requestlog/'. tw_time2str(tw_time(), 'Ym') . '/');
            $file = $RequestLogDir . tw_time2str(tw_time(), 'd') . '.log';
            $files = new Filesystem();
            if (!$files->isDirectory($RequestLogDir)) 
            {
                $files->makeDirectory($RequestLogDir, 0755, true);
            }
            $data = [
                'method'=> $request->method(),
                'uri'=> $request->path(),
                'url'=> url()->current(),
                'times'=> tw_time(),
                'ip'=> tw_ip(),
                'port'=> tw_port(),
                'platform'=> tw_agent()->platform(),
                'browser'=> tw_agent()->browser(),
                'data'=> $request->all(),
                'username'=> 'admin'
            ];
            $log = is_file($file) ? @explode(PHP_EOL, file_get_contents($file)) : array();
            if ($log) 
            {
                $end = empty(end($log)) ? unserialize(end($log)) : array();
                if ($end
                    && $end['method'] === $request->method()
                    && $end['uri'] === $request->path()
                    && $data['username'] === $end['username']
                    && ($data['times'] - $end['times']) < 1) 
                {
                    unset($data);// 1s内的重复操作不记录
                }
            }
            if (isset($data) && is_array($data)) 
            {
                $_phpeol = $log ? PHP_EOL:"";
                if(isset($data['data']['filedata'])) 
                {
                    $data['data']['filedata'] = [];
                }
                file_put_contents($file, $_phpeol . serialize($data), FILE_APPEND);
            }
            unset($data, $RequestLogDir, $file, $log, $end);
        }
        return $next($request);
    }
}
