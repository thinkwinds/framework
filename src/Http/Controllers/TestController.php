<?php 

namespace Huasituo\Hook\Http\Controllers;

use Huasituo\Hstcms\Http\Controllers\BasicController as BaseController;

use Illuminate\Http\Request;

use Hooks;

class TestController extends BaseController
{

    public function index() 
    {
        $data = Hooks::call_hook('s_test_arr', ['a'=>1], true);
        return $this->loadTemplate('hook::test', ['data'=>$data]);
    }

}