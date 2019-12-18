<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2019-2100 thinkwinds.com
 * @license http://www.thinkwinds.com
 */

/**
 * 检测验证码是否正确
 *
 * @param string $code
 * @return bool
 */
if ( ! function_exists('tw_cache_total_increment'))
{
    function tw_cache_total_increment($name, $val = 1)
    {
        $cacheName = 'thinkwinds:total:'.$name;
        if (!Cache::has($cacheName)) 
        {
            Cache::forever($cacheName, $val);
        } else {
        	$number = Cache::get($cacheName, 0);
            Cache::forever($cacheName, $number + $val);
        }
    }
}

if ( ! function_exists('tw_cache_total_decrement'))
{
    function tw_cache_total_decrement($name, $val = 1)
    {
        $cacheName = 'thinkwinds:total:'.$name;
        if (!Cache::has($cacheName)) 
        {
            Cache::forever($cacheName, $val);
        } else {
        	$number = Cache::get($cacheName, 0);
            Cache::forever($cacheName, $number - $val);
        }
    }
}

if ( ! function_exists('tw_cache_total'))
{
    function tw_cache_total($name)
    {
        $cacheName = 'thinkwinds:total:'.$name;
        if (!Cache::has($cacheName))
        {
            return 0;
        } else {
        	return Cache::get($cacheName, 0);
        }
    }
}

if ( ! function_exists('tw_cache_total_del'))
{
    function tw_cache_total_del($name)
    {
        $cacheName = 'thinkwinds:total:'.$name;
        if (Cache::has($cacheName))
        {
        	Cache::forget($cacheName);
        }
    }
}