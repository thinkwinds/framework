<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.form.contentEditSave', ['formid'=>$formid, 'id'=>$id]) }}" method="post">
    {!! tw_csrf() !!}
    <input type="hidden" name="formid" value="{{ $formid }}">
    <input type="hidden" name="id" value="{{ $id }}">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('created_uid')) hstui-form-error @endif" id="J_form_error_created_uid">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('UID') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="created_uid" readonly id="thinkwinds_created_uid"  value="{{ tw_value('created_uid', $infos) }}" class="hstui-input hstui-length-5 ">
            <div class="hstui-form-input-tips" id="J_form_tips_created_uid"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('created_time')) hstui-form-error @endif" id="J_form_error_created_time">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.add') }}{{ tw_lang('thinkwinds::public.times') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="created_time" readonly id="thinkwinds_created_time"  value="{{ tw_time2str(tw_value('created_time', $infos), 'Y-m-d H:i') }}" class="hstui-input hstui-length-5 ">
            <div class="hstui-form-input-tips" id="J_form_tips_created_time"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('created_ip')) hstui-form-error @endif" id="J_form_error_created_ip">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('IP') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="created_ip" readonly id="thinkwinds_created_ip"  value="{{ tw_value('created_ip', $infos) }}" class="hstui-length-2 " style="margin-right: 5px;">
              <input type="text" name="created_port" readonly id="thinkwinds_created_port"  value="{{ tw_value('created_port', $infos) }}" class="hstui-input hstui-length-2 ">
            <div class="hstui-form-input-tips" id="J_form_tips_created_ip"></div>
          </div>
        </div>
        {!! $inputHtml !!}
      </div>
    </div>
    <div class="hstui-form-button">
        <button class="hstui-button " id="J_dialog_close">{{ tw_lang('thinkwinds::public.cancel')}}</button>
        <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.submit')}}</button>
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
  $.get('{!! route('manage.public.fields.type.html', ['id'=>0]) !!}&rand='+Math.random(),{ type:type}, function(data){
    $('#tw_option').html(data);
    $("#tw_loading").hide();
  });
}
function tw_topinyin(t, f) {
  $.get('{!! route('manage.public.topinyin') !!}?rand='+Math.random(),{ str:$("#thinkwinds_"+f).val()}, function(data){
    $('#thinkwinds_'+t).val(data);
  });
}
</script>
</body>
</html>