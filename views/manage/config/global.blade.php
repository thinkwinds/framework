<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
  {!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.config.globalsSave') }}" method="post">
    {!! tw_csrf() !!} 
    <div class="hstui-frame">
      	<div class="hstui-frame-content">
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('url')) hstui-form-error @endif" id="J_form_error_url">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.site.url') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="url" id="thinkwinds_url" value="@if($errors->has('url')){!! old('url') !!}@else{!! @$config['url'] !!}@endif" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_url" data-tips="{{ tw_lang('thinkwinds::manage.site.url.tips') }}">{{ tw_lang('thinkwinds::manage.site.url.tips') }}</div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('timezone')) hstui-form-error @endif" id="J_form_error_timezone">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.default.timezone') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="timezone" id="thinkwinds_timezone" value="{{ tw_value('timezone', $config) }}" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_timezone"></div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('timecv')) hstui-form-error @endif" id="J_form_error_timecv">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.timecv') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="text" name="timecv" id="thinkwinds_timecv" value="{{ tw_value('timecv', $config) }}" class="hstui-input hstui-length-5">
	            <div class="hstui-form-input-tips" id="J_form_tips_timecv" data-tips="{{ tw_lang('thinkwinds::manage.timecv.tips') }}">{{ tw_lang('thinkwinds::manage.timecv.tips') }}</div>
	          </div>
	        </div>
	        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('debug')) hstui-form-error @endif" id="J_form_error_debug">
	          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.debug') }}</label>
	          <div class="hstui-u-sm-10 hstui-form-input">
	              <input type="checkbox" name="debug" id="thinkwinds_debug" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.close')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.open')}}" data-hstui-switchx @if(old('debug')) {{ tw_ifCheck(old('debug')) }} @else {{ tw_ifCheck($config['debug']) }} @endif data-switchx-text="debug"/>
	            <div class="hstui-form-input-tips" id="J_form_tips_debug" data-tips="{{ tw_lang('thinkwinds::manage.debug.tips') }}">{!! tw_lang('thinkwinds::manage.debug.tips') !!}</div>
	          </div>
	        </div>
      	</div>
    </div>
    <div class="hstui-form-button">
       <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.submit') }}</button>
    </div>
  </form>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>