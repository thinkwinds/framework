<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2019-2100 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
/**
 * 获取域名
 * @param $url
 * @return string
 */
if ( ! function_exists('tw_url'))
{    
    function tw_url($url = '')
    {
        return url($url);
    }
}

/**
 * 获取res链接
 * @param $url
 * @return string
 */
if ( ! function_exists('tw_resurl'))
{    
    function tw_resurl($url = '')
    {
        return config('thinkwinds.resurl').'/'.$url;
    }
}

/**
 * 获取publc目录所有地址
 *
 * @param   string  $path
 * @return  string
 */
if ( ! function_exists('tw_public'))
{
    function tw_public($path, $domain = true) {
        if($domain) {
            return tw_url('/'.$path);
        }
    }
}

/**
 * 获取assets目录所有地址
 *
 * @param   string  $path
 * @return  string
 */
if ( ! function_exists('tw_assets'))
{
    function tw_assets($path) {
        if(tw_config('site', 'assets.url')) {
            return tw_config('site', 'assets.url').'/'.$path;
        } else {
            return tw_url('/assets/'.$path);
        }
    }
}

/**
 * 将数组格式的参数列表转换为Url格式，并将url进行编码处理
 * 
 * <code>参数:array('b'=>'b','c'=>'index','d'=>'d')
 * 分割符: '&='
 * 转化结果:&b=b&c=index&d=d
 * 如果分割符为: '/' 则转化结果为: /b/b/c/index/d/d/</code>
 * @param array $args
 * @param boolean $encode 是否进行url编码 默认值为false
 * @param string $separator url分隔符 支持双字符,前一个字符用于分割参数对,后一个字符用于分割键值对
 * @return string
 */
if( ! function_exists('tw_argsToUrl'))
{
    function tw_argsToUrl($args, $encode = false, $separator = '&=', $key = null) {
        if (strlen($separator) !== 2) return;
        $_tmp = '';
        foreach ((array) $args as $_k => $_v) {
            if ($key !== null) $_k = $key . '[' . $_k . ']';
            if (is_array($_v)) {
                $_tmp .= tw_argsToUrl($_v, $encode, $separator, $_k) . $separator[0];
                continue;
            }
            $_v = $encode ? rawurlencode($_v) : $_v;
            if (is_int($_k)) {
                $_v && $_tmp .= $_v . $separator[0];
                continue;
            }
            $_k = ($encode ? rawurlencode($_k) : $_k);
            $_tmp .= $_k . $separator[1] . $_v . $separator[0];
        }
        return trim($_tmp, $separator[0]);
    }
}

if( ! function_exists('tw_getUrlArgs'))
{
    function tw_getUrlArgs($args, $key, $is = false) {
        $urlargs = '';
        $_args  = array();
        if (!is_array($args) || !$args) return $is ? $urlargs : $_args;
        foreach ($args as $k => $v) {
            if ($k == $key || !$v || (is_array($key) && in_array($k, $key))) continue;
            if($is) {
                $urlargs .= "&$k=$v";
            } else {
                $_args[$k] = $v;
            }
        }
        return $is ? trim($urlargs, '&') : $_args;
    }
}