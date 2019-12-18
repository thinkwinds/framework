<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body style="width: 600px; height:365px">
<form method="post" class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.menu.roleEditSave') }}">
<input type="hidden" name="id" value="{!! $id !!}" id="thinkwinds_id">
    {{ tw_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="thinkwinds_name" value="{{ tw_value('name', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ tw_lang('thinkwinds::public.enter.one.name') }}">{{ tw_lang('thinkwinds::public.enter.one.name') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('ename')) hstui-form-error @endif" id="J_form_error_ename">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.ename') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="ename" id="thinkwinds_ename" value="{{ tw_value('ename', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_ename" data-tips="{{ tw_lang('thinkwinds::public.enter.one.ename') }}">{{ tw_lang('thinkwinds::public.enter.one.ename') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('uri')) hstui-form-error @endif" id="J_form_error_uri">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.uri') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="uri" id="thinkwinds_uri" value="{{ tw_value('uri', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_uri" data-tips="{{ tw_lang('thinkwinds::public.enter.one.uri') }}">{{ tw_lang('thinkwinds::public.enter.one.uri') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('parent')) hstui-form-error @endif" id="J_form_error_parent">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.ascription') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="parent" id="thinkwinds_parent" value="{{ tw_value('parent', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_parent" data-tips="{{ tw_lang('thinkwinds::public.enter.one.ascription') }}">{{ tw_lang('thinkwinds::public.enter.one.ascription') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('remark')) hstui-form-error @endif" id="J_form_error_remark">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.remark') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="remark" id="thinkwinds_remark" value="{{ tw_value('remark', $info) }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_remark" data-tips=""></div>
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
</script>
</body>
</html>