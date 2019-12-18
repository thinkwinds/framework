<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal" action="{{ route('manage.call.block.add', ['step'=>2]) }}" method="post">
    {!! tw_csrf() !!} 
    <div class="hstui-frame">
      	<div class="hstui-frame-content">
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('type')) hstui-form-error @endif" id="J_form_error_type">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.call.type.select') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <select name="type" id="thinkwinds_type" class="hstui-input hstui-length-2">
                    <option value="">{{ tw_lang('thinkwinds::manage.call.type.select') }}</option>
                    @foreach($types as $key=>$val)
                    <option value="{{ $key }}">{{ $val['name'] }}</option>
                    @endforeach
                </select>
	            <div class="hstui-form-input-tips" id="J_form_tips_type"></div>
	          </div>
	        </div>
      	</div>
    </div>    
    <div class="hstui-form-button">
       <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.next.submit') }}</button>
    </div>
  </form>
</div>
<script>
Hstui.use('jquery','common',function() {
	
});
</script>
</body>
</html>