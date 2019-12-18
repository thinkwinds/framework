<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

use Illuminate\Support\Facades\Mail;                //邮箱服务
/**
* 
*/
class ThinkwindsEmail 
{
	public function __construct() {
		
	}
	
    /**
     * 发送邮件
     *
     * @param array $data
     * @param str $view
     * @return bool
     */
    static function sendMail($data, $view)
    {
        $res = Mail::send($view, ['data' => $data], function ($message) use ($data) 
        {
            $message->to($data['email'])->subject($data['title']);
        });
        return $res ? true : false;
    }
}