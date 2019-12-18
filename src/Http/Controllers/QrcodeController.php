<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Illuminate\Http\Request;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;

class QrcodeController extends BaseController
{

	public function generate(Request $request)
	{
		$size = $request->get('size');
		$format = $request->get('format');
		$content = $request->get('content');
	}
}