<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Illuminate\Database\Eloquent\Model;

class SmsCodeModel extends Model
{
    protected $table = 'sms_code';
    protected $fillable = [
        'mobile', 'code', 'expired_time', 'number', 'create_time', 'type'
    ];
    public $timestamps = false;

    static function addInfo($mobile, $type, $code, $number, $expired_time = 0, $create_time = 0) 
    {
    	$postData = [
    		'mobile'=>$mobile,
    		'type'=>$type,
    		'code'=>$code,
    		'number'=>$number,
    		'expired_time'=>$create_time ? $create_time : tw_time() + 300,
    		'create_time'=> $create_time ? $create_time : tw_time()
    	];
    	$info = SmsCodeModel::where('mobile', $mobile)->where('type', $type)->first();
    	if($info) 
        {
    		unset($postData['mobile']);
    		unset($postData['type']);
    		SmsCodeModel::where('mobile', $mobile)->where('type', $type)->update($postData);
    	} else {
    		SmsCodeModel::insert($postData);
    	}
    	return true;
    }

	static function _buildCode() 
    {
		$length = tw_config('sms', 'codelength');
		$length = $length ? $length : 6;
		return tw_random($length, true);
	}
}
