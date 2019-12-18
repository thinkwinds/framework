<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Widget;

/**
* 
*/
class ConfigWidget 
{
	/**
     * 后台菜单钩子
     *
     * @param array $data 菜单数组
     * @return array
     */
    public function getManageMenu($data)
    {
        $data['content'] = [
            'name' => tw_lang('thinkwinds::public.content'),
            'ename' => 'content',
            'icon' => '',
            'url' => '',
            'parent' => 'system',
            'parents' => '',
            'level' => 2,
            'module' => 'thinkwinds'
        ];
        $data['manage.widget.index'] = [
            'name' => 'Widget',
            'ename' => 'manage.widget.index',
            'icon' => '',
            'url' => 'manage.widget.index',
            'parent' => 'system',
            'parents' => 'tool',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        $data['manage.sms.index'] = [
            'name' => tw_lang('thinkwinds::manage.sms.service'),
            'ename' => 'manage.sms.index',
            'icon' => '',
            'url' => 'manage.sms.index',
            'parent' => 'system',
            'parents' => 'config',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        $data['manage.attachments.index'] = [
            'name' => tw_lang('thinkwinds::manage.attach.service'),
            'ename' => 'manage.attachments.index',
            'icon' => '',
            'url' => 'manage.attachments.index',
            'parent' => 'system',
            'parents' => 'config',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        // $data['manageApi'] = [
        //     'name' => tw_lang('thinkwinds::manage.api.service'),
        //     'ename' => 'manageApi',
        //     'icon' => '',
        //     'url' => 'manageApi',
        //     'parent' => 'system',
        //     'parents' => 'tool',
        //     'level' => 3,
        //     'module' => 'thinkwinds'
        // ];
        $data['manage.modules.index'] = [
            'name' => tw_lang('thinkwinds::manage.modules.manage'),
            'ename' => 'manage.modules.index',
            'icon' => '',
            'url' => 'manage.modules.index',
            'parent' => 'system',
            'parents' => 'tool',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        $data['manage.caches.index'] = [
            'name' => tw_lang('thinkwinds::manage.caches.manage'),
            'ename' => 'manage.caches.index',
            'icon' => '',
            'url' => 'manage.caches.index',
            'parent' => 'system',
            'parents' => 'tool',
            'level' => 3,
            'module' => 'thinkwinds'
        ];

        $data['manage.captcha.index'] = [
            'name' => tw_lang('thinkwinds::captcha.name'),
            'ename' => 'manage.captcha.index',
            'icon' => '',
            'url' => 'manage.captcha.index',
            'parent' => 'system',
            'parents' => 'config',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        $data['manage.form.index'] = [
            'name' => tw_lang('thinkwinds::manage.form').tw_lang('thinkwinds::public.manage'),
            'ename' => 'manage.form.index',
            'icon' => '',
            'url' => 'manage.form.index',
            'parent' => 'system',
            'parents' => 'content',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        $data['manage.special.index'] = [
            'name' => tw_lang('thinkwinds::manage.special.manage'),
            'ename' => 'manage.special.index',
            'icon' => '',
            'url' => 'manage.special.index',
            'parent' => 'system',
            'parents' => 'content',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        $data['manage.area.index'] = [
            'name' => tw_lang('thinkwinds::manage.area.manage'),
            'ename' => 'manage.area.index',
            'icon' => '',
            'url' => 'manage.area.index',
            'parent' => 'system',
            'parents' => 'config',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        $data['manage.block.index'] = [
            'name' => tw_lang('thinkwinds::manage.block'),
            'ename' => 'manage.block.index',
            'icon' => '',
            'url' => 'manage.block.index',
            'parent' => 'system',
            'parents' => 'content',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        $data['manage.call.block'] = [
            'name' => tw_lang('thinkwinds::manage.call.block'),
            'ename' => 'manage.call.block',
            'icon' => '',
            'url' => 'manage.call.block',
            'parent' => 'system',
            'parents' => 'content',
            'level' => 3,
            'module' => 'thinkwinds'
        ];
        return $data;
    }

    /**
     * 后台权限点
     *
     * @param array $data 数组
     * @return array
     */
    public function getRoleUri(array $data)
    {
        $data['manage.widget.index'] = [
            'name' => tw_lang('thinkwinds::public.manage'),
            'remark' => 'widget',
            'ename' => 'manage.widget.index',
            'uri' => 'widget',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetAdd'] = [
            'name' => tw_lang('thinkwinds::public.add'),
            'remark' => 'widget',
            'ename' => 'manageWidgetAdd',
            'uri' => 'widget/add',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetAddSave'] = [
            'name' => tw_lang('thinkwinds::public.add', 'thinkwinds::public.save'),
            'remark' => 'widget',
            'ename' => 'manageWidgetAddSave',
            'uri' => 'widget/add/save',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetEdit'] = [
            'name' => tw_lang('thinkwinds::public.edit'),
            'remark' => 'widget',
            'ename' => 'manageWidgetEdit',
            'uri' => 'widget/edit/{name}',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetEditSave'] = [
            'name' => tw_lang('thinkwinds::public.edit', 'thinkwinds::public.save'),
            'remark' => 'widget',
            'ename' => 'manageWidgetEditSave',
            'uri' => 'widget/edit/save',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetDelete'] = [
            'name' => tw_lang('thinkwinds::public.delete'),
            'remark' => 'widget',
            'ename' => 'manageWidgetDelete',
            'uri' => 'widget/delete/{name}',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetCache'] = [
            'name' => tw_lang('thinkwinds::public.cache'),
            'remark' => 'widget',
            'ename' => 'manageWidgetCache',
            'uri' => 'widget/cache',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetInjectIndex'] = [
            'name' => tw_lang('thinkwinds::public.manage'),
            'remark' => 'Widget Inject',
            'ename' => 'manageWidgetInjectIndex',
            'uri' => 'widget/inject/{name}',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetInjectIndex'] = [
            'name' => tw_lang('thinkwinds::public.add'),
            'remark' => 'Widget Inject',
            'ename' => 'manageWidgetInjectIndex',
            'uri' => 'widget/inject/{name}/add',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetInjectIndex'] = [
            'name' => tw_lang('thinkwinds::public.add', 'thinkwinds::public.save'),
            'remark' => 'Widget Inject',
            'ename' => 'manageWidgetInjectIndex',
            'uri' => 'widget/inject/{name}/add/save',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetInjectIndex'] = [
            'name' => tw_lang('thinkwinds::public.edit'),
            'remark' => 'Widget Inject',
            'ename' => 'manageWidgetInjectIndex',
            'uri' => 'widget/inject/{name}/edit/{id}',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetInjectIndex'] = [
            'name' => tw_lang('thinkwinds::public.edit', 'thinkwinds::public.save'),
            'remark' => 'Widget Inject',
            'ename' => 'manageWidgetInjectIndex',
            'uri' => 'widget/inject/{name}/edit/save',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manageWidgetInjectDelete'] = [
            'name' => tw_lang('thinkwinds::public.delete'),
            'remark' => 'Widget Inject',
            'ename' => 'manageWidgetInjectDelete',
            'uri' => 'widget/inject/{name}/delete/{id}',
            'parent' => 'manage.widget.index',
            'module' => 'manage'
        ];
        $data['manage.sms.index'] = [
            'name' => tw_lang('thinkwinds::manage.sms.service'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.sms.index',
            'uri' => 'sms',
            'parent' => 'manage.sms.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.sms.save'] = [
            'name' => tw_lang('thinkwinds::manage.sms.service').tw_lang('thinkwinds::public.save'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.sms.save',
            'uri' => 'sms/save',
            'parent' => 'manage.sms.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.attachments.index'] = [
            'name' => tw_lang('thinkwinds::manage.attach.service'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.attachments.index',
            'uri' => 'attachments',
            'parent' => 'manage.attachments.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.attachments.save'] = [
            'name' => tw_lang('thinkwinds::manage.attach.service').tw_lang('thinkwinds::public.save'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.attachments.save',
            'uri' => 'attachments/save',
            'parent' => 'manage.attachments.index',
            'module' => 'thinkwinds'
        ];
        $data['manageApi'] = [
            'name' => tw_lang('thinkwinds::manage.api.service'),
            'remark' => 'thinkwinds',
            'ename' => 'manageApi',
            'uri' => 'api',
            'parent' => 'manageApi',
            'module' => 'thinkwinds'
        ];
        $data['manageApiSave'] = [
            'name' => tw_lang('thinkwinds::manage.api.service').tw_lang('thinkwinds::public.save'),
            'remark' => 'thinkwinds',
            'ename' => 'manageApiSave',
            'uri' => 'api/save',
            'parent' => 'manageApi',
            'module' => 'thinkwinds'
        ];
        $data['manage.config.index'] = [
            'name' => tw_lang('thinkwinds::manage.config.site'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.config.index',
            'uri' => 'index',
            'parent' => 'manage.config.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.config.save'] = [
            'name' => tw_lang('thinkwinds::manage.config.site').tw_lang('thinkwinds::public.save'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.config.save',
            'uri' => 'save',
            'parent' => 'manage.config.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.config.globals'] = [
            'name' => tw_lang('thinkwinds::manage.config.global'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.config.globals',
            'uri' => 'index',
            'parent' => 'manage.config.globals',
            'module' => 'thinkwinds'
        ];
        $data['manage.config.globalsSave'] = [
            'name' => tw_lang('thinkwinds::manage.config.global').tw_lang('thinkwinds::public.save'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.config.globalsSave',
            'uri' => 'index',
            'parent' => 'manage.config.globals',
            'module' => 'thinkwinds'
        ];
        $data['manage.modules.index'] = [
            'name' => tw_lang('thinkwinds::public.manage'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.modules.index',
            'uri' => 'modules',
            'parent' => 'manage.modules.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.modules.uninstalls'] = [
            'name' => tw_lang('thinkwinds::manage.modules.uninstalls'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.modules.uninstalls',
            'uri' => 'modules/uninstalls',
            'parent' => 'manage.modules.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.modules.doinstalls'] = [
            'name' => tw_lang('thinkwinds::public.install'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.modules.doinstalls',
            'uri' => 'modules/doinstalls',
            'parent' => 'manage.modules.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.modules.enableds'] = [
            'name' => tw_lang('thinkwinds::public.operation'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.modules.enableds',
            'uri' => 'modules/enableds',
            'parent' => 'manage.modules.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.modules.douninstall'] = [
            'name' => tw_lang('thinkwinds::public.uninstall'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.modules.douninstall',
            'uri' => 'modules/douninstall',
            'parent' => 'manage.modules.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.modules.cache'] = [
            'name' => tw_lang('thinkwinds::public.cache'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.modules.cache',
            'uri' => 'modules/cache',
            'parent' => 'manage.modules.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.caches.index'] = [
            'name' => tw_lang('thinkwinds::manage.caches.manage'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.caches.index',
            'uri' => 'caches',
            'parent' => 'manage.caches.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.caches.save'] = [
            'name' => tw_lang('thinkwinds::public.save'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.caches.save',
            'uri' => 'caches/save',
            'parent' => 'manage.caches.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.caches.memcachedConfig'] = [
            'name' => tw_lang('thinkwinds::manage.caches.memcached.setting'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.caches.memcachedConfig',
            'uri' => '/caches/memcached/config',
            'parent' => 'manage.caches.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.caches.memcachedConfigSave'] = [
            'name' => tw_lang('thinkwinds::public.save', 'thinkwinds::manage.caches.memcached.setting'),
            'remark' => 'thinkwinds',
            'ename' => 'manage.caches.memcachedConfigSave',
            'uri' => 'index',
            'parent' => 'manage.caches.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.captcha.index'] = [
            'name' => tw_lang('thinkwinds::captcha.name'),
            'remark' => 'captcha',
            'ename' => 'manage.captcha.index',
            'uri' => 'captcha/index',
            'parent' => 'manage.captcha.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.captcha.save'] = [
            'name' => tw_lang('thinkwinds::captcha.save'),
            'remark' => 'captcha',
            'ename' => 'manage.captcha.save',
            'uri' => 'captcha/save',
            'parent' => 'manage.captcha.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.index'] = [
            'name' => tw_lang('thinkwinds::public.manage'),
            'remark' => 'form',
            'ename' => 'manage.form.index',
            'uri' => 'form/index',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.add'] = [
            'name' => tw_lang('thinkwinds::public.add'),
            'remark' => 'form',
            'ename' => 'manage.form.add',
            'uri' => 'form/add',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.addSave'] = [
            'name' => tw_lang('thinkwinds::public.add').tw_lang('thinkwinds::public.save'),
            'remark' => 'form',
            'ename' => 'manage.form.addSave',
            'uri' => 'form/save',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.edit'] = [
            'name' => tw_lang('thinkwinds::public.edit'),
            'remark' => 'form',
            'ename' => 'manage.form.edit',
            'uri' => 'form/edit/{id}',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.editSave'] = [
            'name' => tw_lang('thinkwinds::public.edit').tw_lang('thinkwinds::public.save'),
            'remark' => 'form',
            'ename' => 'manage.form.editSave',
            'uri' => 'form/edit/save',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.delete'] = [
            'name' => tw_lang('thinkwinds::public.delete'),
            'remark' => 'form',
            'ename' => 'manage.form.delete',
            'uri' => 'form/delete/{id}',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.content'] = [
            'name' => tw_lang('thinkwinds::manage.form.content').tw_lang('thinkwinds::public.manage'),
            'remark' => 'form',
            'ename' => 'manage.form.content',
            'uri' => 'form/content/{formid}',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.contentAdd'] = [
            'name' => tw_lang('thinkwinds::manage.form.content').tw_lang('thinkwinds::public.add'),
            'remark' => 'form',
            'ename' => 'manage.form.contentAdd',
            'uri' => 'form/content/add/{formid}',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.contentAddSave'] = [
            'name' => tw_lang('thinkwinds::manage.form.content').tw_lang('thinkwinds::public.add', 'thinkwinds::public.save'),
            'remark' => 'form',
            'ename' => 'manage.form.contentAddSave',
            'uri' => 'form/content/add/save/{formid}',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.contentEdit'] = [
            'name' => tw_lang('thinkwinds::manage.form.content').tw_lang('thinkwinds::public.edit'),
            'remark' => 'form',
            'ename' => 'manage.form.contentEdit',
            'uri' => 'form/content/edit/{formid}/{id}',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.contentEditSave'] = [
            'name' => tw_lang('thinkwinds::manage.form.content').tw_lang('thinkwinds::public.edit', 'thinkwinds::public.save'),
            'remark' => 'form',
            'ename' => 'manage.form.contentEditSave',
            'uri' => 'form/content/edit/save/{formid}',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.form.contentDelete'] = [
            'name' => tw_lang('thinkwinds::manage.form.content').tw_lang('thinkwinds::public.delete'),
            'remark' => 'form',
            'ename' => 'manage.form.contentDelete',
            'uri' => 'form/content/delete/{formid}/{id}',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.fields.index'] = [
            'name' => tw_lang('thinkwinds::public.field').tw_lang('thinkwinds::public.manage'),
            'remark' => 'form',
            'ename' => 'manage.fields.index',
            'uri' => 'fields',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.fields.save'] = [
            'name' => tw_lang('thinkwinds::public.field').tw_lang('thinkwinds::public.save'),
            'remark' => 'form',
            'ename' => 'manage.fields.save',
            'uri' => 'fields/save',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.fields.add'] = [
            'name' => tw_lang('thinkwinds::public.field').tw_lang('thinkwinds::public.add'),
            'remark' => 'form',
            'ename' => 'manage.fields.add',
            'uri' => 'fields/add',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.fields.addSave'] = [
            'name' => tw_lang('thinkwinds::public.field').tw_lang('thinkwinds::public.add','thinkwinds::public.save'),
            'remark' => 'form',
            'ename' => 'manage.fields.addSave',
            'uri' => 'fields/add/save',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.fields.edit'] = [
            'name' => tw_lang('thinkwinds::public.field').tw_lang('thinkwinds::public.edit'),
            'remark' => 'form',
            'ename' => 'manage.fields.edit',
            'uri' => 'fields/edit',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.fields.editSave'] = [
            'name' => tw_lang('thinkwinds::public.field').tw_lang('thinkwinds::public.edit','thinkwinds::public.save'),
            'remark' => 'form',
            'ename' => 'manage.fields.editSave',
            'uri' => 'fields/edit/save',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.fields.cache'] = [
            'name' => tw_lang('thinkwinds::public.field').tw_lang('thinkwinds::public.cache'),
            'remark' => 'form',
            'ename' => 'manage.fields.cache',
            'uri' => 'fields/cache',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.fields.delete'] = [
            'name' => tw_lang('thinkwinds::public.field').tw_lang('thinkwinds::public.delete'),
            'remark' => 'form',
            'ename' => 'manage.fields.delete',
            'uri' => 'fields/delete',
            'parent' => 'manage.form.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.special.index'] = [
            'name' => tw_lang('thinkwinds::manage.special.manage'),
            'remark' => 'special',
            'ename' => 'manage.special.index',
            'uri' => 'special',
            'parent' => 'manage.special.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.special.cache'] = [
            'name' => tw_lang('thinkwinds::public.cache'),
            'remark' => 'special cache',
            'ename' => 'manage.special.cache',
            'uri' => 'special/cache',
            'parent' => 'manage.special.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.special.add'] = [
            'name' => tw_lang('thinkwinds::public.add'),
            'remark' => 'special add',
            'ename' => 'manage.special.add',
            'uri' => 'special/add',
            'parent' => 'manage.special.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.special.addSave'] = [
            'name' => tw_lang('thinkwinds::public.add','thinkwinds::public.save'),
            'remark' => 'special add save',
            'ename' => 'manage.special.addSave',
            'uri' => 'special/add/save',
            'parent' => 'manage.special.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.special.edit'] = [
            'name' => tw_lang('thinkwinds::public.edit'),
            'remark' => 'special edit',
            'ename' => 'manage.special.edit',
            'uri' => 'special/edit/{id}',
            'parent' => 'manage.special.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.special.editSave'] = [
            'name' => tw_lang('thinkwinds::public.edit','thinkwinds::public.save'),
            'remark' => 'special edit save',
            'ename' => 'manage.special.editSave',
            'uri' => 'special/edit/save',
            'parent' => 'manage.special.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.special.delete'] = [
            'name' => tw_lang('thinkwinds::public.delete'),
            'remark' => 'special delete',
            'ename' => 'manage.special.delete',
            'uri' => 'special/delete/{id}',
            'parent' => 'manage.special.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.area.index'] = [
            'name' => tw_lang('thinkwinds::manage.area.manage'),
            'remark' => 'area',
            'ename' => 'manage.area.index',
            'uri' => 'area',
            'parent' => 'manage.area.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.area.add'] = [
            'name' => tw_lang('thinkwinds::public.add'),
            'remark' => 'area add',
            'ename' => 'manage.area.add',
            'uri' => 'area/add',
            'parent' => 'manage.area.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.area.addSave'] = [
            'name' => tw_lang('thinkwinds::public.add','thinkwinds::public.save'),
            'remark' => 'area add save',
            'ename' => 'manage.area.addSave',
            'uri' => 'area/add/save',
            'parent' => 'manage.area.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.area.edit'] = [
            'name' => tw_lang('thinkwinds::public.edit'),
            'remark' => 'area edit',
            'ename' => 'manage.area.edit',
            'uri' => 'area/edit/{areaid}',
            'parent' => 'manage.area.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.area.editSave'] = [
            'name' => tw_lang('thinkwinds::public.edit','thinkwinds::public.save'),
            'remark' => 'area edit save',
            'ename' => 'manage.area.editSave',
            'uri' => 'area/edit/save',
            'parent' => 'manage.area.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.special.delete'] = [
            'name' => tw_lang('thinkwinds::public.delete'),
            'remark' => 'area delete',
            'ename' => 'manage.area.delete',
            'uri' => 'area/delete/{areaid}',
            'parent' => 'manage.area.index',
            'module' => 'thinkwinds'
        ];

        $data['manage.block.index'] = [
            'name' => tw_lang('thinkwinds::manage.block'),
            'remark' => 'block',
            'ename' => 'manage.block.index',
            'uri' => 'block',
            'parent' => 'manage.block.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.block.add'] = [
            'name' => tw_lang('thinkwinds::public.add'),
            'remark' => 'block add',
            'ename' => 'manage.block.add',
            'uri' => 'block/add',
            'parent' => 'manage.block.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.block.addSave'] = [
            'name' => tw_lang('thinkwinds::public.add','thinkwinds::public.save'),
            'remark' => 'block add save',
            'ename' => 'manage.block.addSave',
            'uri' => 'block/add/save',
            'parent' => 'manage.block.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.block.edit'] = [
            'name' => tw_lang('thinkwinds::public.edit'),
            'remark' => 'block edit',
            'ename' => 'manage.block.edit',
            'uri' => 'block/edit/{areaid}',
            'parent' => 'manage.block.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.block.editSave'] = [
            'name' => tw_lang('thinkwinds::public.edit','thinkwinds::public.save'),
            'remark' => 'block edit save',
            'ename' => 'manage.block.editSave',
            'uri' => 'block/edit/save',
            'parent' => 'manage.block.index',
            'module' => 'thinkwinds'
        ];
        $data['manage.block.delete'] = [
            'name' => tw_lang('thinkwinds::public.delete'),
            'remark' => 'block delete',
            'ename' => 'manage.block.delete',
            'uri' => 'block/delete/{areaid}',
            'parent' => 'manage.block.index',
            'module' => 'thinkwinds'
        ];

        $data['manage.call.block'] = [
            'name' => tw_lang('thinkwinds::manage.call.block'),
            'remark' => 'block',
            'ename' => 'manage.call.block',
            'uri' => 'call/block',
            'parent' => 'manage.call.block',
            'module' => 'thinkwinds'
        ];
        $data['manage.call.block.add'] = [
            'name' => tw_lang('thinkwinds::public.add'),
            'remark' => 'block add',
            'ename' => 'manage.call.block.add',
            'uri' => 'call/block/add',
            'parent' => 'manage.call.block',
            'module' => 'thinkwinds'
        ];
        $data['manage.call.block.addSave'] = [
            'name' => tw_lang('thinkwinds::public.add','thinkwinds::public.save'),
            'remark' => 'block add save',
            'ename' => 'manage.call.block.addSave',
            'uri' => 'call/block/add/save',
            'parent' => 'manage.call.block',
            'module' => 'thinkwinds'
        ];
        $data['manage.call.block.edit'] = [
            'name' => tw_lang('thinkwinds::public.edit'),
            'remark' => 'block edit',
            'ename' => 'manage.call.block.edit',
            'uri' => 'call/block/edit/{areaid}',
            'parent' => 'manage.call.block',
            'module' => 'thinkwinds'
        ];
        $data['manage.call.block.editSave'] = [
            'name' => tw_lang('thinkwinds::public.edit','thinkwinds::public.save'),
            'remark' => 'block edit save',
            'ename' => 'manage.call.block.editSave',
            'uri' => 'call/block/edit/save',
            'parent' => 'manage.call.block',
            'module' => 'thinkwinds'
        ];
        $data['manage.call.block.delete'] = [
            'name' => tw_lang('thinkwinds::public.delete'),
            'remark' => 'block delete',
            'ename' => 'manage.call.block.delete',
            'uri' => 'call/block/delete/{areaid}',
            'parent' => 'manage.call.block',
            'module' => 'thinkwinds'
        ];
        $data['manage.call.block.data'] = [
            'name' => tw_lang('thinkwinds::public.data'),
            'remark' => 'block data',
            'ename' => 'manage.call.block.data',
            'uri' => 'call/block/data/{areaid}',
            'parent' => 'manage.call.block',
            'module' => 'thinkwinds'
        ];
        return $data;
    }
}