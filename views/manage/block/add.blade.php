<!doctype html>
<html>
<head>
@include('thinkwinds::manage.common.head')
</head>
<body>
  <form class="hstui-form hstui-form-horizontal J_ajaxForm" action="{{ route('manage.block.addSave', ['module'=>$module]) }}" method="post">
    {!! tw_csrf() !!}
    <div class="hstui-frame">
      <div class="hstui-frame-content">
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('name')) hstui-form-error @endif" id="J_form_error_name">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.name') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="name" id="thinkwinds_name" value="{{ tw_value('name') }}" class="hstui-input hstui-length-5">
            <div class="hstui-form-input-tips" id="J_form_tips_name" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('type')) hstui-form-error @endif" id="J_form_error_type">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.type') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
             <input type="radio" onchange="clickType('text')" name="type" value="text" checked> 
             <label>文本</label>
             <input type="radio" onchange="clickType('html')" name="type" value="html"> 
             <label>html</label>
             <input type="radio" onchange="clickType('image')" name="type" value="image"> 
             <label>图片</label>
            <div class="hstui-form-input-tips" id="J_form_tips_type" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('isopen')) hstui-form-error @endif" id="J_form_error_isopen">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.status') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="checkbox" name="isopen" id="thinkwinds_isopen" data-class="hstui-switchx-default hstui-round hstui-fl hstui-mr-sm" data-switchx-offtext="{{ tw_lang('thinkwinds::public.closes')}}" data-switchx-ontext="{{ tw_lang('thinkwinds::public.opens')}}" data-hstui-switchx @if(old('isopen')) {{ tw_ifCheck(old('isopen')) }}@else checked @endif data-switchx-text="isopen"/>
            <div class="hstui-form-input-tips" id="J_form_tips_isopen" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm hstui-hide @if($errors->has('image')) hstui-form-error @endif" id="J_form_error_image">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.image') }}</label>
          <div class="hstui-u-sm-10  hstui-form-input">
            <div class="hstui-upload J_upload"></div>
            <div class="hstui-form-input-tips" id="J_form_tips_image" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm hstui-hide @if($errors->has('link')) hstui-form-error @endif" id="J_form_error_link">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.url') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <input type="text" name="link" id="thinkwinds_link" value="{{ tw_value('link') }}" class="hstui-input hstui-length-6">
            <div class="hstui-form-input-tips" id="J_form_tips_link" data-tips=""></div>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm @if($errors->has('content')) hstui-form-error @endif" id="J_form_error_content">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.content') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-textarea" style="height: 420px; width: 100%;" name="content" id="thinkwinds_content"></textarea>
          </div>
        </div>
        <div class="hstui-form-group hstui-form-group-sm hstui-hide @if($errors->has('contentv')) hstui-form-error @endif" id="J_form_error_contentv">
          <label class="hstui-u-sm-2 hstui-form-label">{{ tw_lang('thinkwinds::public.content') }}</label>
          <div class="hstui-u-sm-10 hstui-form-input">
              <textarea class="hstui-textarea" style="height: 420px; width: 100%;" name="contentv" id="thinkwinds_contentv"></textarea>
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
Hstui.use('jquery','common', 'upload', 'kindeditor', function() {
    Hstui.editer('#thinkwinds_contentv', {
      source:true
    });
    $(".J_upload").hstuiUpload({  
      fileName: 'filedata',
      fName: 'image',
      isedit: true,
      multi:false,
      url: '{{ route('manage.upload.image.save') }}',
      dataList: [],
      formParam: {
        upapp: 'block',
        _token: $("input[name='_token']").val()
      }
    });
});
function clickType(t) 
{
  if(t=='text') {
      $("#J_form_error_image").addClass('hstui-hide');
      $("#J_form_error_link").addClass('hstui-hide');
      $("#J_form_error_contentv").addClass('hstui-hide');
      $("#J_form_error_content").removeClass('hstui-hide');
  } else if(t=='html') {
      $("#J_form_error_image").addClass('hstui-hide');
      $("#J_form_error_link").addClass('hstui-hide');
      $("#J_form_error_content").addClass('hstui-hide');
      $("#J_form_error_contentv").removeClass('hstui-hide');
  } else if(t == 'image') {
      $("#J_form_error_content").addClass('hstui-hide');
      $("#J_form_error_contentv").addClass('hstui-hide');
      $("#J_form_error_image").removeClass('hstui-hide');
      $("#J_form_error_link").removeClass('hstui-hide');
  }
}
</script>
</body>
</html>