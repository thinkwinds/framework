<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.safe.save') }}" method="post">
    {!! tw_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-title">{{ tw_lang('thinkwinds::manage.safe.setting') }}</div>
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('request')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.request.log') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="request" id="thinkwinds_request" data-class="hstui-switchx-default hstui-round hstui-fl" data-switchx-offtext="{{ tw_lang('thinkwinds::public.close')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.open')}}" data-hstui-switchx @if(old('request')) {{ tw_ifCheck(old('request')) }} @else {{ tw_ifCheck($config['manage.request']) }} @endif data-switchx-text="safeRequest"/>
            <div class="hstui-form-input-tips" id="J_form_tips_safeRequest"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('operation')) hstui-form-error @endif" id="J_form_error_operation">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.operation.log') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="operation" id="thinkwinds_operation" data-class="hstui-switchx-default hstui-round hstui-fl" data-switchx-offtext="{{ tw_lang('thinkwinds::public.close')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.open')}}" data-hstui-switchx @if(old('operation')) {{ tw_ifCheck(old('operation')) }} @else {{ tw_ifCheck($config['manage.operation']) }} @endif data-switchx-text="operation"/>
            <div class="hstui-form-input-tips" id="J_form_tips_operation"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('loginCtime')) hstui-form-error @endif" id="J_form_error_operation">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.safe.login.ctime') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="loginCtime" id="thinkwinds_loginCtime" value="@if($errors->has('loginCtime')){!! old('loginCtime') !!}@else{!! $config['manage.login.ctime'] !!}@endif" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_loginCtime" data-tips="{{ tw_lang('thinkwinds::public.minute') }}，{{ tw_lang('thinkwinds::public.default') }}30{{ tw_lang('thinkwinds::public.minute') }}">{{ tw_lang('thinkwinds::public.minute') }}，{{ tw_lang('thinkwinds::public.default') }}30{{ tw_lang('thinkwinds::public.minute') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('safeIps')) hstui-form-error @endif" id="J_form_error_operation">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.safe.login.ips') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea name="safeIps" id="thinkwinds_safeIps" class="hstui-input hstui-textarea hstui-length-4" style="height: 160px;">@if($errors->has('safeIps')){!! old('safeIps') !!}@else{!! $config['manage.login.ips'] !!}@endif</textarea>
            <div class="hstui-form-input-tips" id="J_form_tips_safeIps" data-tips="{!! tw_lang('thinkwinds::manage.safe.login.ips.tips') !!}">{!! tw_lang('thinkwinds::manage.safe.login.ips.tips') !!}</div>
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