<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.special.editSave', ['module'=>$module]) }}" method="post">
    {!! tw_csrf() !!}
    <input type="hidden" name="id" value="{{ $id }}" id="thinkwinds_id">
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input onBlur="tw_topinyin('dir', 'name');" type="text" name="name" id="thinkwinds_name" value="{{ tw_value('name', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('dir')) hstui-form-error @endif" id="J_form_error_dir">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.dir') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="dir" id="thinkwinds_dir" value="{{ tw_value('dir', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_dir" data-tips="{{ tw_lang('thinkwinds::manage.special.dir.tips') }}">{{ tw_lang('thinkwinds::manage.special.dir.tips') }}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('domain')) hstui-form-error @endif" id="J_form_error_domain">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.special.domain') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="domain" id="thinkwinds_domain" value="{{ tw_value('domain', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_domain" data-tips="{!! tw_lang('thinkwinds::manage.special.domain.tips') !!}">{!! tw_lang('thinkwinds::manage.special.domain.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('style')) hstui-form-error @endif" id="J_form_error_style">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.special.style') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="style" id="thinkwinds_style" value="{{ tw_value('style', $info) }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_style" data-tips="{!! tw_lang('thinkwinds::manage.special.style.tips') !!}">{!! tw_lang('thinkwinds::manage.special.style.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isopen')) hstui-form-error @endif" id="J_form_error_isopen">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.status') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="isopen" id="thinkwinds_isopen" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.closes')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.opens')}}" data-hstui-switchx @if(old('isopen')) {{ tw_ifCheck(old('isopen')) }}@else {{ tw_ifCheck(tw_value('isopen', $info)) }} @endif data-switchx-text="isopen"/>
            <div class="hstui-form-input-tips" id="J_form_tips_isopen" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('header')) hstui-form-error @endif" id="J_form_error_header">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.special.header') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="header" id="thinkwinds_header" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.closes')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.opens')}}" data-hstui-switchx @if(old('header')) {{ tw_ifCheck(old('header')) }}@else {{ tw_ifCheck(tw_value('header', $info)) }} @endif data-switchx-text="header"/>
            <div class="hstui-form-input-tips" id="J_form_tips_header" data-tips="{!! tw_lang('thinkwinds::manage.special.header.tips') !!}">{!! tw_lang('thinkwinds::manage.special.header.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('footer')) hstui-form-error @endif" id="J_form_error_footer">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.special.footer') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="footer" id="thinkwinds_footer" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.closes')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.opens')}}" data-hstui-switchx @if(old('footer')) {{ tw_ifCheck(old('footer')) }}@else {{ tw_ifCheck(tw_value('footer', $info)) }} @endif data-switchx-text="footer"/>
            <div class="hstui-form-input-tips" id="J_form_tips_footer" data-tips="{!! tw_lang('thinkwinds::manage.special.footer.tips') !!}">{!! tw_lang('thinkwinds::manage.special.footer.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('content')) hstui-form-error @endif" id="J_form_error_content">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.content') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-textarea" style="height: 420px; width: 100%;" name="content" id="thinkwinds_content">{{ tw_value('content', $info) }}</textarea>
          </div>
        </div>
      </div>
      <div class="hstui-frame-title">SEO</div>
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('title')) hstui-form-error @endif" id="J_form_error_title">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.seo.title') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="title" id="thinkwinds_title" value="{{ tw_value('title', $info) }}" class="hstui-input hstui-length-6">
            <div class="hstui-form-input-tips" id="J_form_tips_title" data-tips="{!! tw_lang('thinkwinds::manage.seo.title.tips') !!}">{!! tw_lang('thinkwinds::manage.seo.title.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('keywords')) hstui-form-error @endif" id="J_form_error_keywords">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.seo.keywords') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
              <input type="text" name="keywords" id="thinkwinds_keywords" value="{{ tw_value('keywords', $info) }}" class="hstui-input hstui-length-6">
            <div class="hstui-form-input-tips" id="J_form_tips_keywords" data-tips="{!! tw_lang('thinkwinds::manage.seo.keywords.tips') !!}">{!! tw_lang('thinkwinds::manage.seo.keywords.tips') !!}</div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('description')) hstui-form-error @endif" id="J_form_error_description">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::manage.seo.description') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-input hstui-textarea hstui-length-6" style="height: 120px;" name="description" id="thinkwinds_description">{{ tw_value('description', $info) }}</textarea>
              <div class="hstui-form-input-tips" id="J_form_tips_description" data-tips="{!! tw_lang('thinkwinds::manage.seo.description.tips') !!}">{!! tw_lang('thinkwinds::manage.seo.description.tips') !!}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="hstui-form-button">
        <button class="hstui-button " id="J_dialog_close">{{ tw_lang('thinkwinds::public.cancel')}}</button>
        <button type="submit" class="hstui-button hstui-button-primary J_ajax_submit_btn">{{ tw_lang('thinkwinds::public.submit')}}</button>
    </div>
  </form>
<script>
Hstui.use('jquery','common', 'kindeditor',function() {
    Hstui.editer('#thinkwinds_content', {
      source:true
    });
});
</script>
</body>
</html>