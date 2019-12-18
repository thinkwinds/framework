<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Gregwar\Captcha\CaptchaBuilder;

/**
 * 检测验证码是否正确
 *
 * @param string $code
 * @return bool
 */
if ( ! function_exists('tw_captcha_check_code'))
{
    function tw_captcha_check_code($code)
    {
        $builder = new CaptchaBuilder(Session::get('phrase'));
        if ($builder->testPhrase($code)) 
        {
            return true;
        }
        return false;
    }
}