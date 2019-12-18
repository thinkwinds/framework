<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Database\Seeds;

use Illuminate\Database\Seeder;

class RoleUriTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('role_uri')->delete();
        \DB::table('role_uri')->insert([
            [
                'name' => '配置',
                'uri' => 'custom/set',
                'parent' => 'manage.index.customSet',
                'module' => 'manage',
                'ename' => 'manage.index.customSet',
                'remark' => '常用设置'
            ],[
                'name' => '保存',
                'uri' => 'custom/set/save',
                'parent' => 'manage.index.customSet',
                'module' => 'manage',
                'ename' => 'manage.index.customSet.save',
                'remark' => '常用设置'
            ],
            [
                'name' => '配置',
                'uri' => 'safe/index',
                'parent' => 'manage.safe.index',
                'module' => 'manage',
                'ename' => 'manage.safe.index',
                'remark' => '安全配置'
            ],[
                'name' => '保存',
                'uri' => 'safe/save',
                'parent' => 'manage.safe.index',
                'module' => 'manage',
                'ename' => 'manage.safe.save',
                'remark' => '安全配置'
            ],[
                'name' => '请求日志',
                'uri' => 'log/request',
                'parent' => 'manage.log.request',
                'module' => 'manage',
                'ename' => 'manage.log.request',
                'remark' => '日志管理'
            ],[
                'name' => '操作日志',
                'uri' => 'log/operation',
                'parent' => 'manage.log.request',
                'module' => 'manage',
                'ename' => 'manage.log.operation',
                'remark' => '日志管理'
            ],[
                'name' => '登录日志',
                'uri' => 'log/login',
                'parent' => 'manage.log.request',
                'module' => 'manage',
                'ename' => 'manage.log.login',
                'remark' => '日志管理'
            ],[
                'name' => '查看操作日志',
                'uri' => 'log/operation/view/{id}',
                'parent' => 'manage.log.request',
                'module' => 'manage',
                'ename' => 'manage.log.operationView',
                'remark' => '日志管理'
            ],[
                'name' => '管理',
                'uri' => 'founder/index',
                'parent' => 'manage.founder.index',
                'module' => 'manage',
                'ename' => 'manage.founder.index',
                'remark' => '创始人'
            ],[
                'name' => '添加',
                'uri' => 'founder/add',
                'parent' => 'manage.founder.index',
                'module' => 'manage',
                'ename' => 'manage.founder.add',
                'remark' => '创始人'
            ],[
                'name' => '添加保存',
                'uri' => 'founder/add/save',
                'parent' => 'manage.founder.index',
                'module' => 'manage',
                'ename' => 'manage.founder.addSave',
                'remark' => '创始人'
            ],[
                'name' => '编辑',
                'uri' => 'founder/edit/{uid}',
                'parent' => 'manage.founder.index',
                'module' => 'manage',
                'ename' => 'manage.founder.edit',
                'remark' => '创始人'
            ],[
                'name' => '编辑保存',
                'uri' => 'founder/edit/save',
                'parent' => 'manage.founder.index',
                'module' => 'manage',
                'ename' => 'manage.founder.editSave',
                'remark' => '创始人'
            ],[
                'name' => '删除',
                'uri' => 'founder/delete',
                'parent' => 'manage.founder.index',
                'module' => 'manage',
                'ename' => 'manage.founder.delete',
                'remark' => '创始人'
            ],[
                'name' => '管理',
                'uri' => 'user/index',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.user.index',
                'remark' => '工作人员'
            ],[
                'name' => '添加',
                'uri' => 'user/add',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.user.add',
                'remark' => '工作人员'
            ],[
                'name' => '添加保存',
                'uri' => 'user/add/save',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.user.addSave',
                'remark' => '工作人员'
            ],[
                'name' => '编辑',
                'uri' => 'user/edit/{id}',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.user.edit',
                'remark' => '工作人员'
            ],[
                'name' => '编辑保存',
                'uri' => 'user/edit/save',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.user.editSave',
                'remark' => '工作人员'
            ],[
                'name' => '删除',
                'uri' => 'user/delete',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.user.delete',
                'remark' => '工作人员'
            ],[
                'name' => '管理',
                'uri' => 'menu/nav',
                'parent' => 'manage.menu.nav',
                'module' => 'manage',
                'ename' => 'manage.menu.nav',
                'remark' => '菜单'
            ],[
                'name' => '添加',
                'uri' => 'menu/nav/add',
                'parent' => 'manage.menu.nav',
                'module' => 'manage',
                'ename' => 'manage.menu.navAdd',
                'remark' => '菜单'
            ],[
                'name' => '添加保存',
                'uri' => 'menu/nav/add/save',
                'parent' => 'manage.menu.nav',
                'module' => 'manage',
                'ename' => 'manage.menu.navAddSave',
                'remark' => '菜单'
            ],[
                'name' => '编辑',
                'uri' => 'menu/nav/edit/{id}',
                'parent' => 'manage.menu.nav',
                'module' => 'manage',
                'ename' => 'manage.menu.navEdit',
                'remark' => '菜单'
            ],[
                'name' => '编辑保存',
                'uri' => 'menu/nav/edit/save',
                'parent' => 'manage.menu.nav',
                'module' => 'manage',
                'ename' => 'manage.menu.navEditSave',
                'remark' => '菜单'
            ],[
                'name' => '删除',
                'uri' => 'menu/nav/delete',
                'parent' => 'manage.menu.nava',
                'module' => 'manage',
                'ename' => 'manage.menu.navDelete',
                'remark' => '菜单'
            ],[
                'name' => '角色',
                'uri' => 'role/index',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.role.index',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色添加',
                'uri' => 'role/add',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.role.add',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色添加保存',
                'uri' => 'role/add/save',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.role.addSave',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色编辑',
                'uri' => 'role/edit/{id}',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.role.edit',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色编辑保存',
                'uri' => 'role/edit/save',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.role.editSave',
                'remark' => '工作人员角色'
            ],[
                'name' => '角色删除',
                'uri' => 'role/delete/{id}',
                'parent' => 'manage.user.index',
                'module' => 'manage',
                'ename' => 'manage.role.delete',
                'remark' => '工作人员角色'
            ],[
                'name' => '邮箱配置',
                'uri' => 'config/email',
                'parent' => 'manage.config.email.index',
                'module' => 'manage',
                'ename' => 'manage.config.email.index',
                'remark' => '邮箱配置'
            ],[
                'name' => '保存',
                'uri' => 'config/email/save',
                'parent' => 'manage.config.email.index',
                'module' => 'manage',
                'ename' => 'manage.config.email.save',
                'remark' => '邮箱配置'
            ],[
                'name' => '测试',
                'uri' => 'config/email/test',
                'parent' => 'manage.config.email.index',
                'module' => 'manage',
                'ename' => 'manage.config.email.test',
                'remark' => '邮箱配置'
            ],[
                'name' => '测试发送',
                'uri' => 'config/email/test/submit',
                'parent' => 'manage.config.email.index',
                'module' => 'manage',
                'ename' => 'manage.config.email.testSubmit',
                'remark' => '邮箱配置'
            ],[
                'name' => 'FTP配置',
                'uri' => 'config/ftp',
                'parent' => 'manage.config.ftp.index',
                'module' => 'manage',
                'ename' => 'manage.config.ftp.index',
                'remark' => 'FTP配置'
            ],[
                'name' => '保存',
                'uri' => 'config/ftp/save',
                'parent' => 'manage.config.ftp.index',
                'module' => 'manage',
                'ename' => 'manage.config.ftp.save',
                'remark' => 'FTP配置'
            ]
        ]);
    }
}