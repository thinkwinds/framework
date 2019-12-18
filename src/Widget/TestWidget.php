<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Widget;

class TestWidget
{
    public function test1($data = [])
    {
        $data['b'] = tw_lang('thinkwinds::public.the.array.hook1');
        return $data;
    }
   
    public function test2($data = [])
    {
        $data['c'] = tw_lang('thinkwinds::public.the.array.hook2');
        return $data;
    }

    public function test3($html = '')
    {
        //echo 'html钩子1输出内容,正常<br />';
        $html .= '1';
        return $html;
    }

    public function test4($html = '') 
    {
        //echo 'html钩子2输出内容,正常<br />';
        $html .='2';
        return $html;
    }
}
