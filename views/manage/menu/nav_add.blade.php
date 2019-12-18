<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body style="width: 600px; height:355px">
<form method="post" class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.menu.navAddSave') }}">
    {{ tw_csrf() }}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('parent')) hstui-form-error @endif" id="J_form_error_parent">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.username') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
                <select class="hstui-length-4" name="parent" id="thinkwinds_parent">
                    <option value="0">{!! tw_lang('thinkwinds::public.top.level') !!}</option>
                    @foreach($menus as $k=>$v)
                        <option value="{!! $v['id'] !!}">{!! $v['name'] !!}</option>
                        @if(isset($v['items']) && $v['items'])
                        @foreach($v['items'] as $ks=>$vs)
                        <option value="{!! $vs['id'] !!}">  --{!! $vs['name'] !!}</option>
                        @endforeach
                        @endif
                    @endforeach
                </select>
            <div class="hstui-form-input-tips" id="J_form_tips_parent" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="thinkwinds_name" value="{{ tw_value('name') }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ tw_lang('thinkwinds::public.enter.one.name') }}">{{ tw_lang('thinkwinds::public.enter.one.name') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('ename')) hstui-form-error @endif" id="J_form_error_ename">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.ename') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="ename" id="thinkwinds_ename" value="{{ tw_value('ename') }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_ename" data-tips="{{ tw_lang('thinkwinds::public.enter.one.ename') }}">{{ tw_lang('thinkwinds::public.enter.one.ename') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('url')) hstui-form-error @endif" id="J_form_error_url">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.url') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="url" id="thinkwinds_url" value="{{ tw_value('url') }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_url" data-tips="{{ tw_lang('thinkwinds::public.enter.one.url') }}">{{ tw_lang('thinkwinds::public.enter.one.url') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('icon')) hstui-form-error @endif" id="J_form_error_icon">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.icon') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="icon" id="thinkwinds_icon" value="{{ tw_value('icon') }}" class="hstui-input hstui-length-4">
            <div class="hstui-form-input-tips" id="J_form_tips_icon" data-tips="{{ tw_lang('thinkwinds::public.enter.one.icon') }}">{{ tw_lang('thinkwinds::public.enter.one.icon') }}</div>
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