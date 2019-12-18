<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
    {!! $navs !!}
    <div class="table-main">
        <table class="hstui-table hstui-table-radius hstui-table-striped hstui-text-nowrap" cellspacing="0" width="100%" id="dataTable">
           <thead class="hstui-table-head">
               <tr>
                  <th width="" >{!! tw_lang('thinkwinds::public.name') !!}</th>
                  <th width="12%" >{!! tw_lang('thinkwinds::public.ename') !!}</th>
                  <th width="10%" >{!! tw_lang('thinkwinds::public.version') !!}</th>
                  <th width="" >{!! tw_lang('thinkwinds::public.description') !!}</th>
                  <th width="30" >{!! tw_lang('thinkwinds::public.operation') !!}</th>
                </tr>
            </thead>
            <tbody id="list">
            @if($list)
            @foreach($list as $v)
               <tr>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['slug'] !!}</td>
                <td>{!! $v['version'] !!}</td>
                <td>{!! $v['description'] !!}</td>
                <td><a href="{!! route('manage.modules.doinstalls', ['slug'=>$v['slug']]) !!}" class="J_confirm" data-msg="{{ tw_lang('thinkwinds::manage.modules.install.tips') }}">{!! tw_lang('thinkwinds::public.install') !!}</a></td>
              </tr>
            @endforeach
            @else
            <tr>
              <td colspan="6">{{ tw_lang('thinkwinds::public.no.list') }}</td>
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