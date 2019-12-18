<!doctype html>
<html>
<head>
@mHead
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
                    <th >{{ tw_lang('thinkwinds::manage.call.module') }}</th>
                    <th >{{ tw_lang('thinkwinds::manage.call.type') }}</th>
                    <th width="10%" >{{ tw_lang('thinkwinds::public.operation') }}</th>
                </tr>
            </thead>
            <tbody>
                @if(count($list))
                @foreach($list as $v)
                <tr>
                    <td>{!! $v['id'] !!}</td>
                    <td>{!! $v['name'] !!}</td>
                    <td>{!! $module[$v['module']]['name'] !!}</td>
                    <td>{!! $type[$v['type']]['name'] !!}</td>
                    <td>
                       <a href="{!! route('manage.call.block.data', ['id'=>$v['id']]) !!}">{!! tw_lang('thinkwinds::public.manage') !!}</a>
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
        <div class="table-footer"><div class="J_listPage hstui-fr">{!! $list->links() !!}</div></div>
    </div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>