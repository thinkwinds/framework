<meta charset="UTF-8" />
<title>{!! @$seo_title !!}</title>
<meta name="keywords" content="{!! @$seo_keywords !!}">
<meta name="description" content="{!! @$seo_description !!}">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="generator" content="thinkwinds v{!! config('thinkwinds:version') !!} 20171111" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="initial-scale=0.1">
<link rel="shortcut icon" href="{{ tw_public('favicon.ico') }}" />
<link rel="stylesheet" type="text/css" href="{{ config('thinkwinds.resurl') }}/css/hstui.min.css" />
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