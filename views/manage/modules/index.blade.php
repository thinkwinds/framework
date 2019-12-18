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
                  <th width="10%" >{!! tw_lang('thinkwinds::public.status') !!}</th>
                  <th width="10%" >{!! tw_lang('thinkwinds::public.operation') !!}</th>
                </tr>
            </thead>
            <tbody id="list">
            @if(count($list))
            @foreach($list as $v)
               <tr>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['slug'] !!}</td>
                <td>{!! $v['version'] !!}</td>
                <td>{!! $v['description'] !!}</td>
                <td>@if($v['enabled']) <a class="J_ajax_refresh" href="{{route('manage.modules.enableds', ['slug'=>$v['slug'], 'enableds'=>0] )}}">{{tw_lang('thinkwinds::public.closes')}}</a> @else <a class="J_ajax_refresh" href="{{route('manage.modules.enableds', ['slug'=>$v['slug'], 'enableds'=>1] )}}">{{tw_lang('thinkwinds::public.opens')}}</a> @endif</td>
                <td>
                <a href="{!! route('manage.modules.douninstall', ['slug'=>$v['slug']]) !!}" class="J_ajax_del" data-msg="{{ tw_lang('thinkwinds::manage.modules.uninstall.tips') }}">{!! tw_lang('thinkwinds::public.uninstall') !!}</a>
                </td>
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