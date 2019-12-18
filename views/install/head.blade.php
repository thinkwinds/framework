<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
 <title>{!! $name !!}</title>
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0">
<meta name="viewport" content="initial-scale=0.1">
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="shortcut icon" href="{{ tw_public('favicon.ico') }}" />
<link rel="stylesheet" href="{{ config('thinkwinds.resurl') }}/css/hstui.min.css" />
<link rel="stylesheet" href="{{ tw_public('assets/install/install.css') }}">
<script>
var G = {
	RES_ROOT: '{{ config('thinkwinds.resurl') }}',
	TIPS_MESSAGE: {
		STATE : '{!! session('state') !!}',
		MESSAGE : '{!! session('message') !!}',
	}
}
</script>
<script type="text/javascript" src="{{ config('thinkwinds.resurl') }}/js/hstui.min.js"></script>