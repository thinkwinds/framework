<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
return [
    'title' => config('thinkwinds.name').'管理系统',
    'login.title' => '系统登录',
    'manage.system'=>'管理系统',
    'open.full.screen'=>'开启全屏',
    'close.full.screen'=>'退出全屏',
    'manage.home'=>'后台首页',
    'user.disable' => '用户已禁用',
    'user.disable.log' => '用户已禁用,系统强制退出',
    'ctime.logout' => '超时未操作,系统强制退出',
    'no.username'=>'该账号不存在',
    'founder.disable'=>'禁止',
    'founder.add'=>'添加创始人',
    'founder.edit'=>'更新创始人',
    'founder.user.edit'=>'更新工作人员',
    'founder.delete'=>'删除创始人',
    'founder.user.delete'=>'删除工作人员',
    'founder.delete.my'=>'不能删除自己',
    'founder.one'=>'至少留一位创始人',
    'founder.username.noone'=>'用户名已存在',
    'request.log' => '请求日志',
    'operation.log' => '操作日志',
    'login.log' => '登录日志',
    'image'=>'图片',
    'safe.setting' => '安全配置',
    'safe.login.ctime' => '登录超时',
    'safe.login.ips' => 'IP限制',
    'safe.login.ips.tips' => '此功能可绑定登录后台的 IP，只有在列表内的 IP 才能登录站点，创始人不受限制。<br>
可以绑定单个IP地址格式如:192.0.0.1，也可以绑定一段IP格式如:192.0.0，多个IP , 分隔。<br>当前IP：<e>'.tw_ip().'</e>',
    'safe.ip.no.auth'=>'当前IP无权限登录管理系统',
    'safe.update'=>'更新安全配置内容',
    'menu.nav.delete' => '删除权限导航',
    'menu.nav.add' => '添加权限导航',
    'menu.nav.edit' => '更新权限导航',
    'role.uri' => '权限点',
    'role.uri.add' => '添加权限点',
    'role.uri.edit' => '更新权限点',
    'role.uri.delete' => '删除权限点',
    'role.name.empty' => '角色名不能为空',
    'role.name.one' => '角色名已存在',
    'role.edit' => '编辑角色',
    'role.name' => '角色名称',
    'role.delete' => '删除角色',
    'role.delete.error.001' => '该角色正在使用，暂时无法删除',
    'enter.one.role.name' =>'请输入角色名称',
    'select.role' =>'请请选择角色',
    'config.site'=>'站点配置',
    'config.global'=>'全局配置',
    'config.email.update'=>'更新邮箱配置',
    'email.config' =>'邮箱配置',
    'email.test' =>'邮箱测试',
    'email.host' =>'SMTP服务器',
    'email.port' =>'SMTP端口',
    'email.from' =>'发信人地址',
    'email.from.name' =>'发信人昵称',
    'email.auth' =>'SMTP用户身份验证',
    'email.auth.tips' =>'如果SMTP服务器要求通过身份验证才可以发邮件，请选择"开启"。',
    'email.toemail' =>'收件人邮箱',
    'email.toemail.empty' =>'收件人邮箱不能为空',
    'email.toemail.error' =>'收件人邮箱错误',
    'email.content' =>'邮件内容',
    'email.test.content.tips' =>'<p style="height: 20px;line-height: 20px;">标题：测试邮件</p>
                <p style="height: 20px;line-height: 20px;">内容：恭喜您，如果您收到此邮件则代表后台邮件发送设置正确！</p>',
    'email.test.title' =>'测试邮件',
    'email.test.content' =>'恭喜您，如果您收到此邮件则代表后台邮件发送设置正确！',
    'email.test.success' =>'发送测试邮件[成功]',
    'email.test.error' =>'发送测试邮件[失败]',
    'sms.service'=>'短信服务',
    'sms.platform'=>'短信平台',
    'sms.selection.platform'=>'选择平台',
    'sms.plat.choose.error'=>'系统未选择短信平台',
    'sms.setting'=>'短信配置',
    'sms.send.log'=>'发送记录',
    'sms.tiaos'=>'剩余条数',
    'sms.daima'=>'账户代码',
    'sms.key'=>'App Secret',
    'sms.sign'=>'签名ID',
    'sms.purchase'=>'短信购买',
    'sms.hstsmsdaima.empty'=>'账户代码不能为空',
    'sms.log.no.error'=>'日志记录不存在',
    'sms.hstsmskey.empty'=>'key不能为空',
    'sms.hstsmssign.empty'=>'签名ID不能为空',
    'sms.code.length'=>'验证码长度',
    'sms.code.length.tips'=>'验证码长度不超过10位，默认：6位',
    'sms.product'=>'网站名称',
    'sms.product.tips'=>'网站名称，不允许符合，空格',
    'sms.hstsmsappid'=>'APPID',
    'sms.hstsmsappid.empty'=>'APPID不能为空',
    'sms.pay.money'=>'充值金额',
    'sms.pay.money.tips'=>'',
    'sms.register.tips'=>'开启后用户注册时需要经过手机号码验证。',
    'sms.login.tips'=>'开启后可以用手机号码登录。',
    'sms.findpw.tips'=>'开启后可以给用户发送短信验证码。',
    'sms.content.r'=>'支持参数：<br>{code}为手机验证码<br>{product}为站点名称',
    'sms.hstsms.seeting'=>'华思拓云短信配置',
    'huasituo.sms'=>'华思拓云短信',
    'huasituo.sms.tips'=>'华思拓云短信，<a href="http://sms.thinkwinds.com" target="_b">申请</a>',
    'config.global'=>'全局配置',
    'config.site'=>'网站配置',
    'site.name'=>'网站名称',
    'site.name.tips'=>'',
    'site.url'=>'站点URL网址',
    'site.url.tips'=>'http://或https://开头',
    'config.site.update'=>'更新网站配置',
    'config.global.update'=>'更新全局配置',
    'site.icp'=>'ICP备案号',
    'site.icp.tips'=>'请联系你的服务器运营商进行域名备案',
    'site.headerhtml'=>'顶部附加代码',
    'site.headerhtml.tips'=>'代码会放置head之间',
    'site.footerhtml'=>'底部附加代码',
    'site.footerhtml.tips'=>'代码会放置body结束之前',
    'site.status.setting'=>'站点状态设置',
    'site.visit.state'=>'访问状态',
    'site.visit.state0'=>'限制访问提示信息',
    'site.visit.state0.tips'=>'',
    'site.visit.message.template'=>'限制访问显示模板',
    'site.visit.message.template.tips'=>'如：模板是close.blade.php 请填写：close 。当站点处于完全关闭状态时，（如果该处填写则优先模板显示，模板存放在当前模板的views目录）',
    'default.timezone'=>'默认时区',
    'default.timezone.tips'=>'',
    'timecv'=>'服务器时间校正(秒)',
    'timecv.tips'=>'如果站点显示时间与服务器时间有差异，可用此功能进行微调',
    'debug'=>'DEBUG 模式运行站点',
    'debug.tips'=>'当站点运行出现错误或异常时，开启DEBUG模式显示程序错误报告信息。并及时将错误信息反馈给程序开发商，以便尽快得到解决, <a href="'.route('development.debugbar.index').'" target="_b">查看</a>',
    'attach.service'=>'附件管理',
    'attach.setting'=>'附件设置',
    'attach.storage'=>'附件存储',
    'attachment.local'=>'本地私有存储',
    'attachment.public'=>'本地公共存储',
    'attachment.ftp'=>'FTP 远程附件存储',
    'storage.dirs'=>'存储目录',
    'storage.dirs.tips'=>'默认：ymd',
    'attachment.extsize'=>'附件类型和尺寸控制',
    'attachment.extsize.tips'=>'系统限制上传单个附件的最大值：',
    'attachment.extsize.tips1'=>'后缀名(小写)',
    'attachment.extsize.tips2'=>'最大值(KB)',
    'attachment.extsize.add'=>'添加附件类型',
    'api.service'=>'Api服务',
    'api.log'=>'请求记录',
    'api.setting'=>'Api配置',
    'api.key'=>'key',
    'api.key.tips'=>'接口key,32位字符串，只允许有：数字、字母（不分大小写）',
    'modules.manage'=>'模块管理',
    'modules.uninstalls'=>'未安装模块',
    'modules.install.tips'=>'确定安装此模块吗？',
    'modules.no.ext'=>'模块不存在',
    'modules.install.donet'=>'请勿重复安装',
    'modules.uninstall.tips'=>'确定要卸载该模块吗',
    'caches.manage'=>'缓存管理',
    'caches.setting'=>'缓存驱动设置',
    'caches.driver'=>'缓存驱动',
    'selection.driver'=>'选择驱动',
    'caches.driver.file'=>'文件',
    'caches.driver.memcached.tips'=>'请配置memcached参数,<a class="" data-id="memcached" data-name="配置memcached参数" href="'.Route('manage.caches.memcachedConfig').'">[设置]</a>',
    'caches.memcached.setting'=>'memcached驱动配置',
    'caches.memcached.update'=>'更新memcached驱动配置',
    'caches.save.error.001'=>'请先设置memcached驱动配置',
    'caches.driver.redis.tips'=>'请配置redis参数,<a class="" data-id="redis" data-name="配置redis参数" href="'.Route('manage.caches.redisConfig').'">[设置]</a>',
    'caches.redis.setting'=>'redis驱动配置',
    'caches.redis.update'=>'更新redis驱动配置',
    'caches.save.error.002'=>'请先设置redis驱动配置',
    'account'=>'账户',
    'form'=>'表单',
    'form.add'=>'添加表单',
    'form.name'=>'表单名称',
    'form.table'=>'表单表名',
    'form.table.tips'=>'表名必须字母开头的，字母和数字组成',
    'form.email.notice'=>'通知邮箱',
    'form.mobile.notice'=>'通知手机号',
    'form.email.notice.tips'=>'填写后，有新数据将发送至该邮箱',
    'form.mobile.notice.tips'=>'填写后，有新数据手机号会收到提示',
    'form.field'=>'表字段',
    'form.content'=>'表单内容',
    'form.email.content'=>'邮件内容',
    'form.email.content.tips'=>'',
    'form.name.empty'=>'名称不能为空',
    'form.table.empty'=>'表单表名不能为空',
    'form.table.one'=>'表单表名已存在',
    'form.cache'=>'更新表单缓存',
    'form.delete'=>'删除表单',
    'form.no.info'=>'表信息不存在',
    'form.delete.msg'=>'确定要删除该表单吗',
    'fields.manage'=>'字段管理',
    'fields.add'=>'添加字段',
    'fields.cache'=>'更新字段缓存',
    'fields.name'=>'字段名称',
    'fields.namex.tips'=>'只能由英文字母、数字和下划线组成，并且仅能字母开头，不以下划线结尾',
    'fields.status.tips'=>'',
    'fields.issearch'=>'是否搜索',
    'fields.issearch.tips'=>'开启后前端开发是可以处理搜索功能',
    'fields.isedit'=>'禁止修改',
    'fields.isedit.tips'=>'提交之后将不能修改字段值',
    'fields.validator'=>'验证提示',
    'fields.validator.pattern'=>'正则验证',
    'fields.validator.tips'=>'当字段校验未通过时的提示信息，如“标题必须在80字以内”等等',
    'fields.isrequired.tips'=>'',
    'fields.name.tips'=>'为字段取个名字，例如：文档标题、作者、来源等等',
    'fields.ismember'=>'会员',
    'fields.ismember.tips'=>'是否会员可见信息',
    'fields.tips'=>'字段提示',
    'fields.tips.tips'=>'对字段简短的提示，来说明这个字段是用来干什么的',
    'fields.vieworder'=>'排序',
    'fields.vieworder.tips'=>'',
    'fields.type.tips'=>'',
    'fields.fieldtype'=>'字段类型',
    'fields.fieldtype.tips'=>'',
    'fields.type.width.tips'=>'[整数]表示固定宽带；[整数%]表示百分比',
    'fields.ispass'=>'密码模式',
    'fields.ispass.tips'=>'',
    'fields.default.value.001.tips'=>'默认内容',
    'fields.length.value'=>'字段类型长度',
    'fields.length.value.tips'=>'不懂填写的请不要填写，让系统自动默认',
    'fields.one'=>'字段已存在',
    'fields.name.empty'=>'名称不能为空',
    'fields.fieldname.empty'=>'字段名称不能为空',
    'fields.type.empty'=>'类型不能为空',
    'fields.update.vieworder'=>'更新列表信息',
    'fields.edit'=>'更新字段',
    'fields.validators'=>'数据验证',
    'fields.front.end.tips'=>'如果想前端表单或者会员中心不显示那么请选择"否"，否则选"是"',
    'fields.show'=>'数据显示',
    'fields.manage.content.list.show'=>'后台列表显示',
    'fields.manage.content.list.show.tips'=>'开启后，将显示于后台内容管理列表',
    'editor.admin'=>'后台编辑器',
    'editor.admin.tips'=>'后台编辑器',
    'editor.admin.tool'=>'工具',
    'editor.admin.tool.tips'=>"必须严格按照KindEditor工具栏格式：'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline','removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist','insertunorderedlist', '|', 'emoticons', 'image', 'link'",
    'editor.index'=>'后台编辑器',
    'editor.index.tips'=>'后台编辑器',
    'editor.index.tool'=>'工具',
    'editor.index.tool.tips'=>"必须严格按照KindEditor工具栏格式：'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline','removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist','insertunorderedlist', '|', 'emoticons', 'image', 'link'",
    'editor.type.001'=>'高级',
    'editor.type.002'=>'简单',
    'editor.type.003'=>'自定义',
    'editor.ispage'=>'是否翻页',
    'editor.source'=>'编辑模式',
    'editor.source.tips'=>'开启后编辑器可以切换代码模式',
    'special.manage'=>'单页管理',
    'special.add'=>'添加单页',
    'special.dir.tips'=>'目录只支持字母开头，字母数字斜杠组成的',
    'special.domain'=>'域名',
    'special.domain.tips'=>'如：http://new.thinkwinds.com  请不要加斜杠结尾，不可重复',
    'special.style'=>'模版',
    'special.style.tips'=>'如果模版是 page.blade.php 请填写 page,可以不填自动生成',
    'special.name.empty'=>'单页名称不能为空',
    'special.dir.empty'=>'单页目录不能为空',
    'seo.title'=>'标题',
    'seo.title.tips'=>'',
    'seo.keywords'=>'关键词',
    'seo.keywords.tips'=>'',
    'seo.description'=>'描述',
    'seo.description.tips'=>'',
    'special.header'=>'公共头部',
    'special.header.tips'=>'',
    'special.footer'=>'公共尾部',
    'special.footer.tips'=>'',
    'special.cache'=>'更新单页缓存',
    'special.edit'=>'单页修改',
    'special.delete'=>'删除单页',
    'special.dir.one'=>'目录已存在',
    'area.manage'=>'区域管理',
    'area.update'=>'更新',
    'area.zimu'=>'首字母',
    'area.update.success'=>'更新成功',
    'area.list'=>'下一级',
    'area.zip'=>'邮政编码',
    'area.delete'=>'删除地区',
    'area.delete.001'=>'请先删除下级区域',
    'area.areaid'=>'地区行政编码',
    'area.areaid.empty'=>'地区行政编码不能为空',
    'area.name.empty'=>'地区名称不能为空',
    'area.areaid.one'=>'地区行政编码不能重复',
    'area.add'=>'添加地区',
    'area.edit'=>'更新区域',
    'block'=>'数据块',
    'block.name.empty'=>'名称不能为空',
    'type.empty'=>'类型不能为空',
    'url.html'=>'链接结尾',
    'url.html.tips'=>'开启后详情阅读页面，以.html结尾',
    'url.dir'=>'链接目录化',
    'url.dir.tips'=>'开启后分类链接以目录形式显示',
    'url.dirs'=>'链接上级目录',
    'url.dirs.tips'=>'开启后分类链接目录形式以：上级目录/当前目录',

    'call.module'=>'数据模型',
    'call.type.select'=>'选择数据类别',
    'call.model.add.error.001'=>'请选择数据模型',
    'call.type'=>'数据类别',
    'call.选择数据类别.no'=>'数据块不存在',
    'call.block.edit'=>'属性',
    'call.block.data'=>'数据管理',
    'call.type.no'=>'数据类别不存在',
    'call.type.select.no'=>'请选择选择数据类别',
    'call.data.uptimes'=>'更新周期',
    'call.data.uptimes.tips'=>'分钟,0代表不更新',
    'call.block'=>'数据块管理',
    'call.block.add'=>'添加数据块',
    'call.block.name.empty'=>'数据块名称不能为空'
];
