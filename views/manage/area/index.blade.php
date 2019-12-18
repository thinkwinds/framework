<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
<div class="table-main">
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="80" >{{ tw_lang('ID') }}</th>
                <th width="20%" >{{ tw_lang('thinkwinds::public.name') }}</th>
                <th >{{ tw_lang('thinkwinds::public.dir') }}</th>
                <th >{{ tw_lang('thinkwinds::manage.area.zimu') }}</th>
                <th >{{ tw_lang('thinkwinds::manage.area.zip') }}</th>
                <th width="10%" >{{ tw_lang('thinkwinds::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td>{!! $v['areaid'] !!}</td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['joinname'] !!}</td>
                <td>{!! $v['initials'] !!}</td>
                <td>{!! $v['zip'] !!}</td>
                <td>
                   <a href="{{ route('manage.area.delete', ['areaid'=>$v['areaid']]) }}" class="J_ajax_del" style="margin-right: 5px;">{{ tw_lang('thinkwinds::public.delete') }}</a>
                   <a class="J_dialog" title="{{ tw_lang('thinkwinds::public.edit') }}" href="{{ route('manage.area.edit', ['areaid'=>$v['areaid']]) }}">{{ tw_lang('thinkwinds::public.edit') }}</a>
                   <a title="{{ tw_lang('thinkwinds::public.edit') }}" href="{{ route('manage.area.index', ['areaid'=>$v['areaid']]) }}">{{ tw_lang('thinkwinds::manage.area.list') }}</a>
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
</div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>