<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\FormModel;
use Thinkwinds\Framework\Model\FieldsModel;
use Thinkwinds\Framework\Model\FormContentModel;
use Thinkwinds\Framework\Libraries\ThinkwindsFields;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;

class FormController extends BaseController
{
    public function show($formid, Request $request)
    {
        if(!$formid) 
        {
            return $this->showError('thinkwinds::public.no.id');
        }
        $info = FormModel::getForm($formid);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data');
        }
        $thinkwindsFields = new ThinkwindsFields();
        $fields = FieldsModel::getFields($info['table']);
        $inputHtml = $thinkwindsFields->input_html($fields);
        $view = [
            'formid'=> $formid,
            'info'=> $info,
            'inputHtml'=>$inputHtml
        ];
        return $this->loadTemplate('thinkwinds::form.show', $view);
    }

    public function save(Request $request) 
    {
        $formid = $request->get('formid');
        if(!$formid) 
        {
            return $this->showError('thinkwinds::public.no.id', 5);
        }
        $info = FormModel::getForm($formid);
        if(!$info) 
        {
            return $this->showError('thinkwinds::public.no.data', 5);
        }
        $thinkwindsFields = new ThinkwindsFields();
        $fields = FieldsModel::getFields($info['table']);
        $result = $thinkwindsFields->validate_filter($request, $fields);
        if($result['status'] == 'error') 
        {
            return $this->showError($result['error'], 2);
        }
        $psotData = $result['data'][$info['table']];
        $psotData['created_uid'] = (int)Auth::id();
        $psotData['created_time'] = tw_time();
        $psotData['created_ip'] = tw_ip();
        $psotData['created_port'] = tw_port();
        $psotData['vieworder'] = 0;
        $formContentModel = new FormContentModel();
        $formContentModel->setTable($info['table']);
        $id = $formContentModel->insertGetId($psotData);
        if($id) 
        {
            $thinkwindsFields->saveAttach($id, $request, $fields);
        }
        return $this->showMessage('thinkwinds::public.add.success'); 
    }
}