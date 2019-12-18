<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
<div class="hstui-content">
    {!! thinkwinds_widget('s_manage_home') !!}
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>