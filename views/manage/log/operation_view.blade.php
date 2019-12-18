<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body style="width: 600px; height: 600px;">
<div class="hstui-scrollable-vertical" style="height: 600px;">
  <table class="hstui-table">
    <thead>
      <tr>
        <td>{{ tw_lang('thinkwinds::public.username')}}</td>
        <td>{!! $info['username'] !!}</td>
      </tr>
      <tr>
        <td>{!! tw_lang('thinkwinds::public.operation', 'thinkwinds::public.times') !!}</td>
        <td>{!! tw_time2str($info['times'], 'Y-m-d H:i:s') !!}</td>
      </tr>
      <tr>
        <td>{!! tw_lang('thinkwinds::public.operation') !!}IP</td>
        <td>{!! $info['ip'] !!}:{!! $info['port'] !!}</td>
      </tr>
      <tr>
        <td>{!! tw_lang('thinkwinds::public.operation','thinkwinds::public.operating.system') !!}</td>
        <td>{!! $info['platform'] !!}</td>
      </tr>
      <tr>
        <td>{!! tw_lang('thinkwinds::public.operation','thinkwinds::public.browser') !!}</td>
        <td>{!! $info['browser'] !!}</td>
      </tr>
      <tr>
        <td>{!! tw_lang('thinkwinds::public.remark') !!}</td>
        <td>{!! $info['remark'] !!}</td>
      </tr>
      <tr>
        <td>{!! tw_lang('thinkwinds::public.olddata') !!}</td>
        <td>
          <table class="hstui-table">
            <thead>
              @foreach($info['olddata'] as $key=>$val)
              <tr>
                <td>{!! $key !!}</td>
                <td>{!! $val !!}</td>
              </tr>
              @endforeach
            </thead>
          </table>
        </td>
      </tr>
      <tr>
        <td>{!! tw_lang('thinkwinds::public.newdata') !!}</td>
        <td>
          <table class="hstui-table">
            <thead>
              @foreach($info['newdata'] as $key=>$val)
              <tr @if(isset($info['olddata'][$key]) && $info['newdata'][$key] != $info['olddata'][$key]) style="color: red" @endif>
                <td>{!! $key !!}</td>
                <td>{!! $val !!}</td>
              </tr>
              @endforeach
            </thead>
          </table>
        </td>
      </tr>
    </thead>
  </table>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>