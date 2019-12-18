<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body style="width: 800px; height: 500px;">
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.form.addSave', ['module'=>$module, 'relatedid'=>$relatedid]) }}" method="post">
    {!! tw_csrf() !!}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.form.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input onBlur="tw_topinyin('table', 'name');" type="text" name="name" id="thinkwinds_name" value="{{ tw_value('name') }}" class="hstui-input hstui-length-3">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('table')) hstui-form-error @endif" id="J_form_error_table">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.form.table') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="table" id="thinkwinds_table" value="{{ tw_value('table') }}" class="hstui-input hstui-length-3">
            <div class="hstui-form-input-tips" id="J_form_tips_table" data-tips="{{ tw_lang('thinkwinds::manage.form.table.tips') }}">{{ tw_lang('thinkwinds::manage.form.table.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('mobile')) hstui-form-error @endif" id="J_form_error_mobile">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.form.mobile.notice') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="mobile" id="thinkwinds_mobile" value="" class="hstui-input hstui-length-3">
            <div class="hstui-form-input-tips" id="J_form_tips_email" data-tips="{!! tw_lang('thinkwinds::manage.form.mobile.notice.tips') !!}">{!! tw_lang('thinkwinds::manage.form.mobile.notice.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('email')) hstui-form-error @endif" id="J_form_error_email">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.form.email.notice') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="email" id="thinkwinds_email" value="" class="hstui-input hstui-length-3">
            <div class="hstui-form-input-tips" id="J_form_tips_email" data-tips="{!! tw_lang('thinkwinds::manage.form.email.notice.tips') !!}">{!! tw_lang('thinkwinds::manage.form.email.notice.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('emailcontent')) hstui-form-error @endif" id="J_form_error_emailcontent">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.form.email.content') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-textarea hstui-length-4" style="height: 120px" name="emailcontent" id="thinkwinds_emailcontent"></textarea>
            <div class="hstui-form-input-tips" id="J_form_tips_emailcontent" data-tips="{!! tw_lang('thinkwinds::manage.form.email.content.tips') !!}">{!! tw_lang('thinkwinds::manage.form.email.content.tips') !!}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="hstui-form-button">
        <button class="hstui-button " id="J_dialog_close">{{ tw_lang('thinkwinds::public.cancel')}}</button>
        <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.submit')}}</button>
    </div>
  </form>
<script>
Hstui.use('jquery','common',function() {
});
function tw_topinyin(t, f) {
  Hstui.Util.ajaxMaskShow();
  $.get('{!! route('manage.public.topinyin') !!}?rand='+Math.random(),{ str:$("#thinkwinds_"+f).val()}, function(data){
    $('#thinkwinds_'+t).val(data);
  Hstui.Util.ajaxMaskRemove();
  });
}
</script>
</body>
</html>