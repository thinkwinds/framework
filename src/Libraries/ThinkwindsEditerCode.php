<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

class ThinkwindsEditerCode
{
    public $content = '';
    public $pwkey = 'thinkwinds';
    /**
     * 
     *
     * @param  string  $content
     * @return void
     *
     * @throws \RuntimeException
     */
    public function __construct($content)
    {
        $this->content = (string) $content;
    }

    public function createContent()
    {
        $this->createPw();
        return $this;
    }

    public function showContent()
    {
        $this->showPw();
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    protected function createPw()
    {
        preg_match_all ("/\[pw\](.*)\[\/pw\]/U", $this->content, $contents);
        $replace = [];
        foreach ($contents[1] as $v) 
        {
            $vs = explode('|', $v);
            $str = tw_encrypt($vs[0], isset($vs[1]) && $vs ? $vs[1] : $this->pwkey);
            // $replace[] = '<span data-isview="0" class="J_pw" data-pw="'.$str.'">点击查看</span>';
            $replace[] = '[infostr]'.$str.'[/infostr]';
        }
        $this->content = str_replace($contents[0], $replace, $this->content);
    }

    protected function showPw()
    {
        preg_match_all ("/\[infostr\](.*)\[\/infostr\]/U", $this->content, $contents);
        $replace = [];
        foreach ($contents[1] as $v) 
        {
            $replace[] = '<span data-isview="0" class="J_pw" data-pw="'.$v.'">点击查看</span>';
        }
        $this->content = str_replace($contents[0], $replace, $this->content);
    }
}
