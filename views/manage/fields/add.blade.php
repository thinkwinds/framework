<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.fields.addSave') }}" method="post">
    {!! tw_csrf() !!}
    <input type="hidden" name="rname" value="{{ $rname }}">
    <input type="hidden" name="relatedid" value="{{ $relatedid }}">
    <input type="hidden" name="relatedtable" value="{{ $relatedtable }}">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-frame-title">{{ tw_lang('thinkwinds::public.basic.information')}}</div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="thinkwinds_name"  onBlur="tw_topinyin('fieldname', 'name');" value="{{ tw_value('name') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ tw_lang('thinkwinds::manage.fields.name.tips') }}">{{ tw_lang('thinkwinds::manage.fields.name.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('fieldname')) hstui-form-error @endif" id="J_form_error_fieldname">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.fields.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="fieldname" id="thinkwinds_fieldname" value="{{ tw_value('fieldname') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_fieldname" data-tips="{{ tw_lang('thinkwinds::manage.fields.namex.tips') }}">{{ tw_lang('thinkwinds::manage.fields.namex.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('vieworder')) hstui-form-error @endif" id="J_form_error_vieworder">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.fields.vieworder') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="vieworder" id="thinkwinds_vieworder" value="{{ tw_value('vieworder') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_vieworder" data-tips="{{ tw_lang('thinkwinds::manage.fields.vieworder.tips') }}">{{ tw_lang('thinkwinds::manage.fields.vieworder.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('issearch')) hstui-form-error @endif" id="J_form_error_issearch">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.fields.issearch') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="issearch" id="thinkwinds_issearch" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.no')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.yes')}}" data-hstui-switchx @if(old('issearch')) {{ tw_ifCheck(old('issearch')) }}@endif data-switchx-text="issearch"/>
            <div class="hstui-form-input-tips" id="J_form_tips_disabled" data-tips="{{ tw_lang('thinkwinds::manage.fields.issearch.tips') }}">{{ tw_lang('thinkwinds::manage.fields.issearch.tips') }}</div>
          </div>
        </div>

        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('disabled')) hstui-form-error @endif" id="J_form_error_disabled">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.status') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="disabled" id="thinkwinds_disabled" data-class="hstui-switchx-default hstui-round hstui-fl" data-switchx-offtext="{{ tw_lang('thinkwinds::public.closes')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.opens')}}" data-hstui-switchx @if(old('disabled')) {{ tw_ifCheck(old('disabled')) }} @else checked @endif data-switchx-text="disabled"/>
            <div class="hstui-form-input-tips" id="J_form_tips_disabled" data-tips="{{ tw_lang('thinkwinds::manage.fields.status.tips') }}">{{ tw_lang('thinkwinds::manage.fields.status.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('fieldtype')) hstui-form-error @endif" id="J_form_error_fieldtype">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.type') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <select class="hstui-input hstui-select" name="fieldtype" id="thinkwinds_fieldtype" style="" onChange="show_field_option(this.value)">
                <option value="">{{ tw_lang('thinkwinds::public.please.select') }}</option>
                @foreach($fieldTypes as $fieldType)
                <option value="{{ $fieldType['id'] }}">{{ $fieldType['name'] }}</option>
                @endforeach
              </select>
              <span id="tw_loading" style="display:none; font-size: 12px;margin-left: 10px; margin-top: 15px;">{{ tw_lang('thinkwinds::public.loading')}}</span>
            <div class="hstui-form-input-tips" id="J_form_tips_fieldtype" data-tips="{{ tw_lang('thinkwinds::manage.fields.type.tips') }}">{{ tw_lang('thinkwinds::manage.fields.type.tips') }}</div>
          </div>
        </div>
      </div>
      <div class="hstui-frame-content" id="tw_option"></div>
      <div class="hstui-frame-content">
        <div class="hstui-frame-title">{{ tw_lang('thinkwinds::manage.fields.validators') }}</div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isrequired')) hstui-form-error @endif" id="J_form_error_isrequired">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.isrequired') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <label><input type="radio" value="0" onClick="set_required(0)" name="setting[validate][required]" checked><span>否</span></label>
              <label><input type="radio" value="1" onClick="set_required(1)" name="setting[validate][required]"><span>是</span></label>
            <div class="hstui-form-input-tips" id="J_form_tips_isrequired" data-tips="{{ tw_lang('thinkwinds::manage.fields.isrequired.tips') }}">{{ tw_lang('thinkwinds::manage.fields.isrequired.tips') }}</div>
          </div>
        </div>
        <div id="required" class="hstui-form-group hstui-form-group-sm" style="display: none;" id="J_form_error_pattern">
          <div class="hstui-form-group hstui-form-group-sm" id="J_form_error_pattern">
            <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.fields.validator.pattern') }}</label>
            <div class="hstui-u-sm-10 hstui-form-input">
                <input type="text" name="setting[validate][pattern]" id="thinkwinds_pattern" value="" class="hstui-input hstui-length-3">
                <select class="hstui-select " style="height: 37px; margin-left: 5px;" onChange="set_pattern(this)" name="pattern_select">
                  <option value="">{{ tw_lang('thinkwinds::public.regular.verification') }}</option>
                  <option value="/^[0-9.-]+$/">{{ tw_lang('thinkwinds::public.number') }}</option>
                  <option value="/^[0-9-]+$/">{{ tw_lang('thinkwinds::public.integer') }}</option>
                  <option value="/^[a-z]+$/i">{{ tw_lang('thinkwinds::public.letters') }}</option>
                  <option value="/^[0-9a-z]+$/i">{{ tw_lang('thinkwinds::public.number') }}+{{ tw_lang('thinkwinds::public.letters') }}</option>
                  <option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
                  <option value="/^[0-9]{5,20}$/">QQ</option>
                  <option value="/^http:\/\//">URL</option>
                  <option value="/^(1)[0-9]{10}$/">{{ tw_lang('thinkwinds::public.mobile') }}</option>
                  <option value="/^[0-9-]{6,13}$/">{{ tw_lang('thinkwinds::public.phone') }}</option>
                  <option value="/^[0-9]{6}$/">{{ tw_lang('thinkwinds::public.postal.code') }}</option>
                  </select>
              <div class="hstui-form-input-tips" id="J_form_tips_pattern"></div>
            </div>
          </div>
          <div class="hstui-form-group hstui-form-group-sm" id="J_form_error_errortips">
            <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.fields.validator') }}</label>
            <div class="hstui-u-sm-10 hstui-form-input">
                <input type="text" name="setting[validate][errortips]" id="thinkwinds_errortips" value="" class="hstui-input hstui-length-5">
              <div class="hstui-form-input-tips" id="J_form_tips_errortips" data-tips="{{ tw_lang('thinkwinds::manage.fields.validator.tips') }}">{{ tw_lang('thinkwinds::manage.fields.validator.tips') }}</div>
            </div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm" id="J_form_error_v_tips">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.fields.tips') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="setting[validate][tips]" id="thinkwinds_v_tips" value="" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_v_tips" data-tips="{{ tw_lang('thinkwinds::manage.fields.tips.tips') }}">{{ tw_lang('thinkwinds::manage.fields.tips.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isedit')) hstui-form-error @endif" id="J_form_error_isedit">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.fields.isedit') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="isedit" id="thinkwinds_isedit" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.no')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.yes')}}" data-hstui-switchx @if(old('isedit')){{ tw_ifCheck(old('isedit')) }}@else @endif data-switchx-text="isedit"/>
            <div class="hstui-form-input-tips" id="J_form_tips_isedit" data-tips="{{ tw_lang('thinkwinds::manage.fields.isedit.tips') }}">{{ tw_lang('thinkwinds::manage.fields.isedit.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isfrontshow')) hstui-form-error @endif" id="J_form_error_isfrontshow">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.front.end') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="isfrontshow" id="thinkwinds_isfrontshow" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.no')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.yes')}}" data-hstui-switchx @if(old('isfrontshow')) {{ tw_ifCheck(old('isfrontshow')) }} @else checked @endif data-switchx-text="isfrontshow"/>
            <div class="hstui-form-input-tips" id="J_form_tips_isedit" data-tips="{{ tw_lang('thinkwinds::manage.fields.front.end.tips') }}">{{ tw_lang('thinkwinds::manage.fields.front.end.tips') }}</div>
          </div>
        </div>
      </div>
      <div class="hstui-frame-content">
        <div class="hstui-frame-title">{{ tw_lang('thinkwinds::manage.fields.show') }}</div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('ismshow')) hstui-form-error @endif" id="J_form_error_ismshow">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.fields.manage.content.list.show') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="ismshow" id="thinkwinds_ismshow" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.no')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.yes')}}" data-hstui-switchx @if(old('ismshow')) {{ tw_ifCheck(old('ismshow')) }}@endif data-switchx-text="ismshow"/>
            <div class="hstui-form-input-tips" id="J_form_tips_ismshow" data-tips="{{ tw_lang('thinkwinds::manage.fields.manage.content.list.show.tips') }}">{{ tw_lang('thinkwinds::manage.fields.manage.content.list.show.tips') }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="hstui-form-button">
       <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.save') }}</button>
    </div>    
  </form>
</div>
<script>
Hstui.use('jquery','common',function() {

});
function set_required(id) {
  if (id == 0) {
    $('#required').hide();
  } else {
    $('#required').show();
  }
}
function show_field_option(type) {
  $("#tw_loading").show();
  $.get('{!! route('manage.public.fields.type.html', ['id'=>0, 'relatedid'=>$relatedid, 'rname'=>$rname]) !!}&rand='+Math.random(),{ type:type}, function(data){
    $('#tw_option').html(data);
    $("#tw_loading").hide();
  });
}
function tw_topinyin(t, f) {
  $.get('{!! route('manage.public.topinyin') !!}?rand='+Math.random(),{ str:$("#thinkwinds_"+f).val()}, function(data){
    $('#thinkwinds_'+t).val(data);
  });
}
function set_pattern(o)
{
  $('#thinkwinds_pattern').val(o.value)
}
</script>
</body>
</html>