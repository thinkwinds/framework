<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Api;

use Illuminate\Http\Request;

class TestController extends BasicController
{

    public function index(Request $request) 
    {
        return $this->notFond();
    }
}