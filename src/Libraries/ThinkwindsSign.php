<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

class ThinkwindsSign
{

    public function createSign($para_temp, $secretKey = '', $privateKey = '', $publicKey = '')
    {
        $prestr = $para_temp;
        if(is_array($para_temp)) 
        {
            //除去待签名参数数组中的空值和签名参数
            $para_filter = $this->paraFilter($para_temp);
            //对待签名参数数组排序
            $para_sort = $this->argSort($para_filter);
            //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
            $prestr = $this->createLinkstring($para_sort);
        }
        $sign = "";
        $para_temp['sign_type'] = isset($para_temp['sign_type']) ? $para_temp['sign_type'] : 'MD5';
        switch (strtoupper(trim($para_temp['sign_type']))) 
        {
            case "MD5" :
                $ThinkwindsMd5Sign = new ThinkwindsMd5Sign();
                $ThinkwindsMd5Sign = $ThinkwindsMd5Sign->setSecretKey($secretKey);
                $ThinkwindsMd5Sign = $ThinkwindsMd5Sign->setPrivateKey($privateKey);
                $sign = $ThinkwindsMd5Sign->createSign($prestr);
                break;
            case "RSA2" :
                $ThinkwindsRsaSign = new ThinkwindsRsaSign();
                $ThinkwindsRsaSign = $ThinkwindsRsaSign->setPrivateKey($privateKey);
                $ThinkwindsRsaSign = $ThinkwindsRsaSign->setPublicKey($publicKey);
                $sign = $ThinkwindsRsaSign->createSign($prestr);
                break;
            default :
                $sign = "";
        }
        return $sign;
    }

    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 数据数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
    public function verifySign($para_temp, $secretKey = '', $privateKey = '', $publicKey = '') 
    {
        $prestr = $para_temp;
        if(is_array($para_temp)) 
        {
            //除去待签名参数数组中的空值和签名参数
            $para_filter = $this->paraFilter($para_temp);
            //对待签名参数数组排序
            $para_sort = $this->argSort($para_filter);
            //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
            $prestr = $this->createLinkstring($para_sort);
        }
        $isSgin = false;
        $para_temp['sign_type'] = isset($para_temp['sign_type']) ? $para_temp['sign_type'] : 'MD5';
        switch (strtoupper(trim($para_temp['sign_type']))) 
        {
            case "MD5" :
                $ThinkwindsMd5Sign = new ThinkwindsMd5Sign();
                $ThinkwindsMd5Sign = $ThinkwindsMd5Sign->setSecretKey($secretKey);
                $ThinkwindsMd5Sign = $ThinkwindsMd5Sign->setPrivateKey($privateKey);
                $isSgin = $ThinkwindsMd5Sign->verifySign($prestr, $para_temp['sign']);
                break;
            case "RSA2" :
                $ThinkwindsRsaSign = new ThinkwindsRsaSign();
                $ThinkwindsRsaSign = $ThinkwindsRsaSign->setPrivateKey($privateKey);
                $ThinkwindsRsaSign = $ThinkwindsRsaSign->setPublicKey($publicKey);
                $isSgin = $ThinkwindsRsaSign->verifySign($prestr, $para_temp['sign']);
                break;
            default :
                $isSgin = false;
        }
        return $isSgin;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param $para 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    public function paraFilter(array $para = []) 
    {
        $para_filter = [];
        foreach ($para as $key => $val) 
        {
            if($key == "sign" || $key == "sign_type" || $val == "") continue;
            else    $para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }

    /**
     * 对数组排序
     * @param $para 排序前的数组
     * return 排序后的数组
     */
    public function argSort(array $para = []) 
    {
        ksort($para);
        reset($para);
        return $para;
    }
	
    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    public function createLinkstring(array $para = []) 
    {
        $arg  = "";
        foreach ($para as $key => $val) 
        {
            $arg.=$key."=".$val."&";
        }
        // while (list ($key, $val) = each ($para)) 
        // {
        //     $arg.=$key."=".$val."&";
        // }
        //去掉最后一个&字符
        $arg = substr($arg, 0, tw_strLen($arg) - 1);
        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
        return $arg;
    }
}