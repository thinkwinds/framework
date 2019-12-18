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
                <th width="20%" >{{ tw_lang('thinkwinds::manage.form.name') }}</th>
                <th >{{ tw_lang('thinkwinds::manage.form.table') }}</th>
                <th >{{ tw_lang('thinkwinds::manage.form.field') }}</th>
                <th >{{ tw_lang('thinkwinds::manage.form.email.notice') }}</th>
                <th >{{ tw_lang('thinkwinds::manage.form.mobile.notice') }}</th>
                <th >{{ tw_lang('thinkwinds::public.times') }}</th>
                <th >{{ tw_lang('thinkwinds::manage.form.content') }}</th>
                <th width="10%" >{{ tw_lang('thinkwinds::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td>{!! $v['id'] !!}</td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['table'] !!}</td>
                <td><a class="J_linkframe_trigger" data-id="form-fields-{{ $v['id'] }}" data-name="[{!! $v['name'] !!}]{{ tw_lang('thinkwinds::manage.form.field') }}" href="{{ route('manage.fields.index', ['rname'=>'form', 'relatedid'=>$v['id']]) }}">{{ tw_lang('thinkwinds::public.view') }}</a></td>
                <td>@if(isset($v['setting']['email']) && $v['setting']['email']){{ $v['setting']['email'] }}@else - @endif</td>
                <td>@if(isset($v['setting']['mobile']) && $v['setting']['mobile']){{ $v['setting']['mobile'] }}@else - @endif</td>
                <td>{!! $v['times_str'] !!}</td>
                <td> <a class="J_linkframe_trigger" data-id="form-content-{{ $v['id'] }}" data-name="[{!! $v['name'] !!}]{{ tw_lang('thinkwinds::manage.form.content') }}" href="{{ route('manage.form.content', ['formid'=>$v['id']]) }}">{{ tw_lang('thinkwinds::public.manage') }}</a> </td>
                <td>
                   <a href="{{ route('manage.form.delete', ['id'=>$v['id'], 'module'=>$module, 'relatedid'=>$relatedid]) }}" data-msg="{{ tw_lang('thinkwinds::manage.form.delete.msg') }}" class="J_ajax_del" style="margin-right: 5px;">{{ tw_lang('thinkwinds::public.delete') }}</a>
                   <a class="J_dialog" title="{{ tw_lang('thinkwinds::public.edit') }}" href="{{ route('manage.form.edit', ['id'=>$v['id'], 'module'=>$module, 'relatedid'=>$relatedid ]) }}">{{ tw_lang('thinkwinds::public.edit') }}</a>
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