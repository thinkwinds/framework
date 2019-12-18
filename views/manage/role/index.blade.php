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
          <th >{{ tw_lang('thinkwinds::manage.role.name') }}</th>
          <th width="20%">{{ tw_lang('thinkwinds::public.operation') }}</th>
        </tr>
      </thead>
      <tbody>
        @if(count($roles))
        @foreach($roles as $v)
        <tr>
          <td>{!! $v['name'] !!}</td>
          <td width="20%">
            <a class="btn btn-xs btn-info" title="{{ tw_lang('thinkwinds::public.update')}}" href="{!! route('manage.role.edit',['id'=>$v['id']]) !!}"><i class="hstui-icon hstui-icon-compose"></i>{{ tw_lang('thinkwinds::public.update')}}</a>
            <a class="btn btn-xs btn-danger J_ajax_del" href="{!! route('manage.role.delete',['id'=>$v['id']]) !!}"><i class="hstui-icon hstui-icon-trash"></i>{{ tw_lang('thinkwinds::public.delete')}}</a>
          </td>
        </tr>
        @endforeach
        @else
        <tr>
          <td colspan="2">{!! tw_lang('thinkwinds::public.no.list') !!}</td>
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