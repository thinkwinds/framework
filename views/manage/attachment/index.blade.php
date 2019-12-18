<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
<style>
.J_ul_list_public{
  width: 100%;
  overflow: hidden;
} 
.J_ul_list_public li{
  width: 100%;
  height: 40px;
  line-height: 40px;
}
.J_ul_list_public li input{
  margin-right: 10px
}
</style>
</head>
<body>
<div class="manage-content">
{!! $navs !!}
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.attachments.save') }}" method="post">
    {!! tw_csrf() !!} 
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm " id="J_form_error_name">
          <div class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.attach.storage') }}</div>
          <div class="hstui-u-sm-10 hstui-form-input">
              @foreach($storages as $key=>$val)
               <div class="hstui-u-sm-12">
                      <label class="blue mr10">
                        <input name="storage" value="{{ $key }}" type="radio"  {{ tw_ifCheck(tw_value('storage', $config) == $key) }} />
                        <span>{{ $val['name'] }} @if($val['manageurl'])<a href="{{ $val['manageurl'] }}" class=""  style="margin-left: 10px">[{{ tw_lang('thinkwinds::public.configure') }}]</a>@endif</span>
                      </label>
                  <div class="hstui-form-input-tips" data-tips="{!! $val['desc'] !!}">{!! $val['desc'] !!}</div>
                </div>
              @endforeach
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('dirs')) hstui-form-error @endif" id="J_form_error_codelength">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.storage.dirs') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input" style="margin-bottom: 10px;">
              <input type="text" name="dirs" id="thinkwinds_dirs" value="{!! tw_value('dirs', $config) !!}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" >{{ tw_lang('thinkwinds::manage.storage.dirs.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('dirs')) hstui-form-error @endif" id="J_form_error_codelength">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.storage.dirs') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input" style="margin-bottom: 10px;">
              <div>
                <ul id="J_ul_list_attachment" class="J_ul_list_public">
                <li>
                  <span class="span_3">{{ tw_lang('thinkwinds::manage.attachment.extsize.tips1') }}</span>
                  <span class="span_3">{{ tw_lang('thinkwinds::manage.attachment.extsize.tips2') }}</span>
                </li>
                @if(isset($config['extsize']))
                @foreach($config['extsize'] as $key=>$value)
                <li><input name="extsize[{!! $key !!}][ext]" type="text" class="hstui-input hstui-length-2" value="{!! $key !!}"><input name="extsize[{!! $key !!}][size]" type="text" class="hstui-input mr15 hstui-length-2"  value="{!! $value !!}"><a href="#" class="J_ul_list_remove">[{!! tw_lang('thinkwinds::public.delete') !!}]</a>
                </li>
                @endforeach
                @endif
              </ul>
              <a href="" class="link_add J_ul_list_add" data-related="attachment">{{ tw_lang('thinkwinds::manage.attachment.extsize.add') }}</a>
              </div>
            <div class="hstui-form-input-tips" data-tips="{{ tw_lang('thinkwinds::manage.attachment.extsize.tips') }}">{{ tw_lang('thinkwinds::manage.attachment.extsize.tips') }}<em style="color: red">{{ $maxSize }}</em></div>
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
var _li_html = '<li>\
          <input type="text" value="" class="hstui-input hstui-length-2" name="extsize[new_][ext]">\
            <input type="text" value="" class="hstui-input hstui-length-2 mr15" name="extsize[new_][size]"><a class="J_ul_list_remove" href="#">[{!! tw_lang('thinkwinds::public.delete') !!}]</a>\
        </li>';
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>