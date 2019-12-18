<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries\Call;

use Illuminate\Http\Request;

abstract class CallBaisc
{
	public $configure;

	abstract public function getData($field, $order, $limit, $offset);
    
    public function getConfigure() 
    {
        $this->configure = array_merge($this->display, $this->lookup);
        return $this->configure;
    }
}