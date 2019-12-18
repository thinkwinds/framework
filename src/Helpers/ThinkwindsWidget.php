<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Thinkwinds\Framework\Libraries\ThinkwindsWidget;
/**
 * hook
 */

if ( ! function_exists('thinkwinds_widget'))
{
    function thinkwinds_widget($widget_name, $data = null, $result = false)
    {
    	$thinkwindsWidget = new ThinkwindsWidget();
        if($result) 
        {
            return $thinkwindsWidget->call_widget($widget_name, $data, $result);
        }
        $thinkwindsWidget->call_widget($widget_name, $data, false);
    }
}