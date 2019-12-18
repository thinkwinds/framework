<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries\HuasituoApi;

class ApiSign 
{
    public function createSign($para_temp, $secretKey = '', $privateKey = '', $publicKey = '')
    {
        $prestr = $para_temp;
        if(is_array($para_temp)) 
        {
            $para_filter = $this->paraFilter($para_temp);//除去待签名参数数组中的空值和签名参数
            $para_sort = $this->argSort($para_filter);//对待签名参数数组排序
            $prestr = $this->createLinkstring($para_sort);//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        }
        $sign = "";
        switch (strtoupper(trim($para_temp['sign_type']))) 
        {
            case "MD5" :
                $ApiMd5Sign = new ApiMd5Sign();
                $ApiMd5Sign = $ApiMd5Sign->setSecretKey($secretKey);
                $ApiMd5Sign = $ApiMd5Sign->setPrivateKey($privateKey);
                $sign = $ApiMd5Sign->createSign($prestr);
                break;
            case "RSA2" :
                $ApiRsaSign = new ApiRsaSign();
                $ApiRsaSign = $ApiRsaSign->setPrivateKey($privateKey);
                $ApiRsaSign = $ApiRsaSign->setPublicKey($publicKey);
                $sign = $ApiRsaSign->createSign($prestr);
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
            $para_filter = $this->paraFilter($para_temp);//除去待签名参数数组中的空值和签名参数
            $para_sort = $this->argSort($para_filter);//对待签名参数数组排序
            $prestr = $this->createLinkstring($para_sort);//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        }
        $isSgin = false;
        switch (strtoupper(trim($para_temp['sign_type']))) 
        {
            case "MD5" :
                $ApiMd5Sign = new ApiMd5Sign();
                $ApiMd5Sign = $ApiMd5Sign->setSecretKey($secretKey);
                $ApiMd5Sign = $ApiMd5Sign->setPrivateKey($privateKey);
                $isSgin = $ApiMd5Sign->verifySign($prestr, $para_temp['sign']);
                break;
            case "RSA2" :
                $ApiRsaSign = new ApiRsaSign();
                $ApiRsaSign = $ApiRsaSign->setPrivateKey($privateKey);
                $ApiRsaSign = $ApiRsaSign->setPublicKey($publicKey);
                $isSgin = $ApiRsaSign->verifySign($prestr, $para_temp['sign']);
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
    public function paraFilter($para) 
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
    public function argSort($para) 
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
    public function createLinkstring($para) 
    {
        $arg  = "";
        while (list ($key, $val) = each ($para)) 
        {
            $arg.=$key."=".$val."&";
        }
        $arg = substr($arg, 0, count($arg) - 2);//去掉最后一个&字符
        if(get_magic_quotes_gpc())
        {
            $arg = stripslashes($arg);
        }//如果存在转义字符，那么去掉转义
        return $arg;
    }
}