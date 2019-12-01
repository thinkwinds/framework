<?php

//后台路由
Route::group([
    'domain'=> config('hstcms.manage.route.domain'),
    'prefix' => config('hstcms.manage.route.prefix').'/hook',
    'middleware'=>['web', 'manage.auth.check', 'manage.request.log']
], function() {
    Route::get('/', 'Manage\HookController@index')->name('manageHookIndex');
    Route::get('/add', 'Manage\HookController@add')->name('manageHookAdd');
    Route::post('/add/save', 'Manage\HookController@addSave')->name('manageHookAddSave');
    Route::get('/edit/{name}', 'Manage\HookController@edit')->name('manageHookEdit');
    Route::post('/edit/save', 'Manage\HookController@editSave')->name('manageHookEditSave');
    Route::post('/delete/{name}', 'Manage\HookController@delete')->name('manageHookDelete');
    Route::get('/cache', 'Manage\HookController@cache')->name('manageHookCache');

    Route::get('/inject/{name}', 'Manage\HookInjectController@index')->name('manageHookInjectIndex');
    Route::get('/inject/{name}/add', 'Manage\HookInjectController@add')->name('manageHookInjectAdd');
    Route::post('/inject/{name}/add/save', 'Manage\HookInjectController@addSave')->name('manageHookInjectAddSave');
    Route::get('/inject/{name}/edit/{id}', 'Manage\HookInjectController@edit')->name('manageHookInjectEdit');
    Route::post('/inject/{name}/edit/save', 'Manage\HookInjectController@editSave')->name('manageHookInjectEditSave');
    Route::post('/inject/{name}/delete/{id}', 'Manage\HookInjectController@delete')->name('manageHookInjectDelete');
});

//前台测试
Route::group([
    'domain'=> config('hstcms.manage.route.domain') ? env('APP_URL') : '' ,
    'prefix' => 'hook'
], function() {
    Route::get('/test', 'TestController@index')->name('hookTestIndex');
});


