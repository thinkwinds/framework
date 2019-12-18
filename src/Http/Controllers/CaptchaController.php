<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;

class CaptchaController extends BaseController
{

    public function get(Request $request) 
    {
    	$w = (int)$request->get('w');
        $h = (int)$request->get('h');
    	$l = (int)$request->get('l');
    	$width = $w ? $w : config('thinkwinds.captcha.width');
        $height = $h ? $h : config('thinkwinds.captcha.height');
    	$length = $l ? $l : config('thinkwinds.captcha.length');
        $str = tw_random($length);
        $builder = new CaptchaBuilder($str);
		$builder->build($width, $height);
		$_SESSION['phrase'] = $builder->getPhrase();
		header('Content-type: image/jpeg');
		$builder->output();
		exit;
    }
}