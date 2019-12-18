<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body style="width:690px; height: 330px">
<form method="post" class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.widget.addSave') }}">
    {{ tw_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label"><font color="red">*</font>{{ tw_lang('thinkwinds::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="thinkwinds_name" value="{{ tw_value('name') }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ tw_lang('thinkwinds::public.enter.one.name') }}">{{ tw_lang('thinkwinds::public.enter.one.name') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('description')) hstui-form-error @endif" id="J_form_error_description">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.description') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="description" id="thinkwinds_description" value="{{ tw_value('description') }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_description" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('document')) hstui-form-error @endif" id="J_form_error_document">
          <label class="hstui-u-sm-2 hstui-form-label"><font color="red">*</font>{{ tw_lang('thinkwinds::widget.document') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
                <textarea name="document" id="thinkwinds_document" class="hstui-input hstui-textarea hstui-length-4" placeholder="" style="height: 120px">{{ tw_value('document') }}</textarea>
            <div class="hstui-form-input-tips" id="J_form_tips_document" data-tips=""></div>
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