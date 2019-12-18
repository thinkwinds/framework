<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="manage-content">
    {!! $navs !!}
    <div class="manage-search">
      <input class="hstui-input hstui-length-3" id="search-username" placeholder="{!! tw_lang('thinkwinds::public.enter.one.username') !!}" />
      <input class="hstui-input hstui-length-2" id="search-ip" placeholder="{!! tw_lang('thinkwinds::public.enter.one.ip') !!}" />
      <input class="hstui-input hstui-length-3 J_datetime" id="search-stime" placeholder="{!! tw_lang('thinkwinds::public.stime') !!}" />
      <input class="hstui-input hstui-length-3 J_datetime" id="search-etime" placeholder="{!! tw_lang('thinkwinds::public.etime') !!}" />
      <a href="javascript:;" class="hstui-button hstui-button-default hstui-button-xs J_search">{{ tw_lang('thinkwinds::public.search') }}</a>
    </div>
    <div class="table-main">
        <table class="hstui-table hstui-table-bordered hstui-table-striped hstui-table-compact hstui-text-nowrap" cellspacing="0" width="100%" id="dataTable">
           <thead class="hstui-table-head">
               <tr>
                    <th width="10%" >{!! tw_lang('thinkwinds::public.username') !!}</th>
                    <th width="12%" >{!! tw_lang('thinkwinds::public.times') !!}</th>
                    <th width="12%" >ip</th>
                    <th width="10%" >platform</th>
                    <th width="10%" >browser</th>
                    <th width="" >{!! tw_lang('thinkwinds::public.note') !!}</th>
                    <th width="10%" >{!! tw_lang('thinkwinds::public.details') !!}</th>
                </tr>
            </thead>
            <tbody id="list">
            </tbody>
        </table>
        <div class="table-footer"><div class="J_listPage hstui-fr"></div></div>
    </div>
</div>
<script type="text/html" id="listTpl">
    [: for(i=0; i < data.length; i++){ :]
          <tr>
            <td>[:=data[i]['username']:]</td>
            <td>[:=data[i]['times']:]</td>
            <td>[:=data[i]['ip']:]:[:=data[i]['port']:]</td>
            <td>[:=data[i]['platform']:]</td>
            <td>[:=data[i]['browser']:]</td>
            <td>[:=data[i]['remark']:]</td>
            <td><a href="[:=data[i]['viewurl']:]" class="J_dialog" title="{!! tw_lang('thinkwinds::public.view', 'thinkwinds::public.details') !!}">{!! tw_lang('thinkwinds::public.view') !!}</a></td>
        </tr>
      [:}:]
</script>
<script>
Hstui.use('jquery', 'common',function() {
  var listdata = Hstui.listData({
      url: '{!! route('manage.log.operation') !!}',
      col: 7,
      loadPage: true
  }, function() {
    Hstui.dataTable('#dataTable', {
      scrollY: Hstui.dataTableHW(),
      scrollX: true
    }, function() {
      Hstui.dataTableHW();
    });
  });
  $(".J_search").on('click',function(){
    listdata.data['ip'] = $('#search-ip').val();
    listdata.data['username'] = $('#search-username').val();
    listdata.data['stime'] = $('#search-stime').val();
    listdata.data['etime'] = $('#search-etime').val();
    listdata.loadPage = true;
    Hstui.listData(listdata);
  });
});
</script>
</body>
</html>