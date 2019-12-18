<!doctype html>
<html>
<head>
@include('thinkwinds::common.head')
<style>
.common-tips {
	position: absolute;
	left: 50%;
	margin-left: -135px;
	top: 180px;
	width: 370px;

}
.common-tips.hstui-frame .hstui-frame-title {
	height: 40px;
	line-height: 40px;
	background: linear-gradient(rgb(248, 248, 248) 0px, rgb(236, 236, 236) 100%) repeat-x rgb(242, 242, 242);
    background-repeat: repeat-x;
    text-align: center;
}

.common-tips.hstui-frame .hstui-frame-content {
    text-align: center;
}
.common-tips.hstui-frame .hstui-frame-content p {
	margin-bottom: 10px;
	margin-top: 10px;
	font-size: 16px;
}
.common-tips.hstui-frame .hstui-frame-content a{
	cursor: pointer;
	font-size: 12px;
}

.common-tips-dialog {
	width: 370px;
	margin-top: 20px;
	margin-right: 10px;
	margin-left: 10px;
	border: 0px;
}

.common-tips-dialog.hstui-frame .hstui-frame-content{
    text-align: center;
}
.common-tips-dialog.hstui-frame .hstui-frame-content p {
	margin-bottom: 10px;
	margin-top: 10px;
	font-size: 16px;
}
.common-tips-dialog.hstui-frame .hstui-frame-content a{
	cursor: pointer;
	font-size: 12px;
}	
</style>
</head>
<body>
<div class="hstui-frame common-tips">
	<div class="hstui-frame-title">
		{!! tw_lang('thinkwinds::public.tips.title') !!}
	</div>
	<div class="hstui-frame-content">
		<p>{{ $message }}</p>
		<a class="J_tips" style="display: none;"><em style="color: red;" id="t">(5)</em>{!! tw_lang('thinkwinds::public.tips.tiao') !!}</a>
	</div>
</div>
<script>
var referer = '{!! $referer !!}';
Hstui.use('jquery','common',function() {
	var t = 5;
	if(referer) {
		$(".J_tips").show();
	    setInterval(function () {
	    	t--;
	    	$("#t").html('('+t+')');
	    	if(t == 1) {
		    	if(referer) {
		    		window.location.href = referer;
		    	}
	    	}
	    }, 1000);
	    $(".J_tips").on('click',function(){
	    	if(referer) {
	    		window.location.href = referer;
	    	}
	    });
	}
});
</script>
</body>
</html>