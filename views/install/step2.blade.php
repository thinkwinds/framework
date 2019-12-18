<!DOCTYPE html>
<html  class="no-js" lang="">
<head>
@include('thinkwinds::install.head')
</head>
<body>
@include('thinkwinds::install.header')
<section>
    <div class="content">
        <div class="form-group form-group-overfix">
            <div data-target="#step-container" class="row-fluid" id="fuelux-wizard">
                <ul class="wizard-steps">
                    <li class="active" data-target="#step1">
                        <span class="step">1</span>
                        <span class="title">{{ tw_lang('thinkwinds::install.step1') }}</span>
                    </li>
                    <li class="active" data-target="#step2">
                        <span class="step">2</span>
                        <span class="title">{{ tw_lang('thinkwinds::install.step2') }}</span>
                    </li>
                    <li data-target="#step3">
                        <span class="step">3</span>
                        <span class="title">{{ tw_lang('thinkwinds::install.step3') }}</span>
                    </li>
                    <li data-target="#step4">
                        <span class="step">4</span>
                        <span class="title">{{ tw_lang('thinkwinds::install.step4') }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main" style="margin-bottom: 10px;">
            <div class="dialogs">
                {{ tw_lang('thinkwinds::install.environmental.testing') }}
                <table class="hstui-table hstui-table-bordered">
                    <tr>
                        <th>{{ tw_lang('thinkwinds::install.detection.project') }}</th>
                        <th>{{ tw_lang('thinkwinds::install.required.configuration') }}</th>
                        <th>{{ tw_lang('thinkwinds::install.optimum') }}</th>
                        <th>{{ tw_lang('thinkwinds::install.current.server') }}</th>
                    </tr>
                    <tr>
                        <td>{{ tw_lang('thinkwinds::install.operating.system') }}</td>
                        <td>{{ tw_lang('thinkwinds::install.unrestricted') }}</td>
                        <td>linux</td>
                        <td>{!! $env['OS'] !!}</td>
                    </tr>
                    <tr>
                        <td>{{ tw_lang('thinkwinds::install.php.v') }}</td>
                        <td>{!! $limitEnv['min']['php_version'] !!}</td>
                        <td>{!! $limitEnv['perfect']['php_version'] !!}</td>
                        <td>{!! $env['php_version'] !!}</td>
                    </tr>
                    <tr>
                        <td>{{ tw_lang('thinkwinds::install.attachments.upload') }}</td>
                        <td>{{ tw_lang('thinkwinds::install.unrestricted') }}</td>
                        <td>2M</td>
                        <td>{!! $env['file_upload'] !!}</td>
                    </tr>
                    <tr>
                        <td>GD</td>
                        <td>{!! $limitEnv['min']['gd'] !!}</td>
                        <td>{!! $limitEnv['perfect']['gd'] !!}</td>
                        <td>{!! $env['gd'] !!}</td>
                    </tr>
                    <tr>
                        <td>{{ tw_lang('thinkwinds::install.disk.space') }}</td>
                        <td>{!! $limitEnv['min']['disk_space'] !!}</td>
                        <td>{!! $limitEnv['perfect']['disk_space'] !!}</td>
                        <td>{!! $env['disk_space'] !!}</td>
                    </tr>
                </table>
                {{ tw_lang('thinkwinds::install.dir.file.jurisdiction') }}
                <table class="hstui-table hstui-table-bordered">
                    <tr><th>{{ tw_lang('thinkwinds::install.dir.file') }}</th><th>{{ tw_lang('thinkwinds::install.required.state') }}</th><th>{{ tw_lang('thinkwinds::install.current.state') }}</th></tr>
                    @foreach($fileRW as $item)
                    <tr>
                        <td>{!! $item['path'] !!}</td>
                        <td><span class="cor-blue2a text-size20">√</span> {{ tw_lang('thinkwinds::install.write1') }}</td>
                        <td>
                            @if($item['result'] == 1)<span class="cor-blue2a text-size20">√</span>@else<span class="cor-redfc text-size20">×</span>@endif
                            @if($item['result'] == 1){{ tw_lang('thinkwinds::install.write1') }}@elseif($item['result'] == -1){{ tw_lang('thinkwinds::install.noin') }}@else{{ tw_lang('thinkwinds::install.write2') }}@endif
                        </td>
                    </tr>
                    @endforeach
                </table>
                {{ tw_lang('thinkwinds::install.php.extension') }}
                <table class="hstui-table hstui-table-bordered">
                    <tr><th>{{ tw_lang('thinkwinds::install.required.extension') }}</th><th>{{ tw_lang('thinkwinds::install.required.state') }}</th><th>{{ tw_lang('thinkwinds::install.current.state') }}</th></tr>
                    @foreach($functionArr as $item)
                        <tr>
                            <td>{!! $item['extension'] !!}</td>
                            <td><span class="cor-blue2a text-size20">√</span> {{ tw_lang('thinkwinds::install.support1') }}</td>
                            <td>
                                @if($item['support'] == 'y')<span class="cor-blue2a text-size20">√</span>@else<span class="cor-redfc text-size20">×</span>@endif
                                @if($item['support'] == 'y'){{ tw_lang('thinkwinds::install.support1') }}@else{{ tw_lang('thinkwinds::install.support2') }}@endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="footer">
        <div class="btn-group shadow_con">
            <button onclick="window.location.href='{!! url('install?step=' . Crypt::encrypt(1)) !!}'" type="button" class="btn-white dropdown-toggle">
                {{ tw_lang('thinkwinds::install.go.back') }}
            </button>
        </div>
        @if(!$error)
        <a href="{!! url('install?step=' . Crypt::encrypt(3)) !!}" class="btn-orange shadow_con">{{ tw_lang('thinkwinds::install.start.install') }}</a>
        @endif
    </div>
</footer>
<script>
Hstui.use('jquery', 'common', function(){
    
});
</script>
</body>
</html>