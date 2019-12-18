@foreach($configure as $k=>$v)
@php
$v3t = 'array';
if (!empty($v[3]) && !is_array($v[3]))
{
  list($v3, $v3t) = explode('|',$v[3]);
  $v[3] = $decorator[$v3];
 }
@endphp
<div class="hstui-form-group hstui-form-group-sm " id="J_form_error_{{ $k }}">
  <label class="hstui-u-sm-2 hstui-form-label">{{ $v['1'] }}</label>
  <div class="hstui-u-sm-10 hstui-form-input">
      @if($v[0] == 'textarea')
        @if($v3t == 'html' && !$vConfigures[$k])
        <textarea class="hstui-textarea" style="height: 420px; width: 100%;" name="configures[{{ $k }}]" id="thinkwinds_{{ $k }}">{!! $v[3] !!}</textarea>
        @else
        <textarea class="hstui-textarea" style="height: 420px; width: 100%;" name="configures[{{ $k }}]" id="thinkwinds_{{ $k }}">{!! @$vConfigures[$k] !!}</textarea>
        @endif
      @endif
      @if($v[0] == 'text')
        @if($v3t == 'html' && !$vConfigures[$k])
        <input type="text" name="configures[{{ $k }}]" id="thinkwinds_{{ $k }}" value="{{ @$vConfigures[$k] }}" class="hstui-input hstui-length-6">
        @else
        <input type="text" name="configures[{{ $k }}]" id="thinkwinds_{{ $k }}" value="{!! @$vConfigures[$k] !!}" class="hstui-input hstui-length-6">
        @endif
      @endif
      @if($v[0] == 'select')
         @if($v[4] == 'multiple')
         <select name="configures[{{ $k }}]" id="thinkwinds_{{ $k }}" class="hstui-input hstui-length-2" size="8" {{ $v[4] }}>
          @else 
         <select name="configures[{{ $k }}]" id="thinkwinds_{{ $k }}" class="hstui-input hstui-length-2">
          @endif
          @if($v3t == 'html')
            {!! $v[3] !!}
          @else
          @foreach((array)$v[3] as $key=>$val)
          <option value="{{ $key }}" {{ tw_isSelected(@$vConfigures[$k] == $key) }}>{{ $val }}</option>
          @endforeach
          @endif
      </select>
      @endif
      @if($v[0] == 'radio')
        @if($v3t == 'array')
          @foreach((array)$v[3] as $_k=>$_v)
           <label class="blue mr10"><input type="radio" value="{{ $_k }}" name="configures[{{ $k }}]"  {{ tw_ifcheck(@$vConfigures[$k] == $_k) }}><span>{{ $_v }}</span></label>
          @endforeach
        @else 
        {!! $v[3] !!}
        @endif
      @endif
      @if($v[0] == 'checkbox')
        @if($v3t == 'array')
          @foreach((array)$v[3] as $_k=>$_v)
            <label class="blue mr10"><input type="checkbox" value="{{ $_k }}" name="configures[{{ $k }}][]"  {{ tw_ifcheck(@in_array($_k, @$vConfigures[$k]) ) }}><span>{{ $_v }}</span></label>
          @endforeach
        @else 
        {!! $v[3] !!}
        @endif
      @endif
        <div class="hstui-form-input-tips" id="J_form_tips_{{ $k }}">{!! $v[2] !!}</div>
  </div>
</div>
@endforeach
@if($callTypeInfo->isRefresh)
<div class="hstui-form-group hstui-form-group-sm" id="J_form_error_cycle">
  <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.call.data.uptimes') }}</label>
  <div class="hstui-u-sm-10 hstui-form-input">
      <input type="text" name="upsetting[cycle]" id="thinkwinds_link" value="{{ tw_value('cycle', $upsetting) }}" class="hstui-input hstui-length-6">
    <div class="hstui-form-input-tips" id="J_form_tips_cycle" data-tips="">{{ tw_lang('thinkwinds::manage.call.data.uptimes.tips') }}</div>
  </div>
</div>
@endif