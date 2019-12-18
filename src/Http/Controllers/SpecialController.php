<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\SpecialModel;

class SpecialController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show($v, Request $request) 
    {
        if(!$v) 
        {
            return $this->showError('thinkwinds::public.no.data', env('APP_URL'));
        }
        if(!is_numeric($v)) 
        {
            $v = SpecialModel::getIdByDir($v);
        }
        $info = SpecialModel::getInfo($v);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', env('APP_URL'));
        }
        $view = [
            'info'=>$info
        ];
        if($info['style']) 
        {
            if($info['module'] == 'default') 
            {
                return $this->loadTemplate($info['style'], $view);
            }
            return $this->loadTemplate($info['module'].'::'.$info['style'], $view);
        }
        if(config('websys.version'))
        {
            $SeoBo = websys_seoBo('area', 'custom', $info['id']);
            $SeoBo->set('{pagename}', $info['name']);
            $seo = $SeoBo->getData();
            $this->setSeo($seo['title'], $seo['keywords'], $seo['description']);
        } else {
             $this->setSeo($info['title'], $info['keywords'], $info['description']);
        }
        if($this->tw_client['mobile']) 
        {
            $view['css'] = url('theme/special/'.$v.'/wap/css');
            $view['images'] = url('theme/special/'.$v.'/wap/images');
            $view['js'] = url('theme/special/'.$v.'/wap/js');
            return $this->loadTemplate('special::'.$v.'.wap.index', $view);
        }
        $view['css'] = url('theme/special/'.$v.'/css');
        $view['images'] = url('theme/special/'.$v.'/images');
        $view['js'] = url('theme/special/'.$v.'/js');
        return $this->loadTemplate('special::'.$v.'.index', $view);
    }
}