<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
  <div class="manage-search">
        <form action="{{ route('manage.form.content', ['formid'=>$formid]) }}" method="get">
        <input class="hstui-input hstui-length-1" id="search-uid" name="uid" value="{!! tw_value('uid', $args) !!}" placeholder="UID" />
        <input class="hstui-input hstui-length-3 J_datetime" name="stime" value="{!! tw_value('stime', $args) !!}" id="search-stime" placeholder="{!! tw_lang('thinkwinds::public.stime') !!}" />
        <input class="hstui-input hstui-length-3 J_datetime" name="etime" value="{!! tw_value('etime', $args) !!}" id="search-etime" placeholder="{!! tw_lang('thinkwinds::public.etime') !!}" />
        <button type="submit" class="hstui-button hstui-button-default hstui-button-xs J_search">{{ tw_lang('thinkwinds::public.search') }}</button>
        </form>
    </div>
<div class="table-main">
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="50" >{{ tw_lang('ID') }}</th>
                <th width="60" >{{ tw_lang('UID') }}</th>
                <th width="160">{{ tw_lang('thinkwinds::public.times') }}</th>
                @foreach($showFields as $key=>$field)
                <th width="">{{ $field['name'] }}</th>
                @endforeach
                <th width="120" >{{ tw_lang('thinkwinds::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(count($list))
            @foreach($list as $v)
            <tr>
                <td>{!! $v['id'] !!}</td>
                <td>{!! (int)$v['created_uid'] !!}</td>
                <td>{!! tw_time2str($v['created_time'], 'Y-m-d H:i:s') !!}</td>
                @foreach($showFields as $key=>$field)
                <td>@if(isset($v[$field['fieldname'].'_str'])){{$v[$field['fieldname'].'_str']}}@else{{ @$v[$field['fieldname']] }}@endif</td>
                @endforeach
                <td>
                    <a href="{{ route('manage.form.contentDelete', ['formid'=>$formid, 'id'=>$v['id']]) }}" class="J_ajax_del"  style="margin-right: 5px;">{{ tw_lang('thinkwinds::public.delete') }}</a>
                    <a href="{{ route('manage.form.contentEdit', ['formid'=>$formid, 'id'=>$v['id']]) }}" style="margin-right: 5px;">{{ tw_lang('thinkwinds::public.edit') }}</a>                    
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4">{!! tw_lang('thinkwinds::public.no.list') !!}</td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="table-footer"><div class="J_listPage hstui-fr">{!! $list->appends($args)->links() !!}</div></div>
</div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>