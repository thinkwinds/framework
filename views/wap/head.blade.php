<meta charset="UTF-8" />
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="generator" content="thinkwinds v{!! config('thinkwinds:version') !!} 20171111" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ tw_public('favicon.ico') }}" />
<link rel="stylesheet" type="text/css" href="{{ config('thinkwinds.wapres') }}/css/hstui.css" />
<script>
var G = {
	RES_ROOT: '{{ config('thinkwinds.wapres') }}',
	TIPS_MESSAGE: {
		STATE : '{!! session('state') !!}',
		MESSAGE : '{!! session('message') !!}'
	}
}
</script>
<script type="text/javascript" src="{{ config('thinkwinds.wapres') }}/js/hstui.js"></script>