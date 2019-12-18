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
                    <th >{{ tw_lang('thinkwinds::public.calls') }}</th>
                    <th width="10%" >{{ tw_lang('thinkwinds::public.operation') }}</th>
                </tr>
            </thead>
            <tbody>
                @if(count($list))
                @foreach($list as $v)
                <tr>
                    <td>{!! $v['id'] !!}</td>
                    <td>{!! $v['name'] !!}</td>
                    <td>&#123;&#33;&#33; tw_block( {{$v['id']}} ) &#33;&#33;&#125;</td>
                    <td>
                       <a href="{{ route('manage.block.delete', ['id'=>$v['id'], 'module'=>$module]) }}" class="J_ajax_del" style="margin-right: 5px;">{{ tw_lang('thinkwinds::public.delete') }}</a>
                       <a class="J_dialog" title="{{ tw_lang('thinkwinds::public.edit') }}" href="{{ route('manage.block.edit', ['id'=>$v['id'], 'module'=>$module]) }}">{{ tw_lang('thinkwinds::public.edit') }}</a>
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
        <div class="table-footer"><div class="J_listPage hstui-fr">{!! $list->appends($args)->links() !!}</div></div>
    </div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>