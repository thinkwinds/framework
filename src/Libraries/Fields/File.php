<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries\Fields;

use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\AttachmentModel;

class File extends FieldAbs 
{
	
	/**
     * 构造函数 单文件 **
     */
    public function __construct() 
    {
		parent::__construct();
		$this->name = tw_lang('thinkwinds::fields.file'); // 字段名称
		// TRUE表全部可用字段类型,自定义格式为 array('可用字段类型名称' => '默认长度', ... );
		$this->fieldtype = [
			'VARCHAR' => '255'
		]; 
		$this->defaulttype = 'VARCHAR'; // 当用户没有选择字段类型时的缺省值
    }
	
	/**
	 * 字段相关属性参数
	 *
	 * @param	array	$value	值
	 * @return  string
	 */
	public function option($option) 
	{
		$option['fieldtype'] = isset($option['fieldtype']) ? $option['fieldtype'] : '';
		$option['fieldlength'] = isset($option['fieldlength']) ? $option['fieldlength'] : '';
		$option['uptips'] = isset($option['uptips']) ? $option['uptips'] : '';
		$option['fvalue'] = isset($option['fvalue']) ? $option['fvalue'] : '';
		$option['value'] = isset($option['value']) ? $option['value'] : '';
		$option['size'] = isset($option['size']) ? $option['size'] : '2048';
		$option['ext'] = isset($option['ext']) ? $option['ext'] : 'jpg,png,gif,jpeg';
		$option['upauto'] = isset($option['upauto']) ? $option['upauto'] : 1;
		$option['upapp'] = isset($option['upapp']) ? $option['upapp'] : '';
		$option['upbuttontext'] = isset($option['upbuttontext']) ? $option['upbuttontext'] : '选择图片';
		return '
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.tw_lang('thinkwinds::fields.file.size').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][size]" value="'.$option['size'].'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_size" data-tips="'.tw_lang('thinkwinds::fields.file.size.tips').'">'.tw_lang('thinkwinds::fields.file.size.tips').'</div>
	          </div>
	          </div>
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.tw_lang('thinkwinds::fields.file.ext').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][ext]" value="'.$option['ext'].'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_ext" data-tips="'.tw_lang('thinkwinds::fields.file.ext.tips').'">'.tw_lang('thinkwinds::fields.file.ext.tips').'</div>
	          </div>
	        </div> 
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.tw_lang('thinkwinds::fields.file.upbuttontext').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][upbuttontext]" value="'.$option['upbuttontext'].'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_upbuttontext" data-tips="'.tw_lang('thinkwinds::fields.file.upbuttontext.tips').'">'.tw_lang('thinkwinds::fields.file.upbuttontext.tips').'</div>
	          </div>
	        </div> 
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.tw_lang('thinkwinds::fields.file.upapp').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][upapp]" value="'.$option['upapp'].'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_upapp" data-tips="'.tw_lang('thinkwinds::fields.file.upapp.tips').'">'.tw_lang('thinkwinds::fields.file.upapp.tips').'</div>
	          </div>
	        </div> 
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.tw_lang('thinkwinds::fields.file.uptips').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="setting[option][uptips]" value="'.$option['uptips'].'" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_uptips" data-tips="'.tw_lang('thinkwinds::fields.file.uptips.tips').'">'.tw_lang('thinkwinds::fields.file.uptips.tips').'</div>
	          </div>
	        </div> 
			<div class="hstui-form-group hstui-form-group-sm">
	          <label class="hstui-u-sm-2 hstui-form-label">'.tw_lang('thinkwinds::fields.file.auto.upload').'</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
                <div class="hstui-mr-sm"><input type="radio" name="setting[option][upauto]" '.tw_ifCheck(!$option['upauto']).' value="0" />'.tw_lang('thinkwinds::public.no').'
                    <input type="radio" name="setting[option][upauto]" '.tw_ifCheck($option['upauto']).' value="1" />'.tw_lang('thinkwinds::public.yes').'</div>
	            <div class="hstui-form-input-tips" id="J_form_tips_upauto" data-tips="'.tw_lang('thinkwinds::fields.file.auto.upload.tips').'">'.tw_lang('thinkwinds::fields.file.auto.upload.tips').'</div>
	          </div>
	        </div>
                '.$this->field_type($option['fieldtype'], $option['fieldlength'], $option['fvalue']);
	}
	
	/**
	 * 字段表单输入
	 *
	 * @param	string	$cname	字段别名
	 * @param	string	$name	字段名称
	 * @param	array	$cfg	字段配置
	 * @param	array	$data	值
	 * @return  string
	 */
	public function input($cname, $name, $cfg, $value = NULL, $id = 0) 
	{
		$upauto = isset($cfg['option']['upauto']) ? $cfg['option']['upauto'] ? 'true' : 'false'  : 'true';
		$upbuttontext = isset($cfg['option']['upbuttontext']) ? $cfg['option']['upbuttontext'] : tw_lang('thinkwinds::fields.file.select.pic');
		$uptips = isset($cfg['option']['uptips']) ? $cfg['option']['uptips'] : '';
		$upapp = isset($cfg['option']['upapp']) ? $cfg['option']['upapp'] : '';
		// 是否必须
		$text = (isset($cfg['validate']['required']) && $cfg['validate']['required'] == 1 ? '<font color="red">*</font>&nbsp;' : '').$cname;
		// 字段提示信息
		$tips = isset($cfg['validate']['tips']) && $cfg['validate']['tips'] ? $cfg['validate']['tips'] : '';
		// 禁止修改
		$disabled = !$this->isadmin && $id && $value && isset($cfg['validate']['isedit']) && $cfg['validate']['isedit'] ? 'false' : 'true';
		$postDatas ='';
		$attachs = [];
		if ($value) 
		{
			$attachInfo = $value;
			$attachs[0] = $attachInfo;
		}
		$attachs = json_encode($attachs);
		$uploadUrl = route('uploadSave');
		$str = '<div class="hstui-upload J_upload_'.$name.'" style="line-height: 20px;"></div>';
		$str .= "<script>
			Hstui.use('jquery', 'common', 'upload', function() {
				$(\".J_upload_$name\").hstuiUpload({
					autoUpload: $upauto,
					selectText: '$upbuttontext',
					multi: false,
					fileName: 'filedata',
					isedit: $disabled,
					dataList: $attachs,
					fName: '$name',
					queue: {
					},
					showNote: '$uptips',
					url: '$uploadUrl',
					formParam: {
						upapp:'$upapp'
					}
				})
			})
		</script>";
		return $this->input_format($name, $text, $str, $tips);
	}

    /**
     * 处理输入数据，提供给入库
     */
	public function insert_value(Request $request, $field, $postData = [])
	{
		$value = $request->get($field['fieldname']);
		if($value) 
		{
			$value = $value['aid'];
		}
		$postData[$field['relatedtable']][$field['fieldname']] = (int)$value;
    	return $postData;
    }
	
	/**
	 * 字段输出
	 */
	public function output_data($data, $field = []) 
	{
		if(!isset($data[$field['fieldname']])) 
		{
			return $data;
		}
		$value = $data[$field['fieldname']];
		$data['_'.$field['fieldname']] = $value;
		$data[$field['fieldname']] = AttachmentModel::getAttach($value);
		$data[$field['fieldname'].'_imgurl'] = $data[$field['fieldname']]['url'];
		return $data;
	}
}