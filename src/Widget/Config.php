<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
return [
    'widgetList'=>[
        's_test_arr'=>[
            'name'=>'s_test_arr', 
            'description'=>'测试数组返回', 
            'document'=>'@param array
@return array', 
            'module'=>'system'
        ],
        's_test_html'=>[
            'name'=>'s_test_html', 
            'description'=>'测试html输出', 
            'document'=>'@param no
@return html', 
            'module'=>'system'
        ],
        's_manage_menu'=>[
            'name'=>'s_manage_menu', 
            'description'=>'管理中心菜单导航', 
            'document'=>'@param array
@return array', 
            'module'=>'system'
        ],
        's_role_uri'=>[
            'name'=>'s_role_uri', 
            'description'=>'管理中心权限点', 
            'document'=>'@param array
@return array', 
            'module'=>'system'
        ],
        's_cache'=>[
            'name'=>'s_cache', 
            'description'=>'缓存', 
            'document'=>'', 
            'module'=>'system'
        ],
        's_head'=>[
            'name'=>'s_head', 
            'description'=>'头部公共，用于输出JS、css、html等代码在body开始前', 
            'document'=>'@param no
@return html', 
            'module'=>'system'
        ],
        's_footer'=>[
            'name'=>'s_footer', 
            'description'=>'底部公共，用于输出JS、css、html等代码在body结束前', 
            'document'=>'@param no
@return html', 
            'module'=>'system'
        ],
        's_sms'=>[
            'name'=>'s_sms', 
            'description'=>'短信服务平台', 
            'document'=>'@param array
@return array', 
            'module'=>'system'
        ],
        's_sms_types'=>[
            'name'=>'s_sms_types', 
            'description'=>'短信服务类型', 
            'document'=>'@param array
@return array', 
            'module'=>'system'
        ],
        's_attachment'=>[
            'name'=>'s_attachment', 
            'description'=>'附件存储', 
            'document'=>'@param array
@return array', 
            'module'=>'system'
        ]
    ],
    'widgetInject'=>[
        's_test_arr'=>[
            [
                'widget_name' => 's_test_arr',
                'alias' => 'widget1',
                'files' => 'Thinkwinds\Framework\Widget',
                'class' => 'TestWidget',
                'fun' => 'test1',
                'description'=>'',
            ],
            [
                'widget_name' => 's_test_arr',
                'alias' => 'widget2',
                'files' => 'Thinkwinds\Framework\Widget',
                'class' => 'TestWidget',
                'fun' => 'test2',
                'description'=>'',
            ]
        ],
        's_test_html'=>[
            [
                'widget_name' => 's_test_html',
                'alias' => 'widget1',
                'files' => 'Thinkwinds\Framework\Widget',
                'class' => 'TestWidget',
                'fun' => 'test3',
                'description'=>'',
            ],
            [
                'widget_name' => 's_test_html',
                'alias' => 'widget2',
                'files' => 'Thinkwinds\Framework\Widget',
                'class' => 'TestWidget',
                'fun' => 'test4',
                'description'=>'',
            ]
        ],
        's_manage_menu'=>[
            [
                'widget_name' => 's_manage_menu',
                'alias' => 'manage',
                'files' => 'Thinkwinds\Framework\Widget',
                'class' => 'ConfigWidget',
                'fun' => 'getManageMenu',
                'description'=>'',
            ]
        ],
        's_role_uri'=>[
            [
                'widget_name' => 's_role_uri',
                'alias' => 'manage',
                'files' => 'Thinkwinds\Framework\Widget',
                'class' => 'ConfigWidget',
                'fun' => 'getRoleUri',
                'description'=>'',
            ]
        ],
        's_sms'=>[
            [
                'widget_name' => 's_sms',
                'alias' => 'manage',
                'files' => 'Thinkwinds\Framework\Widget',
                'class' => 'ConfigWidget',
                'fun' => 'getSmsPlatform',
                'description' => ''
            ]
        ]
    ]
];