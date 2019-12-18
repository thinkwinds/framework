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
                <th width="20%" >{{ tw_lang('thinkwinds::widget.name') }}</th>
                <th width="20%" >{{ tw_lang('thinkwinds::widget.module') }}</th>
                <th >{{ tw_lang('thinkwinds::public.times') }}</th>
                <th width="10%" >{{ tw_lang('thinkwinds::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['module'] !!}</td>
                <td>{!! tw_time2str($v['times']) !!}</td>
                <td>
                    <a class="btn btn-xs btn-info" title="" href="{!! route('manage.widget.inject.index', ['name'=>$v['name']]) !!}">{{ tw_lang('thinkwinds::public.view')}}</a>
                    @if($v['issystem'] == 0)
                    <a class="btn btn-xs btn-info J_dialog" title="{{ tw_lang('thinkwinds::public.update')}}{!! $v['name'] !!}{{ tw_lang('thinkwinds::public.data')}}" href="{!! route('manage.widget.edit', ['name'=>$v['name']]) !!}">{{ tw_lang('thinkwinds::public.update')}}</a>
                    <a class="btn btn-xs btn-info J_ajax_del" href="{!! route('manage.widget.delete', ['name'=>$v['name']]) !!}">{{ tw_lang('thinkwinds::public.delete')}}</a>
                    @endif
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
</div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>