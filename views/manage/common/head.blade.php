<meta charset="UTF-8" />
<title>{{ $seo_title }}</title>
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="generator" content="thinkwinds v{!! config('thinkwinds:version') !!} 20171111" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="initial-scale=0.1">
<link rel="shortcut icon" href="{{ tw_public('favicon.ico') }}" />
<link rel="stylesheet" type="text/css" href="{{ tw_resurl('css/hstui.min.css') }}" />
<link rel="stylesheet" href="{{ tw_assets('manage/css/style.css') }}">
<script>
var G = {
	RES_ROOT: '{{ tw_resurl('') }}',
	TIPS_MESSAGE: {
		STATE : '{!! session('state') !!}',
		MESSAGE : '{!! session('message') !!}',
	}
}
</script>
<script type="text/javascript" src="{{ tw_resurl('js/hstui.min.js') }}"></script>