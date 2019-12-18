<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/manage', function (Request $request) {
   
// })->middleware('auth:api');

Route::group([
    'middleware'=>['api.service']
], function() {
	Route::get('/test', 'TestController@index')->name('thinkwinds.api.test');
	Route::post('/test', 'TestController@index')->name('thinkwinds.api.test.post');
});

Route::group([
    'middleware'=>['api.service']
], function() {
    Route::get('/mobile/code/send', 'MobileController@send')->name('api.mobile.code.send');
    Route::get('/area/list', 'AreaController@list')->name('api.area.list');
    Route::get('/area/citys', 'AreaController@citys')->name('api.area.citys');
    Route::get('/area/get/id/by/name', 'AreaController@getId')->name('api.area.get.id');
});
