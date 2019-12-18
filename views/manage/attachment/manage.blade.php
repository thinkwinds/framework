<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
<style>
.hstui-attach-list{
    width: 100%;
    overflow: hidden;
    border: 1px solid #ddd;
    min-height: 600px;
}
.hstui-attach-list ul{
    padding: 5px;
}
.hstui-attach-list ul li{
    /*width: 200px;*/
    height: 200px;
    float: left;
    border: 1px solid #ddd;
    margin-right: 10px;
    margin-bottom: 10px;
    text-align:center;
    /*padding: 2px;*/
    line-height: 198px;
    position: relative;
}
.hstui-attach-list ul li img{
    width: 100%;
    max-width: 198px;
    /*max-height: 198px;*/
    max-height: 200px;
    overflow: hidden;
}
.hstui-attach-list ul li .J_dialog>i{
    font-size: 30px;
}
.hstui-attach-list ul li .view {
    position: absolute;
    top: 10px;
    right: 10px;
    line-height: initial;
    width: 30px;
    height: 30px;
    line-height: 30px;
     border-radius: 50%;
    border: 1px solid #ddd;
}
</style>
</head>
<body>
<div class="manage-content">
{!! $navs !!}
    <div class="manage-search">
        <form action="{{ route('manage.attachments.manage') }}" method="get">
            <input type="hidden" name="type" value="{{ $args['type'] }}">
            <input class="hstui-input hstui-length-2" id="search-aid" name="aid" value="{!! tw_value('aid', $args) !!}" placeholder="AID" />
            <input class="hstui-input hstui-length-2" id="search-uid" name="uid" value="{!! tw_value('uid', $args) !!}" placeholder="UID" />
            <input class="hstui-input hstui-length-3" id="search-name" name="name" value="{!! tw_value('name', $args) !!}" placeholder="{!! tw_lang('thinkwinds::public.name') !!}" />
            <input class="hstui-input hstui-length-2" id="search-app" name="app" value="{!! tw_value('app', $args) !!}" placeholder="APP" />
            <input class="hstui-input hstui-length-2" id="search-appid" name="appid" value="{!! tw_value('appid', $args) !!}" placeholder="APPID" />
            <!-- <input class="hstui-input hstui-length-3 J_datetime" name="stime" value="{!! tw_value('stime', $args) !!}" id="search-stime" placeholder="{!! tw_lang('thinkwinds::public.stime') !!}" /> -->
            <!-- <input class="hstui-input hstui-length-3 J_datetime" name="etime" value="{!! tw_value('etime', $args) !!}" id="search-etime" placeholder="{!! tw_lang('thinkwinds::public.etime') !!}" /> -->
            <button type="submit" class="hstui-button hstui-button-default hstui-button-xs J_search">{{ tw_lang('thinkwinds::public.search') }}</button>
            <div class="hstui-fr">
                <a href="{{ route('manage.attachments.manage', ['type'=>1]) }}" style="margin-right: 10px;"><i class="hstui-icon hstui-icon-class"></i></a>
                <a href="{{ route('manage.attachments.manage', ['type'=>0]) }}"><i class="hstui-icon hstui-icon-list1" style="font-size: 20px;"></i></a>
            </div>
        </form>
    </div>
<div class="table-main">
    @if(!$type)
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="80" >{{ tw_lang('AID') }}</th>
                <th width="80" >{{ tw_lang('UID') }}</th>
                <th width="80" >{{ tw_lang('APP') }}</th>
                <th width="80" >{{ tw_lang('APPID') }}</th>
                <th width="20%" >{{ tw_lang('thinkwinds::public.name') }}</th>
                <th >{{ tw_lang('thinkwinds::public.type') }}</th>
                <th >{{ tw_lang('thinkwinds::public.size') }}</th>
                <th >{{ tw_lang('thinkwinds::public.times') }}</th>
                <th width="10%" >{{ tw_lang('thinkwinds::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(count($list))
            @foreach($list as $v)
            <tr>
                <td>{!! $v['aid'] !!}</td>
                <td>{!! $v['created_userid'] !!}</td>
                <td>{!! $v['app'] !!}</td>
                <td>@if($v['appid']){!! $v['appid'] !!}@else - @endif</td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['type'] !!}</td>
                <td>{!! tw_byte_format($v['size']) !!}</td>
                <td>{!! tw_time2str($v['created_time']) !!}</td>
                <td>
                   <a class="J_dialog" title="{{ tw_lang('thinkwinds::public.view') }}" href="{{ route('manage.attachments.view', ['aid'=>$v['aid']]) }}">{{ tw_lang('thinkwinds::public.view') }}</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="9">{!! tw_lang('thinkwinds::public.no.list') !!}</td>
            </tr>
            @endif
        </tbody>
    </table>
    @else
        <div class="hstui-attach-list">
            <ul>
            @if(count($list))
            @foreach($list as $v)
                <li class="J_tooltips" data-tooltips-content="{{$v['name']}}</br>{!! tw_byte_format($v['size']) !!}">
                    @if(in_array($v['type'], ['jpeg', 'jpg', 'png', 'gif']))
                    <a href="{{ $v['url'] }}" target="_b" class="view"><i class="hstui-icon hstui-icon-eye"></i></a>
                    @endif
                   <a class="J_dialog" title="{{ tw_lang('thinkwinds::public.view') }}" href="{{ route('manage.attachments.view', ['aid'=>$v['aid']]) }}"> 
                    @if(in_array($v['type'], ['jpeg', 'jpg', 'png', 'gif']))
                    <img src="{{ $v['url'] }}">
                    @endif
                    @if($v['type'] == 'zip')
                        <i class="hstui-icon hstui-icon-zip"></i>
                    @endif
                    @if($v['type'] == 'pdf')
                        <i class="hstui-icon hstui-icon-pdf"></i>
                    @endif
                    @if($v['type'] == 'exl')
                        <i class="hstui-icon hstui-icon-exl"></i>
                    @endif
                    </a>
                </li>
            @endforeach
            @else

            @endif
            </ul>
        </div>
    @endif
    <div class="table-footer"><div class="J_listPage hstui-fr">{!! $list->appends($args)->links() !!}</div></div>
</div>
</div>
<script>
Hstui.use('jquery','common',function() {
  initHw(function(h){
  });
});

window.onresize = function(){
  initHw(function(h){
  });
}
function initHw(c){
  var lh = $('.hstui-attach-list').height();
  var lw = $('.hstui-attach-list').width();
  $('.hstui-attach-list ul li').width((lw - 40 - 40)/5);
  $('.hstui-attach-list ul li img').css('max-width', (lw - 40 - 40)/5);
  for (var i = 1; i <= $('.hstui-attach-list ul li').length; i++) {
      if(i%5 == 0) {
        $('.hstui-attach-list ul li').eq(i-1).css('margin-right', '0px');
      }
  }
  if(c){
    c(lh);
  }
}
</script>
</body>
</html>