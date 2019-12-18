<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<form method="post" class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.user.editSave') }}">
    <input type="hidden" name="uid" value="{{ $uid }}">
    {{ tw_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('gid')) hstui-form-error @endif" id="J_form_error_gid">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.role') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
                <select name="gid" id="thinkwinds_gid" class="hstui-length-2">
                    <option value="">{{ tw_lang('thinkwinds::manage.select.role') }}</option>
                    @foreach($roles as $key=>$val)
                    <option value="{{ $val['id'] }}" {!! tw_isSelected($val['id'] == $info['gid']) !!}>{{ $val['name'] }}</option>
                    @endforeach
                </select>
            <div class="hstui-form-input-tips" id="J_form_tips_width" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('username')) hstui-form-error @endif" id="J_form_error_username">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.username') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="username" id="thinkwinds_username" value="{{ tw_value('username', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_username" data-tips="{{ tw_lang('thinkwinds::public.enter.one.username') }}">{{ tw_lang('thinkwinds::public.enter.one.username') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('password')) hstui-form-error @endif" id="J_form_error_password">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.password') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="password" id="thinkwinds_password" value="{{ tw_value('password') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_password" data-tips="{{ tw_lang('thinkwinds::public.enter.one.password') }}">{{ tw_lang('thinkwinds::public.enter.one.password') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.realname') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="thinkwinds_name" value="{{ tw_value('name', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ tw_lang('thinkwinds::public.enter.one.realname') }}">{{ tw_lang('thinkwinds::public.enter.one.realname') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('mobile')) hstui-form-error @endif" id="J_form_error_mobile">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.mobile') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="mobile" id="thinkwinds_mobile" value="{{ tw_value('mobile', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_mobile" data-tips="{{ tw_lang('thinkwinds::public.enter.one.mobile') }}">{{ tw_lang('thinkwinds::public.enter.one.mobile') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('email')) hstui-form-error @endif" id="J_form_error_email">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.email') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="email" id="thinkwinds_email" value="{{ tw_value('email', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_mobile" data-tips="{{ tw_lang('thinkwinds::public.enter.one.email') }}">{{ tw_lang('thinkwinds::public.enter.one.email') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('qq')) hstui-form-error @endif" id="J_form_error_qq">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('QQ') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="qq" id="thinkwinds_qq" value="{{ tw_value('qq', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_qq" data-tips="{{ tw_lang('thinkwinds::public.enter.one.qq') }}">{{ tw_lang('thinkwinds::public.enter.one.qq') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('weixin')) hstui-form-error @endif" id="J_form_error_weixin">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.weixin') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="weixin" id="thinkwinds_weixin" value="{{ tw_value('weixin', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_weixin" data-tips="{{ tw_lang('thinkwinds::public.enter.one.weixin') }}">{{ tw_lang('thinkwinds::public.enter.one.weixin') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('status')) hstui-form-error @endif" id="J_form_error_status">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.status') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
            <input type="checkbox" name="status" id="thinkwinds_status" data-class="hstui-switchx-default hstui-round hstui-mr-lg" data-switchx-offtext="{{ tw_lang('thinkwinds::public.disable')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.enable')}}" data-hstui-switchx {{ tw_ifCheck(!$info['status']) }} data-switchx-text="status"/>
            <div class="hstui-form-input-tips" id="J_form_tips_status" data-tips=""></div>
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