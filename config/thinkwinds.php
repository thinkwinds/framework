<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    */
    'version'=>'1.0.0',
    /*
    |--------------------------------------------------------------------------
    | Hook
    |--------------------------------------------------------------------------
    */
    'default'=> [
        'hookList'=>[
            's_test_arr'=>[
                'name'=>'s_test_arr', 
                'description'=>'测试数组返回钩子', 
                'document'=>'@param array
@return array', 
                'module'=>'system'
            ],
            's_test_html'=>[
                'name'=>'s_test_html', 
                'description'=>'测试html输出钩子', 
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
            's_common_role_uri'=>[
                'name'=>'s_common_role_uri', 
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
                'description'=>'头部公共钩子，用于输出JS、css、html等代码在body开始前', 
                'document'=>'@param no
@return html', 
                'module'=>'system'
            ],
            's_footer'=>[
                'name'=>'s_footer', 
                'description'=>'底部公共钩子，用于输出JS、css、html等代码在body结束前', 
                'document'=>'@param no
@return html', 
                'module'=>'system'
            ],
        ],
        'hookInject'=>[
            's_test_arr'=>[
                [
                    'hook_name' => 's_test_arr',
                    'alias' => 'hook1',
                    'files' => 'Huasituo\Hook\Hooks',
                    'class' => 'TestHook',
                    'fun' => 'test1',
                    'description'=>'',
                ],
                [
                    'hook_name' => 's_test_arr',
                    'alias' => 'hook2',
                    'files' => 'Huasituo\Hook\Hooks',
                    'class' => 'TestHook',
                    'fun' => 'test2',
                    'description'=>'',
                ]
            ],
            's_test_html'=>[
                [
                    'hook_name' => 's_test_html',
                    'alias' => 'hook1',
                    'files' => 'Huasituo\Hook\Hooks',
                    'class' => 'TestHook',
                    'fun' => 'test3',
                    'description'=>'',
                ],
                [
                    'hook_name' => 's_test_html',
                    'alias' => 'hook2',
                    'files' => 'Huasituo\Hook\Hooks',
                    'class' => 'TestHook',
                    'fun' => 'test4',
                    'description'=>'',
                ]
            ],
            's_manage_menu'=>[
                [
                    'hook_name' => 's_manage_menu',
                    'alias' => 'manage',
                    'files' => 'Huasituo\Hook\Hooks',
                    'class' => 'ConfigHook',
                    'fun' => 'getManageMenu',
                    'description'=>'',
                ]
            ],
            's_common_role_uri'=>[
                [
                    'hook_name' => 's_common_role_uri',
                    'alias' => 'manage',
                    'files' => 'Huasituo\Hook\Hooks',
                    'class' => 'ConfigHook',
                    'fun' => 'getCommonRoleUri',
                    'description'=>'',
                ]
            ]
        ]
    ]
];