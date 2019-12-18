<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers\Manage;

use Validator;
use Illuminate\Http\Request;

class CaptchaController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
    	return $this->loadTemplate('thinkwinds::manage.captcha.index', [
            'config'=>tw_config('captcha')
        ]);
    }

    public function save(Request $request) 
    {
        $arrRequest = $request->all();
        $arrRequest['width'] = $arrRequest['width'] ? $arrRequest['width'] : 120;
        $arrRequest['height'] = $arrRequest['height'] ? $arrRequest['height'] : 60;
        $arrRequest['length'] = $arrRequest['length'] ? $arrRequest['length'] : 5;
        $data =[
            ['name'=>'width', 'value'=>$arrRequest['width']],
            ['name'=>'height', 'value'=>$arrRequest['height']],
            ['name'=>'length', 'value'=>$arrRequest['length']],
        ];
        $configData = [
            'CAPTCHA_WIDTH' => $arrRequest['width'] ? (int)$arrRequest['width'] : 120,
            'CAPTCHA_HEIGHT' => $arrRequest['height'] ? (int)$arrRequest['height'] : 60,
            'CAPTCHA_LENGTH' => $arrRequest['length'] ? (int)$arrRequest['length'] : 5,
        ];
        $oldConfig = tw_config('captcha');
        tw_save_config('captcha', $data);
        tw_updateEnvInfo($configData);
        $this->addOperationLog(tw_lang('thinkwinds::captcha.svae'),'', tw_config('captcha'), $oldConfig);
        return $this->showMessage('thinkwinds::public.save.success');
    }
}