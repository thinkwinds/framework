<!DOCTYPE html>
<html>
<head>
@include('thinkwinds::common.head')
</head>
<body>
<form  class="J_ajaxForm" method="post" action="{{ route('thinwinds.form.content.save') }}" enctype="multipart/form-data">
    {!! tw_csrf() !!} 
	<input type="hidden" name="formid" value="{{ $formid }}">
	{!! $inputHtml !!}
    <button type="submit" class="hstui-button hstui-button-default J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.submit') }}</button>
</form>
<script>
Hstui.use('jquery','common',function() {

});	
</script>
</body>
</html>