<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
//安装路由器
Route::group([
    'domain'=> env('APP_URL') ,
    'prefix' => 'install',
    'middleware'=>['web']
], function() {
    Route::get('/', 'Install\InstallController@index')->name('thinkwinds.install.index');
    Route::post('/checkDatabase', 'Install\InstallController@checkDatabase')->name('thinkwinds.install.chack.database');
});
//测试路由
Route::group([
    'domain'=> env('APP_URL') ,
    'middleware'=>['web']
], function() {
    Route::get('/test', 'TestController@index')->name('thinkwinds.test.index');
    Route::get('/test/api', 'TestController@api')->name('thinkwinds.test.api');
    // Route::get('/test/captcha', 'TestController@captcha')->name('thinkwinds.test.captcha');
    // Route::post('/test/captcha/check', 'TestController@captchaCheck')->name('thinkwinds.test.captcha.check');
    // Route::post('/test/post', 'TestController@pindex')->name('thinkwinds.test.index.post');
});

//前台路由
Route::group([
    'domain'=> env('APP_URL') ,
    'middleware'=>['web']
], function() {
    Route::get('/close', 'PublicController@thinkwindsClose')->name('thinkwinds.close');
    //发送验证码和验证验证码
    Route::post('/mobile/code/send', 'MobileController@send')->name('thinkwinds.mobile.code.sed');
    Route::post('/mobile/code/verify', 'MobileController@verify')->name('thinkwinds.mobile.code.verify');
    //拉取图形验证码
    Route::get('/captcha/get', 'CaptchaController@get')->name('captcha.index.get');
    // //解密查看内容
    Route::post('/viewpw', 'PublicController@viewpw')->name('public.viewpw');
    Route::get('/public/field/type/html', 'PublicController@fieldsTypeHtml')->name('public.fields.type.html');
    Route::get('/public/topinyin', 'PublicController@topinyin')->name('public.topinyin');
    Route::get('/public/area/list', 'PublicController@getAreaSubList')->name('public.area.list');
    //开发调试
    Route::get('development/debugbar', 'Development\DebugbarController@index')->name('development.debugbar.index');
    //表单
    Route::get('/form/show/{id}', 'FormController@show')->name('thinwinds.form.show')->where('id', '[0-9]+');
    Route::post('/form/save', 'FormController@save')->name('thinwinds.form.content.save');
    // //上传入口
    Route::post('/upload/image/save', 'UploadController@imageSave')->name('upload.image.save');
    Route::post('/upload/save', 'UploadController@save')->name('upload.save');
    // //图片处理
    Route::get('/image/{aid}', 'ImageController@view')->name('image.view')->where('aid', '[0-9]+');
    Route::get('/image/{aid}/{type}/{width}/{height}', 'ImageController@resize')->name('image.resize');
    //单页多元化处理
    Route::get('/special/{id}', 'SpecialController@show')->name('thinkwinds.spcial.show')->where('id', '[0-9]+');
    Route::get('/special/{dir}', 'SpecialController@show')->name('thinkwinds.spcial.show.dir')->where('dir', '[0-9a-zA-Z\/]+');
    Route::get('/amap','AmapController@index')->name('amap.index');
    Route::get('/qrcode/generate','QrcodeController@generate')->name('qrcode.generate');
});

//后台路由
Route::group([
    'domain'=> config('thinkwinds.manage.route.domain'),
    'prefix' => config('thinkwinds.manage.route.domain') ? '' : config('thinkwinds.manage.route.prefix'),
    'middleware' => 'manage.request.log',
    'namespace'=>'Manage'
], function() {
    Route::get('/login', 'AuthController@login')->name('manage.auth.login');
    Route::post('/dologin', 'AuthController@dologin')->name('manage.auth.dologin');
    Route::get('/logout', 'AuthController@logout')->name('manage.auth.logout');
});

