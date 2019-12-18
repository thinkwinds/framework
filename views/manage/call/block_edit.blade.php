<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.call.block.edit.save') }}" method="post">
    {!! tw_csrf() !!}
    <input type="hidden" name="id" value="{{ $id }}">
    <input type="hidden" name="type" value="{{ $info['type'] }}">
    <input type="hidden" name="module" value="{{ $info['module'] }}">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="thinkwinds_host" value="{{ tw_value('name', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name"></div>
          </div>
        </div>
          @include('thinkwinds::manage.call.configure')
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