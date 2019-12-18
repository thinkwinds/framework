<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.caches.memcachedConfigSave') }}" method="post">
    {!! tw_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdpsid')) hstui-form-error @endif" id="J_form_error_memdpsid">
          <label class="hstui-u-sm-2 hstui-form-label">persistent_id</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdpsid" id="thinkwinds_memdpsid" value="{{ tw_value('memdpsid', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdpsid"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdhost')) hstui-form-error @endif" id="J_form_error_memdhost">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.host') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdhost" id="thinkwinds_memdhost" value="{{ tw_value('memdhost', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdhost"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdport')) hstui-form-error @endif" id="J_form_error_memdport">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.port') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdport" id="thinkwinds_memdport" value="{{ tw_value('memdport', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdport"></div>
          </div>
        </div>

        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdusername')) hstui-form-error @endif" id="J_form_error_memdusername">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.username') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdusername" id="thinkwinds_memdusername" value="{{ tw_value('memdusername', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdusername"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('memdpassword')) hstui-form-error @endif" id="J_form_error_memdpassword">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.password') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="memdpassword" id="thinkwinds_memdpassword" value="{{ tw_value('memdpassword', $config) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_memdpassword"></div>
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