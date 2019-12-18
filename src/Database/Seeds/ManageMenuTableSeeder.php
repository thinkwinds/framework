<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Database\Seeds;

use Illuminate\Database\Seeder;

class ManageMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('manage_menu')->delete();
        \DB::table('manage_menu')->insert([
            [
                'name' => '系统配置',
                'ename' => 'system',
                'icon' => '',
                'url' => '',
                'parent' => 'root',
                'parents' => '',
                'level' => 1,
                'module' => 'manage'
            ],
            [
                'name' => '管理中心',
                'ename' => 'manage',
                'icon' => '',
                'url' => '',
                'parent' => 'system',
                'parents' => '',
                'level' => 2,
                'module' => 'manage'
            ],
            [
                'name' => '创始人',
                'ename' => 'manage.founder.index',
                'icon' => '',
                'url' => 'manage.founder.index',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '工作人员',
                'ename' => 'manage.user.index',
                'icon' => '',
                'url' => 'manage.user.index',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '安全配置',
                'ename' => 'manage.safe.index',
                'icon' => '',
                'url' => 'manage.safe.index',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '日志管理',
                'ename' => 'manage.log.request',
                'icon' => '',
                'url' => 'manage.log.request',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '菜单权限',
                'ename' => 'manage.menu.nav',
                'icon' => '',
                'url' => 'manage.menu.nav',
                'parent' => 'system',
                'parents' => 'manage',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '全局',
                'ename' => 'config',
                'icon' => '',
                'url' => '',
                'parent' => 'system',
                'parents' => '',
                'level' => 2,
                'module' => 'manage'
            ],
            [
                'name' => tw_lang('thinkwinds::manage.config.site'),
                'ename' => 'manage.config.index',
                'icon' => '',
                'url' => 'manage.config.index',
                'parent' => 'system',
                'parents' => 'config',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => tw_lang('thinkwinds::manage.config.global'),
                'ename' => 'manage.config.globals',
                'icon' => '',
                'url' => 'manage.config.globals',
                'parent' => 'system',
                'parents' => 'config',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '电子邮箱',
                'ename' => 'manage.config.email.index',
                'icon' => '',
                'url' => 'manage.config.email.index',
                'parent' => 'system',
                'parents' => 'config',
                'level' => 3,
                'module' => 'manage'
            ],
            [
                'name' => '工具',
                'ename' => 'tool',
                'icon' => '',
                'url' => '',
                'parent' => 'system',
                'parents' => '',
                'level' => 2,
                'module' => 'manage'
            ]
        ]);
    }
}