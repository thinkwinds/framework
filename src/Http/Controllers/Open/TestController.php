<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Open;

use Illuminate\Http\Request;
use App\Modules\Openapi\Http\Controllers\Open\OpenapiBasicController as OpenApiBasicController;

class TestController extends OpenApiBasicController
{

    public function index() 
    {
        return $this->notFond();
    }
}