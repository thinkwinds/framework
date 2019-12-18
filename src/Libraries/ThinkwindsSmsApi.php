<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

use Thinkwinds\Framework\Libraries\ThinkwindsApi\ApiBase;
use Thinkwinds\Framework\Libraries\ThinkwindsApi\Requests\ThinkwindsApiSmsRequests;

class ThinkwindsSmsApi
{
	protected $smsConfig = [];
	protected $thinkwindsSmsApi;

	public function __construct($config = []) 
	{
		$this->smsConfig = tw_config('sms');
		$this->thinkwindsSmsApi = new ApiBase();

		$this->thinkwindsSmsApi->appId = isset($this->smsConfig['hstsmsappid']) ? $this->smsConfig['hstsmsappid'] : '';
		$this->thinkwindsSmsApi->secretKey = isset($this->smsConfig['hstsmskey']) ? $this->smsConfig['hstsmskey'] : '';

		if(isset($config['appId'])) {
			$this->thinkwindsSmsApi->appId = $config['appId'];
		}

		if(isset($config['secretKey'])) {
			$this->thinkwindsSmsApi->secretKey = $config['secretKey'];
		}

		if(isset($config['signId'])) {
			$this->smsConfig['hstsmssign'] = $config['signId'];
		}
		$this->thinkwindsSmsApi->rsaPublicKey = '';
		$this->thinkwindsSmsApi->rsaPrivateKey = '';
		$this->thinkwindsSmsApi->signType = 'MD5';
	}

	public function sendMobileMessage($mobile, $content, $param = []) 
	{
		$request = new HuasituoApiSmsRequests($this->thinkwindsSmsApi);
		$request->setSignid($this->smsConfig['hstsmssign']);
		$request->setTplid($content);
		$request->setMobile($mobile);
		$request->setParam($param);
		$request->sendMessage();
		$result = $this->thinkwindsSmsApi->execute($request);
		if($result['code'] != 0) {
			return tw_message($result['message']);
		}
		return $result;
	}

	public function getSurplus() 
	{
		$request = new HuasituoApiSmsRequests($this->thinkwindsSmsApi);
		$request->getSurplus();
		$result = $this->thinkwindsSmsApi->execute($request);
		return $result;
	}

	public function getPay($money, $note = '') 
	{
		$request = new HuasituoApiSmsRequests($this->thinkwindsSmsApi);
		$request->setAmount($money);
		$request->pay();
		$result = $this->thinkwindsSmsApi->execute($request, true);
		return $result;
	}

	public function getStatus($rtype, $requestid = '') 
	{
		$request = new HuasituoApiSmsRequests($this->thinkwindsSmsApi);
		$request->setId($requestid);
		$request->setType($rtype);
		$request->getStatus();
		$result = $this->thinkwindsSmsApi->execute($request);
		if($result['state'] != 0) {
			return tw_message($result['message']);
		}
		return $result;
	}

}

