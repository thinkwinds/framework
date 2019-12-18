<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
        <thead class="hstui-table-head">
            <tr>
                <th width="20%" >{{ tw_lang('thinkwinds::public.username') }}</th>
                <th width="10%">{{ tw_lang('thinkwinds::public.realname') }}</th>
                <th width="10%">{{ tw_lang('thinkwinds::public.email') }}</th>
                <th width="10%">{{ tw_lang('thinkwinds::public.mobile') }}</th>
                <th width="10%">qq</th>
                <th width="10%">{{ tw_lang('thinkwinds::public.weixin') }}</th>
                <th>{{ tw_lang('thinkwinds::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($founders)
            @foreach($founders as $v)
            <tr>
                <td>{!! $v['username'] !!}</td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['email'] !!}</td>
                <td>{!! $v['mobile'] !!}</td>
                <td>{!! $v['qq'] !!}</td>
                <td>{!! $v['weixin'] !!}</td>
                <td width="40%">
                    <a class="btn btn-xs btn-info J_dialog" title="{{ tw_lang('thinkwinds::public.update')}}{!! $v['name'] !!}{{ tw_lang('thinkwinds::public.data')}}" href="{!! route('manage.founder.edit',['uid'=>$v['uid']]) !!}"><i class="hstui-icon hstui-icon-compose"></i>{{ tw_lang('thinkwinds::public.update')}}</a>
                    <a class="btn btn-xs btn-danger J_ajax_del" href="{!! route('manage.founder.delete',['uid'=>$v['uid']]) !!}"><i class="hstui-icon hstui-icon-trash"></i>{{ tw_lang('thinkwinds::public.delete')}}</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">{{ tw_lang('thinkwinds::public.no.list') }}</td>
            </tr>
            @endif
         </tbody>
    </table>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>