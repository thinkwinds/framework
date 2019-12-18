<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2019-2100 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
/**
 * 获取时间类型
 * @param $str
 * @return string
 */
if ( ! function_exists('tw_change_time_type'))
{    
    function tw_change_time_type($seconds)
    {
        $one_day = 3600*24;
        if ($seconds > $one_day) 
        {
            $day = floor($seconds/$one_day);
            $hour = $seconds%$one_day;
            $hour = floor($hour/3600);
            $mimute = ($seconds - $day * $one_day) % 3600 ;
            $mimute = floor($mimute/60);
            $seconds = $seconds - $day * $one_day - $hour * 3600 - $mimute * 60;
            return $day.tw_lang('thinkwinds::public.day').$hour.tw_lang('thinkwinds::public.hour').$mimute.tw_lang('thinkwinds::public.minute').$seconds.tw_lang('thinkwinds::public.minutes');
        }  elseif($seconds > 3600) {
            $hour = floor($seconds/3600);
            $mimute = $seconds%3600;
            $mimute = floor($mimute/60);
            $seconds = $seconds%3600 - $mimute * 60;
            return $hour.tw_lang('thinkwinds::public.hour').$mimute.tw_lang('thinkwinds::public.minute').$seconds.tw_lang('thinkwinds::public.minutes');
        } elseif($seconds > 60) {
            $mimute = floor($seconds/60);
            $seconds = $seconds - $mimute * 60;
            return $mimute.tw_lang('thinkwinds::public.minute').$seconds.tw_lang('thinkwinds::public.minutes');
        }
        return $seconds.tw_lang('thinkwinds::public.minutes');
    }
}

/**
 * 将时间字串转化成零时区时间戳返回
 *
 * @param string $str 格式良好的时间串
 * @return int
 */
if ( ! function_exists('tw_str2time'))
{    
    function tw_str2time($str) 
    {
        $timestamp = strtotime($str);
        //if ($timezone = self::getConfig('site', 'time.timezone')) $timestamp -= $timezone * 3600;
        return $timestamp;
    }
}

/**
 * 时间戳转字符串
 *
 * @example Y-m-d H:i:s  2012-12-12 12:12:12
 * @param int $timestamp 时间戳
 * @param string $format 时间格式
 * @param int $sOffset 时间矫正值
 * @return string
 */
if ( ! function_exists('tw_time2str'))
{    
    function tw_time2str($timestamp = '', $format = 'Y-m-d H:i') 
    {
        if (!$timestamp) return '';
        if ($format == 'auto') return tw_time2cpstr($timestamp);
        //if ($timezone = self::getConfig('site', 'time.timezone')) $timestamp += $timezone * 3600;
        return gmdate($format, $timestamp);
    }
}

/**
 * 时间戳转字符串
 *
 * @example Y-m-d H:i:s  2012-12-12 12:12:12
 * @param int $timestamp 时间戳
 * @param string $format 时间格式
 * @param int $sOffset 时间矫正值
 * @return string
 */
if ( ! function_exists('tw_time2cpstr'))
{    
    function tw_time2cpstr($timestamp) 
    {
        $current = tw_time();
        $decrease = $current - $timestamp;
        if ($decrease < 0) return tw_time2str($timestamp);
        if ($decrease < 60) return $decrease . tw_lang('thinkwinds::public.minutes.front');
        if ($decrease < 3600) return ceil($decrease / 60) . tw_lang('thinkwinds::public.minute.front');
        $decrease = tw_time2str(tw_time2str($current, 'Y-m-d')) - tw_time2str(tw_time2str($timestamp, 'Y-m-d'));
        if ($decrease == 0) return tw_time2str($timestamp, 'H:i');
        if ($decrease == 86400) return tw_lang('thinkwinds::public.yesterday') . tw_time2str($timestamp, 'H:i');
        if ($decrease == 172800) return tw_lang('thinkwinds::public.the.day.before.yesterday') . tw_time2str($timestamp, 'H:i');
        if (tw_time2str($timestamp, 'Y') == tw_time2str($current, 'Y')) return tw_time2str($timestamp, 'm-d H:i');
        return tw_time2str($timestamp);
    }
}

/**
 * 获取矫正过的时间戳值
 *
 * @return int
 */
if ( ! function_exists('tw_time'))
{    
    function tw_time() 
    {
        return time() + 8 * 3600;
    }
}

/**
 * 获取今日零点时间戳
 *
 * @return int
 */
if ( ! function_exists('tw_tdtime'))
{    
    function tw_tdtime() 
    {
        return tw_str2time(tw_time2str(tw_time(), 'Y-m-d'));
    }
}

/**
 * 获取今日凌晨时间
 *
 * @return int
 */
if ( ! function_exists('tw_tdtime_str'))
{    
    function tw_tdtime_str() 
    {
        return tw_time2str(tw_tdtime(), 'Y-m-d H:i:s');
    }
}