Route::group([
    'domain'=> config('thinkwinds.manage.route.domain'),
    'prefix' => config('thinkwinds.manage.route.domain') ? '' : config('thinkwinds.manage.route.prefix'),
    'middleware'=>['web','manage.auth.check', 'manage.request.log'],
    'namespace'=>'Manage'
], function() {
    //公共
    Route::get('/public/field/type/html', 'PublicController@fieldsTypeHtml')->name('manage.public.fields.type.html');
    Route::get('/public/topinyin', 'PublicController@topinyin')->name('manage.public.topinyin');
    Route::get('/public/area/list', 'PublicController@getAreaSubList')->name('manage.public.area.list');
    // //上传入口
    Route::post('/upload/image/save', 'UploadController@imageSave')->name('manage.upload.image.save');
    Route::post('/upload/save', 'UploadController@save')->name('manage.upload.save');
    //框架                                        
    Route::get('/', 'IndexController@index')->name('manage.index.index');    
    //首页
    Route::get('/home', 'IndexController@home')->name('manage.index.home'); 
    //锁屏功能
    Route::get('/locked', 'IndexController@locked')->name('manage.index.locked');  
    Route::post('/do/locked', 'IndexController@doLocked')->name('manage.index.doLocked');  
    Route::post('/unlocked', 'IndexController@unLocked')->name('manage.index.unLocked');  
    //常用设置
    Route::get('/custom/set', 'IndexController@customSet')->name('manage.index.customSet');  
    //修改资料
    Route::get('/user/info/edit/{uid}', 'IndexController@userInfoEdit')->name('manage.index.userInfoEdit');
    Route::post('/user/info/edit/save', 'IndexController@userInfoEditSave')->name('manage.index.userInfoEditSave');
    //创始人
    Route::get('/founder', 'FounderController@index')->name('manage.founder.index');
    Route::get('/founder/add', 'FounderController@add')->name('manage.founder.add');
    Route::post('/founder/add/save', 'FounderController@addSave')->name('manage.founder.addSave');
    Route::get('/founder/edit/{uid}', 'FounderController@edit')->name('manage.founder.edit')->where('uid', '[0-9]+');
    Route::post('/founder/edit/save', 'FounderController@editSave')->name('manage.founder.editSave');
    Route::any('/founder/delete/{uid}', 'FounderController@delete')->name('manage.founder.delete')->where('uid', '[0-9]+');
    //员工账号
    Route::get('/user', 'UserController@index')->name('manage.user.index');
    Route::get('/user/add', 'UserController@add')->name('manage.user.add');
    Route::post('/user/add/save', 'UserController@addSave')->name('manage.user.addSave');
    Route::get('/user/edit/{uid}', 'UserController@edit')->name('manage.user.edit')->where('uid', '[0-9]+');
    Route::post('/user/edit/save', 'UserController@editSave')->name('manage.user.editSave');
    Route::post('/user/delete/{uid}', 'UserController@delete')->name('manage.user.delete')->where('uid', '[0-9]+');
    //角色
    Route::get('/role/index', 'RoleController@index')->name('manage.role.index');
    Route::get('/role/add', 'RoleController@add')->name('manage.role.add');
    Route::post('/role/add/save', 'RoleController@addSave')->name('manage.role.addSave');
    Route::get('/role/edit/{id}', 'RoleController@edit')->name('manage.role.edit')->where('id', '[0-9]+');
    Route::post('/role/edit/save', 'RoleController@editSave')->name('manage.role.editSave');
    Route::post('/role/delete/{id}', 'RoleController@delete')->name('manage.role.delete')->where('id', '[0-9]+');
    //菜单
    Route::get('/menu/nav', 'MenuController@nav')->name('manage.menu.nav');
    Route::get('/menu/nav/add', 'MenuController@navAdd')->name('manage.menu.navAdd');
    Route::post('/menu/nav/add/save', 'MenuController@navAddSave')->name('manage.menu.navAddSave');
    Route::get('/menu/nav/edit/{id}', 'MenuController@navEdit')->name('manage.menu.navEdit')->where('id', '[0-9]+');
    Route::post('/menu/nav/edit/save', 'MenuController@navEditSave')->name('manage.menu.navEditSave');
    Route::post('/menu/nav/delete/{id}', 'MenuController@navDelete')->name('manage.menu.navDelete')->where('id', '[0-9]+');
    //权限点
    Route::get('/menu/role', 'MenuController@role')->name('manage.menu.role');
    Route::get('/menu/role/add', 'MenuController@roleAdd')->name('manage.menu.roleAdd');
    Route::post('/menu/role/add/save', 'MenuController@roleAddSave')->name('manage.menu.roleAddSave');
    Route::get('/menu/role/edit/{id}', 'MenuController@roleEdit')->name('manage.menu.roleEdit')->where('id', '[0-9]+');
    Route::post('/menu/role/edit/save', 'MenuController@roleEditSave')->name('manage.menu.roleEditSave');
    Route::post('/menu/role/delete/{id}', 'MenuController@roleDelete')->name('manage.menu.roleDelete')->where('id', '[0-9]+');
    //安全配置
    Route::get('/safe', 'SafeController@index')->name('manage.safe.index');
    Route::post('/safe/save', 'SafeController@save')->name('manage.safe.save');
    //日志
    Route::get('/log/request', 'LogController@logRequest')->name('manage.log.request');
    Route::get('/log/operation', 'LogController@logOperation')->name('manage.log.operation');
    Route::get('/log/operation/view/{id}', 'logController@logOperationView')->name('manage.log.operationView')->where('id', '[0-9]+');
    Route::get('/log/login', 'LogController@logLogin')->name('manage.log.login');
    //全局配置
    Route::get('/config/index', 'ConfigController@index')->name('manage.config.index');
    Route::post('/config/save', 'ConfigController@save')->name('manage.config.save');
    Route::get('/config/globals', 'ConfigController@globals')->name('manage.config.globals');
    Route::post('/config/globals/save', 'ConfigController@globalsSave')->name('manage.config.globalsSave');
    //邮箱配置
    Route::get('/config/email', 'EmailController@index')->name('manage.config.email.index');
    Route::post('/config/email/save', 'EmailController@save')->name('manage.config.email.save');
    Route::get('/config/email/test', 'EmailController@test')->name('manage.config.email.test');
    Route::post('/config/email/test/submit', 'EmailController@testSubmit')->name('manage.config.email.testSubmit');
    //FTP配置
    Route::get('/config/ftp', 'FtpController@index')->name('manage.config.ftp.index');
    Route::post('/config/ftp/save', 'FtpController@save')->name('manage.config.ftp.save');
    //短信服务
    Route::get('/sms/index', 'SmsController@index')->name('manage.sms.index');
    Route::post('/sms/save', 'SmsController@save')->name('manage.sms.save');
    Route::get('/sms/config', 'SmsController@config')->name('manage.sms.config');
    Route::post('/sms/config/save', 'SmsController@configSave')->name('manage.sms.configSave');
    Route::get('/sms/log', 'SmsController@log')->name('manage.sms.log');
    Route::get('/sms/log/view/{id}', 'SmsController@logView')->name('manage.sms.logView')->where('id', '[0-9]+');
    Route::get('/sms/cloud/config', 'SmsController@hstsmsConfig')->name('manage.sms.cloud.config');
    // Route::post('/sms/cloud/config/save', 'SmsController@hstsmsConfigSave')->name('manage.sms.cloud.configSave');
    // Route::get('/sms/cloud/buy', 'SmsController@hstsmsBuy')->name('manage.sms.cloud.buy');
    // Route::get('/sms/cloud/buy/submit', 'SmsController@hstsmsBuySubmit')->name('manage.sms.cloud.buySubmit');
    //附件服务
    Route::get('/attachments', 'AttachmentController@index')->name('manage.attachments.index');
    Route::post('/attachments/save', 'AttachmentController@save')->name('manage.attachments.save');
    Route::get('/attachments/manage', 'AttachmentController@manage')->name('manage.attachments.manage');
    Route::get('/attachments/view/{aid}', 'AttachmentController@view')->name('manage.attachments.view')->where('aid', '[0-9]+');
    //模块管理
    Route::get('/modules', 'ModulesController@index')->name('manage.modules.index');
    Route::get('/modules/uninstalls', 'ModulesController@uninstalls')->name('manage.modules.uninstalls');
    Route::post('/modules/doinstalls', 'ModulesController@doinstalls')->name('manage.modules.doinstalls');
    Route::post('/modules/enableds', 'ModulesController@enableds')->name('manage.modules.enableds');
    Route::any('/modules/douninstall', 'ModulesController@douninstall')->name('manage.modules.douninstall');
    Route::match(['get', 'post'], '/modules/cache', 'ModulesController@cache')->name('manage.modules.cache');
    //缓存管理
    Route::get('/caches', 'CachesController@index')->name('manage.caches.index');
    Route::post('/caches/save', 'CachesController@save')->name('manage.caches.save');
    Route::get('/caches/memcached/config', 'CachesController@memcachedConfig')->name('manage.caches.memcachedConfig');
    Route::post('/caches/memcached/config/save', 'CachesController@memcachedConfigSave')->name('manage.caches.memcachedConfigSave');
    Route::get('/caches/redis/config', 'CachesController@redisConfig')->name('manage.caches.redisConfig');
    Route::post('/caches/redis/config/save', 'CachesController@redisConfigSave')->name('manage.caches.redisConfigSave');
    //Widget 服务
    Route::get('/widget', 'WidgetController@index')->name('manage.widget.index');
    Route::get('/widget/add', 'WidgetController@add')->name('manage.widget.add');
    Route::post('/widget/add/save', 'WidgetController@addSave')->name('manage.widget.addSave');
    Route::get('/widget/edit/{name}', 'WidgetController@edit')->name('manage.widget.edit')->where(['name', '[0-9a-zA-Z_]']);
    Route::post('/widget/edit/save', 'WidgetController@editSave')->name('manage.widget.editSave');
    Route::post('/widget/delete/{name}', 'WidgetController@delete')->name('manage.widget.delete');
    Route::get('/widget/cache', 'WidgetController@cache')->name('manage.widget.cache');
    Route::get('/inject/{name}', 'WidgetInjectController@index')->name('manage.widget.inject.index');
    Route::get('/inject/{name}/add', 'WidgetInjectController@add')->name('manage.widget.inject.add');
    Route::post('/inject/{name}/add/save', 'WidgetInjectController@addSave')->name('manage.widget.inject.addSave');
    Route::get('/inject/{name}/edit/{id}', 'WidgetInjectController@edit')->name('manage.widget.inject.edit');
    Route::post('/inject/{name}/edit/save', 'WidgetInjectController@editSave')->name('manage.widget.inject.editSave');
    Route::post('/inject/{name}/delete/{id}', 'WidgetInjectController@delete')->name('manage.widget.inject.delete');
    //验证码服务
    Route::get('/captcha', 'CaptchaController@index')->name('manage.captcha.index');
    Route::post('/captcha/save', 'CaptchaController@save')->name('manage.captcha.save');
    //表单服务
    Route::get('/form', 'FormController@index')->name('manage.form.index');
    Route::get('/form/add', 'FormController@add')->name('manage.form.add');
    Route::post('/form/add/save', 'FormController@addSave')->name('manage.form.addSave');
    Route::get('/form/edit/{id}', 'FormController@edit')->name('manage.form.edit')->where('id', '[0-9]+');
    Route::post('/form/edit/save', 'FormController@editSave')->name('manage.form.editSave');
    Route::post('/form/cache', 'FormController@cache')->name('manage.form.cache');
    Route::post('/form/delete/{id}', 'FormController@delete')->name('manage.form.delete');
    // Route::get('/form/view/{id}', 'FormController@view')->name('manage.form.view');

    Route::get('/form/content/{formid}', 'FormController@content')->name('manage.form.content')->where('formid', '[0-9]+');
    Route::get('/form/content/add/{formid}', 'FormController@contentAdd')->name('manage.form.contentAdd')->where('formid', '[0-9]+');
    Route::post('/form/content/add/save/{formid}', 'FormController@contentAddSave')->name('manage.form.contentAddSave')->where('formid', '[0-9]+');
    Route::get('/form/content/edit/{formid}/{id}', 'FormController@contentEdit')->name('manage.form.contentEdit');
    Route::post('/form/content/edit/save/{formid}', 'FormController@contentEditSave')->name('manage.form.contentEditSave')->where('formid', '[0-9]+');
    Route::post('/form/content/delete/{formid}/{id}', 'FormController@contentDelete')->name('manage.form.contentDelete');
    //字段服务
    Route::get('/fields', 'FieldsController@index')->name('manage.fields.index');
    Route::post('/fields/save', 'FieldsController@save')->name('manage.fields.save');
    Route::get('/fields/add', 'FieldsController@add')->name('manage.fields.add');
    Route::post('/fields/add/save', 'FieldsController@addSave')->name('manage.fields.addSave');
    Route::get('/fields/edit/{id}', 'FieldsController@edit')->name('manage.fields.edit')->where('id', '[0-9]+');
    Route::post('/fields/edit/save', 'FieldsController@editSave')->name('manage.fields.editSave');
    Route::get('/fields/cache', 'FieldsController@cache')->name('manage.fields.cache');
    Route::post('/fields/delete/{id}', 'FieldsController@delete')->name('manage.fields.delete')->where('id', '[0-9]+');
    //单页服务
    Route::get('/special', 'SpecialController@index')->name('manage.special.index');
    Route::get('/special/add', 'SpecialController@add')->name('manage.special.add');
    Route::post('/special/save', 'SpecialController@addSave')->name('manage.special.addSave');
    Route::post('/special/cache', 'SpecialController@cache')->name('manage.special.cache');
    Route::get('/special/edit/{id}', 'SpecialController@edit')->name('manage.special.edit')->where('id', '[0-9]+');
    Route::post('/special/edit/save', 'SpecialController@editSave')->name('manage.special.editSave');
    Route::post('/special/delete/{id}', 'SpecialController@delete')->name('manage.special.delete')->where('id', '[0-9]+');
    //区域管理
    Route::get('/area', 'AreaController@index')->name('manage.area.index');
    Route::post('/area/cache', 'AreaController@cache')->name('manage.area.cache');
    Route::get('/area/add', 'AreaController@add')->name('manage.area.add');
    Route::post('/area/save', 'AreaController@addSave')->name('manage.area.addSave');
    Route::get('/area/edit/{areaid}', 'AreaController@edit')->name('manage.area.edit')->where('areaid', '[0-9]+');
    Route::post('/area/edit/save', 'AreaController@editSave')->name('manage.area.editSave');
    Route::post('/area/delete/{areaid}', 'AreaController@delete')->name('manage.area.delete')->where('areaid', '[0-9]+');
    //数据块
    Route::get('/block', 'BlockController@index')->name('manage.block.index');
    Route::get('/block/add', 'BlockController@add')->name('manage.block.add');
    Route::post('/block/add/save', 'BlockController@addSave')->name('manage.block.addSave');
    Route::get('/block/edit/{id}', 'BlockController@edit')->name('manage.block.edit')->where('id', '[0-9]+');
    Route::post('/block/edit/save', 'BlockController@editSave')->name('manage.block.editSave');
    Route::post('/block/delete/{id}', 'BlockController@delete')->name('manage.block.delete')->where('id', '[0-9]+');
    //数据调用中心
    Route::get('/call/block', 'CallController@block')->name('manage.call.block');
    Route::any('/call/block/add', 'CallController@blockAdd')->name('manage.call.block.add');
    Route::post('/call/block/add/save', 'CallController@blockAddSave')->name('manage.call.block.add.save');
    Route::get('/call/block/edit/{id}', 'CallController@blockEdit')->name('manage.call.block.edit');
    Route::post('/call/block/edit/save', 'CallController@blockEditSave')->name('manage.call.block.edit.save');
    Route::get('/call/block/delete/{id}', 'CallController@blockDelete')->name('manage.call.block.delete');

    Route::get('/call/block/data/{id}', 'CallController@blockData')->name('manage.call.block.data');
});