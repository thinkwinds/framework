<!doctype html>
<html>
<head>
@include('thinkwinds::wap.head')
</head>
<body style="background: #fff">
<header class="hstui-bar hstui-bar-nav app-bar-nav">
	<h1 class="hstui-title">{!! tw_lang('thinkwinds::public.tips.title') !!}</h1>
</header>
<div class="hstui-content">
	<div class="hstui-msg">
		<div class="hstui-msg-content">
			<i class="hstui-icon hstui-icon-close hstui-msg-icon"></i>
			<p>{{ $message }}</p>
			<a class="J_tips hstui-hidden"><span style="color: red;" id="t">(5)</span>{!! tw_lang('thinkwinds::public.tips.tiao') !!}</a>
		</div>
	</div>
</div>
<script>
var referer = '{!! $referer !!}';
hstui.init({});
var t = 5;
if(referer) {
	hstui('.J_tips').removeClass('hstui-hidden');
	setInterval(function () {
		t--;
		hstui("#t").html('('+t+')');
		if(t == 1) {
	    	if(referer) {
	    		window.location.href = referer;
	    	} else {
	    		history.back(-1);
	    	}
		}
	}, 1000);
	hstui(".hstui-content").on('click', '.J_tips',function(){
		if(referer) {
			window.location.href = referer;
		} else {
			history.back(-1);
		}
	});
}
</script>
</body>
</html>