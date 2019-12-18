<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
{!! $navs !!}
<div class="table-main">

  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.fields.save') }}" method="post">
    {!! tw_csrf() !!} 
    <input type="hidden" name="rname" value="{{ $rname }}">
    <input type="hidden" name="relatedid" value="{{ $relatedid }}">
    <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
       <thead class="hstui-table-head">
            <tr>
                <th width="60" >{{ tw_lang('thinkwinds::public.vieworder') }}</th>
                <th width="20%" >{{ tw_lang('thinkwinds::public.name') }}</th>
                <th >{{ tw_lang('thinkwinds::manage.fields.name') }}</th>
                <th >{{ tw_lang('thinkwinds::public.type') }}</th>
                <th >{{ tw_lang('thinkwinds::public.main.table') }}</th>
                <th >{{ tw_lang('thinkwinds::manage.fields.ismember') }}</th>
                <th >{{ tw_lang('thinkwinds::public.status') }}</th>
                <th width="10%" >{{ tw_lang('thinkwinds::public.operation') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($list)
            @foreach($list as $v)
            <tr>
                <td><input type="text" name="vieworder[{{$v['id']}}]" value="{!! $v['vieworder'] !!}" class="hstui-length-1 hstui-input"></td>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['fieldname'] !!}</td>
                <td>{!! $v['fieldtype'] !!}</td>
                <td>@if($v['ismain']) {{ tw_lang('thinkwinds::public.yes') }} @else - @endif</td>
                <td>@if($v['ismember']) {{ tw_lang('thinkwinds::public.opens') }} @else - @endif</td>
                <td>@if(!$v['disabled']) {{ tw_lang('thinkwinds::public.opens') }} @else {{ tw_lang('thinkwinds::public.closes') }} @endif</td>
                <td>
                   <a href="{{ route('manage.fields.delete', ['id'=>$v['id']]) }}" class="J_ajax_del" style="margin-right: 5px;">{{ tw_lang('thinkwinds::public.delete') }}</a>
                   <a  href="{{ route('manage.fields.edit', ['id'=>$v['id'], 'rname'=>$rname, 'relatedid'=>$relatedid]) }}">{{ tw_lang('thinkwinds::public.edit') }}</a>
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
    @if($list)
    <div class="hstui-form-group">
      <div class="hstui-u-sm-12">
        <button type="submit" class="hstui-button hstui-button-default J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.submit') }}</button>
      </div>
    </div>
    @endif
    </form>
</div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>