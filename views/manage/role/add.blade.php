<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
<form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.role.addSave') }}" method="post">
  {!! tw_csrf() !!} 
  <div class="hstui-frame">
    <div class="hstui-frame-title">{!! tw_lang('thinkwinds::public.add', 'thinkwinds::public.role') !!}</div>
    <div class="hstui-frame-content">
      <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
        <label class="hstui-u-sm-2 hstui-form-label">{!! tw_lang('thinkwinds::manage.role.name') !!}</label>
        <div class="hstui-u-sm-10 hstui-form-input">
          <input type="text" name="name" id="thinkwinds_name" value="{{ tw_value('name') }}" class="hstui-input hstui-length-3" placeholder="">
          <span class="hstui-form-input-tips" id="J_form_tips_name" data-tips="{{ tw_lang('thinkwinds::manage.enter.one.role.name') }}">{{ tw_lang('thinkwinds::manage.enter.one.role.name') }}</span>
        </div>
      </div>
      <div class="hstui-form-group hstui-form-group-sm">
        <div class="hstui-tab J_tab_wrap">
          <div class="hstui-tab-nav">
            <ul class="cc J_tabs_nav">
              @foreach($menus as $key=>$menu)
              <li>
                <a href="javascript:;">{!! $menu['name'] !!}</a>
              </li>
              @endforeach
            </ul>
          </div>
          <div class="J_tabs_content hstui-tab-content">
              @foreach($menus as $key=>$menu)
              <div class="p10 J_tabs_content_item">
                @if($menu['items'])
                   @foreach($menu['items'] as $k=>$v)  
                  <div class="hstui-form-group hstui-form-group-sm">
                    <label class="hstui-u-sm-2 hstui-form-label">{!! $v['name'] !!}</label>
                    <div class="hstui-u-sm-10">
                      @if(isset($v['url']) && $v['url'])
                        @if(isset($roleUriDatas[$v['id']]) && count($roleUriDatas[$v['id']]) > 0)
                          @foreach($roleUriDatas[$v['id']] as $r=>$rv)
                            <input name="auths[]" type="checkbox" value="{!! $rv['ename'] !!}"> {!! $rv['name'] !!}
                          @endforeach
                        @endif
                      @endif
                      @if(isset($v['items']) && $v['items'])
                      @foreach($v['items'] as $ks=>$vs) 
                      <div class="hstui-form-group hstui-form-group-sm">
                        <label for="doc-ipt-3-1" class="hstui-u-sm-2 hstui-form-label">{!! $vs['name'] !!}</label>
                        <div class="hstui-u-sm-10">
                            @if(isset($vs['url']) && $vs['url'])
                              @if(isset($roleUriDatas[$vs['id']]) && count($roleUriDatas[$vs['id']]) > 0)
                              @foreach($roleUriDatas[$vs['id']] as $rs=>$rsv)
                                <label><input name="auths[]" type="checkbox" value="{!! $rsv['ename'] !!}"> {!! $rsv['name'] !!}</label>
                              @endforeach
                              @endif
                            @endif
                        </div>
                      </div>
                      @endforeach
                      @endif
                    </div>
                  </div>
                  @endforeach
                @endif
              </div>
              @endforeach
          </div>
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
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>