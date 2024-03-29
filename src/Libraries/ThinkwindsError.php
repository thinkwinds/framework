<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

class ThinkwindsErrorTmp
{
	public $msg;
	public $data;
}

class ThinkwindsError 
{
	protected $error = [];
	
	/**
	 * 错误创建
	 *
	 * @param string $error
	 * @param array $var 错误信息中的替换变量
	 * @param array $data 错误信息相关的具体业务数据
	 */
	public function __construct($error = '', array $var, array $data) 
	{
		$this->addError($error, $var, $data);
	}

	/**
	 * 添加错误信息
	 *
	 * @param string $error 错误信息
	 * @param array $var 错误信息中包含的错误输出变量，格式如{key}=>'value',在message中存在{key}
	 * <pre>
	 *  比如message中存在一条：
	 *  login.error.pwd="帐号或密码错误,您还可以尝试{num}次"
	 *  在返回该条错误的时候
	 *  $error = new Pw('USER:login.error.pwd', array('{num}' => 5));
	 *  </pre>
	 * @param array $data 错误数据
	 * @return boolean
	 */
	public function addError($error, array $var, array $data) 
	{
		if (!$error) return false;
		$tmp = new ThinkwindsErrorTmp();
		$tmp->msg = $var ? array($error, $var) : $error;
		$tmp->data = $data;
		$this->error[] = $tmp;
		return true;
	}

	/**
	 * 获取错误信息
	 * 
	 * @param boolean $isAll 是否返回所有的错误信息
	 * @return string
	 */
	public function getError($isAll = false) 
	{
		if ($isAll !== false) 
		{
			return $this->error;
		} else {
			$tmp = end($this->error);
			return $tmp ? $tmp->msg : '';
		}
	}
	
	/**
	 * 获取错误信息附带的数据
	 * 
	 * @return array
	 */
	public function getData() 
	{
		$tmp = end($this->error);
		return $tmp ? $tmp->data : '';
	}
}