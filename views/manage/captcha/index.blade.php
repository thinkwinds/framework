<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.captcha.save') }}" method="post">
    {!! tw_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('width')) hstui-form-error @endif" id="J_form_error_width">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.width') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="width" id="thinkwinds_width" value="{!! tw_value('width', $config) !!}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_width" data-tips="{!! tw_lang('thinkwinds::captcha.default.width') !!}">{!! tw_lang('thinkwinds::captcha.default.width') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('height')) hstui-form-error @endif" id="J_form_error_height">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.height') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="height" id="thinkwinds_height" value="{!! tw_value('height', $config) !!}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_height" data-tips="{!! tw_lang('thinkwinds::captcha.default.height') !!}">{!! tw_lang('thinkwinds::captcha.default.height') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('length')) hstui-form-error @endif" id="J_form_error_length">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.length') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="length" id="thinkwinds_length" value="{!! tw_value('length', $config) !!}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_length" data-tips="{!! tw_lang('thinkwinds::captcha.default.length') !!}">{!! tw_lang('thinkwinds::captcha.default.length') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm" id="J_form_error_preview">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.preview') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <img src="{!! route('captcha.index.get') !!}">
            <div class="hstui-form-input-tips" id="J_form_tips_preview"></div>
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
</script>
</body>
</html>