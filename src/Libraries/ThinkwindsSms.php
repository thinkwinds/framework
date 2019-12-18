<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

use Thinkwinds\Framework\Model\SmsModel;
use Thinkwinds\Framework\Model\SmsCodeModel;

class ThinkwindsSms
{
	public $plat;
	public $type = [];
	public $platforms = [];

	public function __construct()
	{
		$this->setPlat();
	}

	public function getStatus($id = 0) 
	{
		if (!$this->plat) 
		{
			return tw_message(tw_lang('thinkwinds::manage.sms.plat.choose.error'));
		}
		$smsLog = SmsModel::where('id', $id)->select('id', 'rtype', 'requestid', 'status')->first();
		if(!$smsLog) 
		{
			return tw_message(tw_lang('thinkwinds::manage.sms.log.no.error'));
		}
		if(!$smsLog['requestid']) 
		{
			return tw_message(tw_lang('thinkwinds::manage.sms.log.no.error'));
		}
		if($smsLog['status'] == 3) 
		{
			return true;
		}
		$result = $this->plat->getStatus($smsLog['rtype'], $smsLog['requestid']);
		if (tw_message_verify($result)) 
		{
			return $result;
		}
		SmsModel::where('id', $id)->update(['jstimes'=>$result['res']['jstimes'], 'stimes'=>$result['res']['times'], 'status'=>$result['res']['status']]);
		return true;
	}
	
	/**
	 * 发送短信
	 *
	 * @return bool
	 */
	public function sendMobileMessage($mobile, $type, $param = [], $uid = 0) 
	{
		if (!$this->plat) 
		{
			return tw_message(tw_lang('thinkwinds::manage.sms.plat.choose.error'));
		}
		$this->type = SmsModel::getType($type);
		if (!$this->type) 
		{
			return tw_message(tw_lang('thinkwinds::manage.sms.plat.choose.error'));
		}
		$code = SmsCodeModel::_buildCode();
		$content = $this->_buildContent($code, $type);
		$number = $this->checkTodayNum($mobile, $type);
		if (tw_message_verify($number)) 
		{
			return $number;
		}
		$param['code'] = $code;
		$param['product'] = tw_config('sms', 'product');
		$result = $this->plat->sendMobileMessage($mobile, $content, $param);
		if (tw_message_verify($result)) 
		{
			return $result;
		}
		$results = SmsCodeModel::addInfo($mobile, $type, $code, $number);
		if($results) 
		{
			SmsModel::addInfo($mobile, $type, $code, $content, json_encode($param), (int)$result['res']['type'], $result['res']['requestid'], $uid);
		}
		return true;
	}

	/**
	 * 验证验证码
	 * 
	 */
	public function checkVerify($mobile, $inputCode, $type = 'register') 
	{
		if (!$mobile || !$inputCode) return tw_message(tw_lang('thinkwinds::public.mobile.code.mobile.empty'));
		$info = SmsCodeModel::where('type', $type)->where('mobile', $mobile)->first();
		if (!$info) return tw_message(tw_lang('thinkwinds::public.mobile.code.error'));
		if ($info['expired_time'] < tw_time()) return tw_message(tw_lang('thinkwinds::public.mobile.code.expired_time.error'));
		if ($inputCode !== $info['code']) return tw_message(tw_lang('thinkwinds::public.mobile.code.error'));
		return true;
	}

	/**
	 * 检查发送次数
	 * 
	 */
	public function checkTodayNum($mobile, $type = 'register') 
	{
		$info = SmsCodeModel::where('type', $type)->where('mobile', $mobile)->first();
		$number = 1;
		$tdtime = tw_tdtime();
		if ($info)
		{
			$number = $info['number'];
			if ($info['create_time'] < $tdtime + 86400 && $info['create_time'] > $tdtime) 
			{
				$number++;
			} else {
				$number = 1;
			}
		}
		if ($number > $this->type['num']) 
		{
			return tw_message(tw_lang('thinkwinds::public.mobile.code.send.num.error'));
		}
		return $number;
	}

	protected function _buildContent($code, $type = 'register') 
	{
		$content = tw_config('sms', 'types');
		$search = array('{code}', '{product}');
		$replace = array($code, tw_config('sms', 'product'));
		$content = str_replace($search, $replace, $content[$type]['content']);
		return $content;
	}

	public function setPlat() 
	{
		$plat = tw_config('sms', 'platform');
        $this->platforms = SmsModel::getPlatform($plat);	
        if(class_exists($this->platforms['components'])) 
        {
			$this->plat = new $this->platforms['components']();
		}
	}
}