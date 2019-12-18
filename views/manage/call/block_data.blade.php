<!doctype html>
<html>
<head>
@mHead
</head>
<body>
<div class="manage-content">
{!! $navs !!}
    <div class="table-main">
        <table class="hstui-table hstui-table-bordered hstui-table-radius hstui-table-striped hstui-table-hover hstui-table-compact hstui-text-nowrap">
           <thead class="hstui-table-head">
                <tr>
                    <th width="80" >{{ tw_lang('ID') }}</th>
                    <th width="20%" >{{ tw_lang('thinkwinds::public.name') }}</th>
                    <th >{{ tw_lang('thinkwinds::manage.call.model') }}</th>
                    <th >{{ tw_lang('thinkwinds::manage.call.type') }}</th>
                    <th width="10%" >{{ tw_lang('thinkwinds::public.operation') }}</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        <div class="table-footer"><div class="J_listPage hstui-fr"></div></div>
    </div>
</div>
<script>
Hstui.use('jquery','common',function() {
});
</script>
</body>
</html>