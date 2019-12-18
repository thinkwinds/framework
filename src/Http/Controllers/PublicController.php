<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\FormModel;
use Thinkwinds\Framework\Model\AreaModel;
use Thinkwinds\Framework\Model\FieldsModel;
use Thinkwinds\Framework\Libraries\ThinkwindsFields;
use Thinkwinds\Framework\Libraries\ThinkwindsPinYin;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;

class PublicController extends BaseController
{

    public function thinkwindsClose(Request $request) 
    {
        $closeTmpl = tw_config('site', 'vmtemplate') ? tw_config('site', 'vmtemplate') : 'thinkwinds::common.close';
        $message = tw_config('site', 'vmessage') ? tw_config('site', 'vmessage') : tw_lang('thinkwinds::public.site.close.tips');
        return view($closeTmpl, [
            'referer'=>'',
            'with'=>0,
            'message'=>$message
        ]);
    }

    public function fieldsTypeHtml(Request $request) 
    {
        $id = $request->get('id');
        $type = $request->get('type');
        $rname = $request->get('rname');
        $relatedid = $request->get('relatedid');
    	$fieldInfo = FieldsModel::getField($id);
        if ($fieldInfo) 
        {
            $option = isset($fieldInfo['setting']['option']) ? $fieldInfo['setting']['option'] : [];
        } else {
            $option = [];
        }
        $fields = [];
        if($rname == 'form') 
        {
            $formInfo = FormModel::getForm($relatedid);
            $fields = FieldsModel::getFields($formInfo['table'], $formInfo['module']);
        }
        $thinkwindsFields = new ThinkwindsFields();
        $return = $thinkwindsFields->option($type, $option, $fields);
        if ($return !== 0) 
        {
            return $return;
        }
        return '';
    }

    public function topinyin(Request $request) 
    {
        $str = $request->get('str', TRUE);
        if (!$str) 
        {
            return '';
        }
        $thinkwindsPinYin = new ThinkwindsPinYin();
        exit($thinkwindsPinYin->result($str));
    }

    public function getAreaSubList(Request $request)
    {
        $areaid = $request->get('areaid');
        if(!$areaid) 
        {
            echo json_encode([]);
            exit;
        }
        $list = AreaModel::getSubByAreaid($areaid, false);
        echo json_encode($list);
        exit;
    } 

    public function viewpw(Request $request)
    {
        $viewpw = $request->get('viewpw');
        $password = $request->get('password');
        if(!$password) 
        {
            return $this->showError('thinkwinds::public.viewpw.password.empty');
        }
        $result = tw_decrypt($viewpw, $password);
        if(tw_message_verify($result)) 
        {
            return $this->showError($result['message']);
        }
        $this->addMessage($result, 'viewpw');
        return $this->showMessage('thinkwinds::public.successfull');
    }
}