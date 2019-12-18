<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Illuminate\Http\Request;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;

class AmapController extends BaseController
{
	public function index(Request $request)
	{
		$lng = $request->get('lng');
		$lat = $request->get('lat');
		$zoom = (int)$request->get('zoom');
		$zoom = $zoom ? $zoom : 16;
		$city = $request->get('city');
		$name = $request->get('name');
		$title = $request->get('title');
		$isview = (int)$request->get('isview');
		$view =[
			'seo_title'=>tw_lang('amap.title'),
			'lng'=>$lng,
			'lat'=>$lat,
			'zoom'=>$zoom,
			'city'=>$city,
			'name'=>$name,
			'isview'=>$isview,
			'title'=>$title
		];
		return $this->loadTemplate('thinkwinds::amap.index', $view);
	}
}