<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries\Call;

use Illuminate\Http\Request;


class Html extends CallBaisc
{
	public $name = '自定义html';
	public $model = 'system';
	public $type = 'html';
	public $isRefresh = true;
	public $parameters = [
		['{html}','自定义html', 'html']
	];
	public $display = [];
	public $lookup = [
		'xiala'		=> ['select','tid', 'tid222', ['1'=>'下拉模式'],'multiple', ''],
		'select'		=> ['select','tid', 'tid222', 'options|html','', ''],
		'radios'	=> ['radio','tidx', '4242424', ['1'=>'模式','2'=>'模式2'],'', ''],
		'checkbox'	=> ['checkbox','tidx', '4242424', ['1'=>'模式','2'=>'模式2'],'', ''],
		'tid'		=> ['text', 'tid', 'tid222', '', '', ''],
		'html'		=> ['textarea', '自定义html', '限10000字节', '', '', ''],
	];
	
	/**
	 */
	public function decorateAddConfigures()
	{
		$data = [];
		$data['options'] = '<option value="">全部版块</option>';
		return $data;
	}
	
	/**
	 */
	public function decorateEditConfigures(array $moduleInfo) 
	{
		$data = [];
		$data['options'] = '<option value="">全部版块</option>';
		return $data;
	}

	public function decorateSaveConfigures(array $configures) 
	{
		if(tw_strLen($configures['html']) > 10000) return tw_message('html.length.error');
		$configures['html_tpl'] = $configures['html'];
		$configures['limit'] = 1;
		return $configures;
	}

	public function getData($field, $order, $limit, $offset) 
	{

	}
}