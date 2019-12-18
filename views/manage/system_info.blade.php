<style>
.hstui-system-info{
	width: 100%;
}	
.hstui-system-info .hstui-frame-content{

}
.hstui-system-info table td:NTH-CHILD(odd) {
    background: #f7f7f7;
    text-align: right;
    width: 15%;
}
.hstui-system-info table td:NTH-CHILD(even) {
    text-align: left;
    width: 35%;
}
.hstui-system-info .hstui-table-bordered,
.hstui-system-info .hstui-table-bordered>tbody,
.hstui-system-info .hstui-table-bordered>tbody>tr,
.hstui-system-info .hstui-table-bordered>tbody>tr>td{
	border: 0px;
}
.hstui-system-info .hstui-table-bordered>tbody>tr>td{
    border-bottom: 1px  solid #ddd !important;
}
.hstui-system-info .hstui-table-bordered:last-child>tbody>tr:last-child>td{
	border: 0px !important;
}
</style>
<div class="hstui-content hstui-margin-xs">
	<div class="hstui-frame hstui-system-info">
		<div class="hstui-frame-title">{{ tw_lang('thinkwinds::manage.system.info') }}</div>
		<div class="hstui-frame-content" style="padding: 0px;">
			<table class="hstui-table hstui-table-bordered">
				<tbody>
					<tr>
						<td>{{ tw_lang('thinkwinds::manage.system.info.server') }}</td>
						<td style="width: 85%">{!! $system_info !!}</td>
					</tr>
				</tbody>
			</table>
			<table class="hstui-table hstui-table-bordered">
				<tbody>
					<tr>
						<td>{{ tw_lang('thinkwinds::manage.system.host') }}</td>
						<td>{!! $http_host !!}</td>
						<td>{{ tw_lang('thinkwinds::manage.system.port') }}</td>
						<td>{!! $server_port !!}</td>
					</tr>
					<tr>
						<td>{{ tw_lang('thinkwinds::manage.system.sysos') }}</td>
						<td>{!! $sysos !!}</td>
						<td>{{ tw_lang('thinkwinds::manage.system.php') }}</td>
						<td>{!! PHP_VERSION !!}</td>
					</tr>
					<tr>
						<td>{{ tw_lang('thinkwinds::manage.system.sockets') }}</td>
						<td>@if($sockets) {{ tw_lang('thinkwinds::manage.system.open') }} @else {{ tw_lang('thinkwinds::manage.system.no') }} @endif</td>
						<td>{{ tw_lang('thinkwinds::manage.system.curl') }}</td>
						<td>@if($curls) {{ tw_lang('thinkwinds::manage.system.open') }} @else {{ tw_lang('thinkwinds::manage.system.no') }} @endif</td>
					</tr>
					<tr>
						<td>{{ tw_lang('thinkwinds::manage.system.upload') }}</td>
						<td>{!! $upload_max_filesize !!}</td>
						<td>{{ tw_lang('thinkwinds::manage.system.gd') }}</td>
						<td>{!! $gd_info['GD Version'] !!}</td>
					</tr>
					<tr>
						<td>{{ tw_lang('thinkwinds::manage.system.openssl') }}</td>
						<td>@if($openssl) {{ tw_lang('thinkwinds::manage.system.open') }} @else {{ tw_lang('thinkwinds::manage.system.no') }} @endif</td>
						<td>{{ tw_lang('thinkwinds::manage.system.public') }}</td>
						<td>@if($public_dir) {{ tw_lang('thinkwinds::manage.system.public.yes') }} @else {{ tw_lang('thinkwinds::manage.system.public.no') }} @endif</td>
					</tr>
					<tr>
						<td>{{ tw_lang('thinkwinds::manage.system.pdo') }}</td>
						<td>@if($pdo) {{ tw_lang('thinkwinds::manage.system.open') }} @else {{ tw_lang('thinkwinds::manage.system.no') }} @endif</td>
						<td>{{ tw_lang('thinkwinds::manage.system.time') }}</td>
						<td id="system_time"></td>
					</tr>
				</tbody>
			</table>
	
		</div>
	</div>
</div>
<script>
var timestamp = new Date();
function systemTime() {
	timestamp = new Date();
	document.getElementById('system_time').innerHTML = timestamp.toLocaleString();
}
window.setInterval(systemTime,1000); 	
</script>