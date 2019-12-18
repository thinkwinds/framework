<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
<div class="hstui-frame" style="width: 100%; margin-bottom: 10px">
    <div class="hstui-frame-title">{{ tw_lang('thinkwinds::public.e.info') }}</div>
    <div class="hstui-frame-content">
        <table class="hstui-table">
            <thead>
                <tr>
                    <td width="10%">{{ tw_lang('thinkwinds::widget.name')}}</td>
                <td>{!! $info['name'] !!}</td>
                </tr>
                <tr>
                    <td>{!! tw_lang('thinkwinds::public.module') !!}</td>
                    <td>{!! $info['module'] !!}</td>
                </tr>
                <tr>
                    <td>{!! tw_lang('thinkwinds::public.add', 'thinkwinds::public.times') !!}</td>
                    <td>{!! tw_time2str($info['times'], 'Y-m-d H:i:s') !!}</td>
                </tr>
                <tr>
                    <td>{!! tw_lang('thinkwinds::public.description') !!}</td>
                    <td>{!! $info['description'] !!}</td>
                </tr>
                <tr>
                    <td>{!! tw_lang('thinkwinds::widget.document') !!}</td>
                    <td>{!! $info['document'] !!}</td>
                </tr>
            </thead>
        </table>

    </div>
</div>
<div class="table-main">
    <table class="hstui-table hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="20%" >{{ tw_lang('thinkwinds::widget.alias') }}</th>
                <th >{{ tw_lang('thinkwinds::widget.description') }}</th>
                <th >{{ tw_lang('thinkwinds::widget.files') }}</th>
                <th >{{ tw_lang('thinkwinds::widget.class') }}</th>
                <th >{{ tw_lang('thinkwinds::widget.fun') }}</th>
                <th >{{ tw_lang('thinkwinds::public.times') }}</th>
                <th width="10%" >{{ tw_lang('thinkwinds::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td>{!! $v['alias'] !!}</td>
                <td>{!! $v['description'] !!}</td>
                <td>{!! $v['files'] !!}</td>
                <td>{!! $v['class'] !!}</td>
                <td>{!! $v['fun'] !!}</td>
                <td>{!! tw_time2str($v['times']) !!}</td>
                <td>
                    @if($v['issystem'] == 0)
                    <a class="btn btn-xs btn-info J_dialog" title="{{ tw_lang('thinkwinds::public.update')}}{{ tw_lang('thinkwinds::public.data')}}" href="{!! route('manage.widget.inject.edit', ['name'=>$v['widget_name'], 'id'=>$v['id']]) !!}">{{ tw_lang('thinkwinds::public.update')}}</a>
                    <a class="btn btn-xs btn-info J_ajax_del" href="{!! route('manage.widget.inject.delete', ['name'=>$v['widget_name'], 'id'=>$v['id']]) !!}">{{ tw_lang('thinkwinds::public.delete')}}</a>
                    @endif
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">{!! tw_lang('thinkwinds::public.no.list') !!}</td>
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