<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.config.email.save') }}" method="post">
    {!! tw_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('host')) hstui-form-error @endif" id="J_form_error_host">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.email.host') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="host" id="thinkwinds_host" value="@if($errors->has('host')){!! old('host') !!}@else{!! $config['host'] !!}@endif" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_host"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('port')) hstui-form-error @endif" id="J_form_error_port">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.email.port') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="port" id="thinkwinds_port" value="@if($errors->has('port')){!! old('port') !!}@else{!! $config['port'] !!}@endif" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_port"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('from')) hstui-form-error @endif" id="J_form_error_from">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.email.from') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="from" id="thinkwinds_from" value="@if($errors->has('port')){!! old('from') !!}@else{!! $config['from'] !!}@endif" class="hstui-input hstui-length-5 J_email_match">
            <div class="hstui-form-input-tips" id="J_form_tips_from"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('fromName')) hstui-form-error @endif" id="J_form_error_fromName">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.email.from.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="fromName" id="thinkwinds_fromName" value="@if($errors->has('fromName')){!! old('fromName') !!}@else{!! $config['from.name'] !!}@endif" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_fromName"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('auth')) hstui-form-error @endif" id="J_form_error_auth">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.email.auth') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="auth" id="thinkwinds_auth" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.close')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.open')}}" data-hstui-switchx @if(old('auth')) {{ tw_ifCheck(old('auth')) }} @else {{ tw_ifCheck($config['auth']) }} @endif data-switchx-text="auth"/>
            <div class="hstui-form-input-tips" id="J_form_tips_auth" data-tips="{{ tw_lang('thinkwinds::manage.email.auth.tips') }}">{{ tw_lang('thinkwinds::manage.email.auth.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('user')) hstui-form-error @endif" id="J_form_error_user">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.username') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="user" id="thinkwinds_user" value="@if($errors->has('user')){!! old('user') !!}@else{!! $config['user'] !!}@endif" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_user"></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('password')) hstui-form-error @endif" id="J_form_error_password">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.password') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="password" id="thinkwinds_password" value="@if($errors->has('password')){!! old('password') !!}@else{!! $config['password'] !!}@endif" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_password"></div>
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