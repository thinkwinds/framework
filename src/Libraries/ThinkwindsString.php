<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

class ThinkwindsString {
	
	const UTF8 = 'utf-8';
	const GBK = 'gbk';

	/**
	 * 截取字符串,支持字符编码,默认为utf-8
	 * 
	 * @param string $string 要截取的字符串编码
	 * @param int $start     开始截取
	 * @param int $length    截取的长度
	 * @param boolean $dot    是否显示省略号,默认为false
	 * @param string $charset 原妈编码,默认为UTF8
	 * @return string 截取后的字串
	 */
	public static function substr($string, $start, $length, $dot = false, $charset = self::UTF8)
	{
		switch (strtolower($charset))
		{
			case self::GBK:
				$string = self::substrForGbk($string, $start, $length, $dot);
				break;
			case self::UTF8:
				$string = self::substrForUtf8($string, $start, $length, $dot);
				break;
			default:
				$string = substr($string, $start, $length);
		}
		return $string;
	}

	/**
	 * 求取字符串长度
	 * 
	 * @param string $string  要计算的字符串编码
	 * @param string $charset 原始编码,默认为UTF8
	 * @return int
	 */
	public static function strlen($string, $charset = self::UTF8)
	{
		switch (strtolower($charset))
		{
			case self::GBK:
				$count = self::strlenForGbk($string);
				break;
			case self::UTF8:
				$count = self::strlenForUtf8($string);
				break;
			default:
				$count = strlen($string);
		}
		return $count;
	}

	/**
	 * 将变量的值转换为字符串
	 *
	 * @param mixed $input   变量
	 * @param string $indent 缩进,默认为''
	 * @return string
	 */
	public static function varToString($input, $indent = '')
	{
		switch (gettype($input))
		{
			case 'string':
				return "'" . str_replace(array("\\", "'"), array("\\\\", "\\'"), $input) . "'";
			case 'array':
				$output = "array(\r\n";
				foreach ($input as $key => $value)
				{
					$output .= $indent . "\t" . self::varToString($key, $indent . "\t") . ' => ' . self::varToString(
						$value, $indent . "\t");
					$output .= ",\r\n";
				}
				$output .= $indent . ')';
				return $output;
			case 'boolean':
				return $input ? 'true' : 'false';
			case 'NULL':
				return 'NULL';
			case 'integer':
			case 'double':
			case 'float':
				return "'" . (string) $input . "'";
		}
		return 'NULL';
	}

	/**
	 * 以utf8格式截取的字符串编码
	 * 
	 * @param string $string  要截取的字符串编码
	 * @param int $start      开始截取
	 * @param int $length     截取的长度，默认为null，取字符串的全长
	 * @param boolean $dot    是否显示省略号，默认为false
	 * @return string
	 */
	public static function substrForUtf8($string, $start, $length = null, $dot = false)
	{
		$l = strlen($string);
		$p = $s = 0;
		if (0 !== $start)
		{
			while ($start-- && $p < $l)
			{
				$c = $string[$p];
				if ($c < "\xC0")
					$p++;
				elseif ($c < "\xE0")
					$p += 2;
				elseif ($c < "\xF0")
					$p += 3;
				elseif ($c < "\xF8")
					$p += 4;
				elseif ($c < "\xFC")
					$p += 5;
				else
					$p += 6;
			}
			$s = $p;
		}
		
		if (empty($length))
		{
			$t = substr($string, $s);
		} else {
			$i = $length;
			while ($i-- && $p < $l)
			{
				$c = $string[$p];
				if ($c < "\xC0")
					$p++;
				elseif ($c < "\xE0")
					$p += 2;
				elseif ($c < "\xF0")
					$p += 3;
				elseif ($c < "\xF8")
					$p += 4;
				elseif ($c < "\xFC")
					$p += 5;
				else
					$p += 6;
			}
			$t = substr($string, $s, $p - $s);
		}
		
		$dot && ($p < $l) && $t .= "...";
		return $t;
	}

	/**
	 * 以gbk格式截取的字符串编码
	 * 
	 * @param string $string  要截取的字符串编码
	 * @param int $start      开始截取
	 * @param int $length     截取的长度，默认为null，取字符串的全长
	 * @param boolean $dot    是否显示省略号，默认为false
	 * @return string
	 */
	public static function substrForGbk($string, $start, $length = null, $dot = false)
	{
		$l = strlen($string);
		$p = $s = 0;
		if (0 !== $start)
		{
			while ($start-- && $p < $l)
			{
				if ($string[$p] > "\x80")
					$p += 2;
				else
					$p++;
			}
			$s = $p;
		}
		if (empty($length))
		{
			$t = substr($string, $s);
		} else {
			$i = $length;
			while ($i-- && $p < $l)
			{
				if ($string[$p] > "\x80")
					$p += 2;
				else
					$p++;
			}
			$t = substr($string, $s, $p - $s);
		}
		
		$dot && ($p < $l) && $t .= "...";
		return $t;
	}

	/**
	 * 以utf8求取字符串长度
	 * 
	 * @param string $string     要计算的字符串编码
	 * @return int
	 */
	public static function strlenForUtf8($string)
	{
		$l = strlen($string);
		$p = $c = 0;
		while ($p < $l)
		{
			$a = $string[$p];
			if ($a < "\xC0")
				$p++;
			elseif ($a < "\xE0")
				$p += 2;
			elseif ($a < "\xF0")
				$p += 3;
			elseif ($a < "\xF8")
				$p += 4;
			elseif ($a < "\xFC")
				$p += 5;
			else
				$p += 6;
			$c++;
		}
		return $c;
	}

	/**
	 * 以gbk求取字符串长度
	 * 
	 * @param string $string     要计算的字符串编码
	 * @return int
	 */
	public static function strlenForGbk($string)
	{
		$l = strlen($string);
		$p = $c = 0;
		while ($p < $l)
		{
			if ($string[$p] > "\x80")
				$p += 2;
			else
				$p++;
			$c++;
		}
		return $c;
	}
}