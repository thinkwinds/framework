<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries\Compiles;

class Compiles
{
	public function getExpression($expression = null, $isArray = true)
	{
		if(!$isArray) return $expression;
		return explode(",", $expression);
	}
}