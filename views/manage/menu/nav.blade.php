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
                  <th width="20%" >{!! tw_lang('thinkwinds::public.url') !!}</th>
                  <th width="10%" >{!! tw_lang('thinkwinds::public.icon') !!}</th>
                  <th width="10%" >{!! tw_lang('thinkwinds::public.operation') !!}</th>
                </tr>
            </thead>
            <tbody id="list">
            @if($menus)
            @foreach($menus as $v)
               <tr>
                <td>{!! $v['name'] !!}</td>
                <td>{!! $v['ename'] !!}</td>
                <td>{!! $v['url'] !!}</td>
                <td>@if($v['icon']) <i class="hstui-icon {!! $v['icon'] !!}"></i>@endif</td>
                <td><a href="{!! route('manage.menu.navEdit', ['id'=>$v['id']]) !!}" class="J_dialog" title="{!! tw_lang('thinkwinds::public.update') !!}">{!! tw_lang('thinkwinds::public.update') !!}</a> @if(!isset($v['items']) || !$v['items']) <a href="{!! route('manage.menu.navDelete', ['id'=>$v['id']]) !!}" class="J_ajax_del" data-msg="{{ tw_lang('thinkwinds::public.sure.delete') }}">{!! tw_lang('thinkwinds::public.delete') !!}</a>  @endif</td>
              </tr>
              @if(isset($v['items']) && $v['items'])
                @foreach($v['items'] as $ks=>$vs)
                   <tr>
                    <td style="padding-left: 40px">{!! $vs['name'] !!}</td>
                    <td>{!! $vs['ename'] !!}</td>
                    <td>{!! $vs['url'] !!}</td>
                    <td>@if($vs['icon']) <i class="hstui-icon {!! $vs['icon'] !!}"></i> @endif</td>
                    <td><a href="{!! route('manage.menu.navEdit', ['id'=>$vs['id']]) !!}" class="J_dialog" title="{!! tw_lang('thinkwinds::public.update') !!}">{!! tw_lang('thinkwinds::public.update') !!}</a>@if(!isset($vs['items']) || !$vs['items'])  <a href="{!! route('manage.menu.navDelete', ['id'=>$vs['id']]) !!}" class="J_ajax_del" data-msg="{{ tw_lang('thinkwinds::public.sure.delete') }}">{!! tw_lang('thinkwinds::public.delete') !!}</a> @endif</td>
                  </tr>
                  @if(isset($vs['items']) && $vs['items'])
                    @foreach($vs['items'] as $kx=>$vx)
                       <tr>
                        <td style="padding-left: 80px">{!! $vx['name'] !!}</td>
                        <td>{!! $vx['ename'] !!}</td>
                        <td>{!! $vx['url'] !!}</td>
                        <td>@if($vx['icon']) <i class="hstui-icon {!! $vx['icon'] !!}"></i>@endif</td>
                        <td><a href="{!! route('manage.menu.navEdit', ['id'=>$vx['id']]) !!}" class="J_dialog" title="{!! tw_lang('thinkwinds::public.update') !!}">{!! tw_lang('thinkwinds::public.update') !!}</a> <a href="{!! route('manage.menu.navDelete', ['id'=>$vx['id']]) !!}" class="J_ajax_del" data-msg="{{ tw_lang('thinkwinds::public.sure.delete') }}">{!! tw_lang('thinkwinds::public.delete') !!}</a></td>
                      </tr>
                    @endforeach
                  @endif
                @endforeach
              @endif
            @endforeach
            @else
            <tr>
              <td colspan="5">{{ tw_lang('thinkwinds::public.no.list') }}</td>
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