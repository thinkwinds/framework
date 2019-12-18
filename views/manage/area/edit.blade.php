<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body style="width: 700px; height: 500px;">
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.area.editSave') }}" method="post">
    {!! tw_csrf() !!}
    <input type="hidden" name="areaid" value="{{$areaid}}">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('areaid')) hstui-form-error @endif" id="J_form_error_areaid">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('Areaid') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" readonly name="areaid" id="thinkwinds_areaid" value="{{ tw_value('areaid', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_areaid" data-tips="{{ tw_lang('thinkwinds::manage.area.areaid') }}">{{ tw_lang('thinkwinds::manage.area.areaid') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="thinkwinds_name" value="{{ tw_value('name', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('zip')) hstui-form-error @endif" id="J_form_error_zip">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.area.zip') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="zip" id="thinkwinds_zip" value="{{ tw_value('zip', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_zip" data-tips=""></div>
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
Hstui.use('jquery','common', function() {
});
</script>
</body>
</html>