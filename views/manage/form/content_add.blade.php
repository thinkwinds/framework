<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.form.contentAddSave', ['formid'=>$id]) }}" method="post">
    {!! tw_csrf() !!}
    <input type="hidden" name="formid" value="{{ $id }}">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        {!! $inputHtml !!}
      </div>
    </div>
    <div class="hstui-form-button">
        <button class="hstui-button " id="J_dialog_close">{{ tw_lang('thinkwinds::public.cancel')}}</button>
        <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.submit')}}</button>
    </div>
  </form>
</div>
<script>
Hstui.use('jquery','common',function() {
});
function set_required(id) {
  if (id == 0) {
    $('#required').hide();
  } else {
    $('#required').show();
  }
}
function show_field_option(type) {
  $("#tw_loading").show();
  $.get('{!! route('manage.public.fields.type.html', ['id'=>0]) !!}&rand='+Math.random(),{ type:type}, function(data){
    $('#tw_option').html(data);
    $("#tw_loading").hide();
  });
}
function tw_topinyin(t, f) {
  $.get('{!! route('manage.public.topinyin') !!}?rand='+Math.random(),{ str:$("#thinkwinds_"+f).val()}, function(data){
    $('#thinkwinds_'+t).val(data);
  });
}
</script>
</body>
</html>