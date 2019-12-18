<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

class BasicController extends GlobalBasicController
{

    public function __construct()
    {
        parent::__construct();
        tw_checkInstall();
        //前端多彩主题
        $skin_color = tw_config('site', 'skin_color');
        if($skin_color) 
        {
            $this->tw_data['skin_color'] = $skin_color;
        }
        $icp = tw_config('site', 'icp') ? '<a href="http://www.miibeian.gov.cn/" target="_blank">'.tw_config('site', 'icp').'</a>' : '';
        $this->tw_data['icp'] = $icp;
        $this->middleware('check.site.status');
    }

    public function setSeo($seo_title = '', $seo_keywords = '', $seo_description = '') 
    {
        if(is_array($seo_title)) 
        {
            $this->tw_data['seo_title'] = $seo_title['title'];
            $this->tw_data['seo_keywords'] = $seo_title['description'];
            $this->tw_data['seo_description'] = $seo_title['keywords'];
        } else {
            $this->tw_data['seo_title'] = $seo_title;
            $this->tw_data['seo_keywords'] = $seo_keywords;
            $this->tw_data['seo_description'] = $seo_description;
        }
    }
}
