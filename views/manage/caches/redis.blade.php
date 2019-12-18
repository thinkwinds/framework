<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.caches.redisConfigSave') }}" method="post">
    {!! tw_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('host')) hstui-form-error @endif" id="J_form_error_host">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.host') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="host" id="thinkwinds_memdhost" value="{{ tw_value('redishost', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_host"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('port')) hstui-form-error @endif" id="J_form_error_port">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.port') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="port" id="thinkwinds_port" value="{{ tw_value('redisport', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_port"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('password')) hstui-form-error @endif" id="J_form_error_password">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.password') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="password" id="thinkwinds_password" value="{{ tw_value('redispassword', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_password"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="hstui-form-button">
       <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.submit') }}</button>
    </div>
  </form>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>