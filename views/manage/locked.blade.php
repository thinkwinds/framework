<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
<link rel="stylesheet" href="{{ tw_assets('manage/css/login.css') }}">
</head>
<body>
<div class="hstui-content">
  <div class="login-page">
    <div class="login-form">
      <img src="{{ tw_assets('manage/images/login-logo.png') }}" class="login-logo">
      <form class="hstui-form hstui-form-horizontal" action="{!! route('manage.index.unLocked') !!}" method="post">
      {!! tw_csrf() !!}
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('password')) hstui-form-error @endif">
          <div class="hstui-input-icon hstui-icon-lf @if($errors->has('password')) hstui-field-error @endif">
            <i class="hstui-icon hstui-icon-password"></i>
            <input type="test" onfocus="this.type='password'" class="hstui-input" id="passWord" name="password" value="{{ tw_value('username') }}" placeholder="{{ tw_lang('thinkwinds::public.enter.one.password')}}" />
          </div> 
        </div>
        <button type="submit" class="hstui-button hstui-button-primary hstui-button-block" data-button-content="{{ tw_lang('thinkwinds::public.unlocked.loading') }}">{{ tw_lang('thinkwinds::public.unlocked') }}</button>
        @if (count($errors) > 0)
        <div class="login-errors">
          <ul>
            @foreach ($errors->all() as $key => $error)
            <li><i class="hstui-icon hstui-icon-triangle-arrow-r"></i>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
      </form>
    </div>
  </div>
  <div class="copyRight">
    <p>&copy; 2014 - {{ tw_time2str(tw_time(), 'Y') }} thinkwinds.com Inc. All Rights Reserved.</p>
    <p>Powered by <a href="{{ config('thinkwinds.website') }}" target="_blank">{{ config('thinkwinds.name') }}</a> V{{ config('thinkwinds.version') }}</p>
  </div>
</div>
<script>
Hstui.use('jquery','common',function() {
  if(window.parent.location.href !== '{!! route('manage.index.locked') !!}') {
    window.parent.location.href = '{!! route('manage.index.locked') !!}';
  }
  $(".hstui-button").on('click',function() {
    Hstui.Util.ajaxBtnDisable($(this));
    $(".hstui-form").submit();
  })
});
</script>
</body>
</html>