<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Database\Seeds;

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('config')->delete();
        \DB::table('config')->insert([
                [   
                    'name' => 'name',
                    'namespace' => 'site',
                    'value' => '我的网站',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ],[
                    'name' => 'icp',
                    'namespace' => 'site',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'headerhtml',
                    'namespace' => 'site',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'footerhtml',
                    'namespace' => 'site',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'timezone',
                    'namespace' => 'site',
                    'value' => 'Asia/Shanghai',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'timecv',
                    'namespace' => 'site',
                    'value' => '0',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'vstate',
                    'namespace' => 'site',
                    'value' => '0',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'vmessage',
                    'namespace' => 'site',
                    'value' => '网站正关闭维护中，请稍微访问',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'vmtemplate',
                    'namespace' => 'site',
                    'value' => 'thinkwinds::common.close',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'url',
                    'namespace' => 'site',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'host',
                    'namespace' => 'email',
                    'value' => 'smtp.ym.163.com',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'port',
                    'namespace' => 'email',
                    'value' => '25',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'from',
                    'namespace' => 'email',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'from.name',
                    'namespace' => 'email',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'auth',
                    'namespace' => 'email',
                    'value' => '1',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'user',
                    'namespace' => 'email',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'password',
                    'namespace' => 'email',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'manage.request',
                    'namespace' => 'safe',
                    'value' => '1',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'manage.operation',
                    'namespace' => 'safe',
                    'value' => '1',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'manage.login.ips',
                    'namespace' => 'safe',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'manage.login.ctime',
                    'namespace' => 'safe',
                    'value' => '60',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'extsize',
                    'namespace' => 'attachment',
                    'value' => 'a:7:{s:3:"jpg";i:2048;s:3:"gif";i:2048;s:3:"png";i:2048;s:3:"bmp";i:2048;s:3:"xls";i:2048;s:4:"jpeg";i:2048;s:3:"zip";i:2048;}',
                    'vtype' => 'array',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'storage',
                    'namespace' => 'attachment',
                    'value' => 'local',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'dirs',
                    'namespace' => 'attachment',
                    'value' => 'ymd',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'key',
                    'namespace' => 'api',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'codelength',
                    'namespace' => 'sms',
                    'value' => '6',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'types',
                    'namespace' => 'sms',
                    'value' => 'a:3:{s:8:"register";a:2:{s:6:"status";i:1;s:7:"content";N;}s:5:"login";a:2:{s:6:"status";i:1;s:7:"content";N;}s:6:"findpw";a:2:{s:6:"status";i:1;s:7:"content";N;}}',
                    'vtype' => 'array',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'platform',
                    'namespace' => 'sms',
                    'value' => 'huasituo',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'hstsmsdaima',
                    'namespace' => 'sms',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'hstsmskey',
                    'namespace' => 'sms',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ], [
                    'name' => 'hstsmssign',
                    'namespace' => 'sms',
                    'value' => '',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ],[
                    'name' => 'width',
                    'namespace' => 'captcha',
                    'value' => '120',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ],[
                    'name' => 'height',
                    'namespace' => 'captcha',
                    'value' => '60',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ],[
                    'name' => 'length',
                    'namespace' => 'captcha',
                    'value' => '5',
                    'vtype' => 'string',
                    'desc' => '',
                    'issystem' => 1,
                    'module' => 'default'
                ]
            ]
        );
    }
}