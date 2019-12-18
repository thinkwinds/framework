<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

class ThinkwindsData
{
	
    public function getData($callName = '', $extends)
    {   
        $_extends = [];
        if(!is_array($extends) || is_string($extends))
        {
            $_extend = explode('|', $extends);
            foreach ($_extend as $value)
            {
                $values = explode(':', $value);
                $_extends[$values[0]] = $values[1];
            }
        }
    	return [
    		['n'=>1]
    	];
    }
}