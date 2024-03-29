<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    */
	'version'=>'1.0.0',
    /*
    |--------------------------------------------------------------------------
    | copys
    |--------------------------------------------------------------------------
    */
    'copys'=>'2020',
    /*
    |--------------------------------------------------------------------------
    | Name
    |--------------------------------------------------------------------------
    */
    'name'=>'ThinkWinds',
    /*
    |--------------------------------------------------------------------------
    | Website
    |--------------------------------------------------------------------------
    */
    'website'=>'https://www.thinkwinds.com',
    /*
    |--------------------------------------------------------------------------
    | res  https或http
    |--------------------------------------------------------------------------
    */
    'resurl'=>'http://res.softgold.co/webui',
    //'resurl'=> PHP_SAPI === 'cli' ? false : url('res'),
    /*
    |--------------------------------------------------------------------------
    | wap res  https或http
    |--------------------------------------------------------------------------
    */
    //'wapres'=>'http://res.wap.thinkwinds.com',
    'wapres'=> PHP_SAPI === 'cli' ? false : url('wap/res'),
    /*
    |--------------------------------------------------------------------------
    | api
    |--------------------------------------------------------------------------
    */
    'apiDomain'=>env('HSTCMS_API_DOMAIN', ''),
    /*
    |--------------------------------------------------------------------------
    | api prefix
    |--------------------------------------------------------------------------
    */
    'apiPrefix'=>env('HSTCMS_API_PREFIX', ''),
    /*
    |--------------------------------------------------------------------------
    | api sign
    |--------------------------------------------------------------------------
    */
    'apiSign'=>env('HSTCMS_API_SIGN', true),
    /*
    |--------------------------------------------------------------------------
    | crypt md5
    |--------------------------------------------------------------------------
    */
    'crypt'=>env('HSTCMS_CRYPT', false),
    /*
    |--------------------------------------------------------------------------
    | Manage
    |--------------------------------------------------------------------------
    */
    'manage'=> [
    	'route'=>[
		    /*
		    |--------------------------------------------------------------------------
		    | Manage Route Domain
		    |--------------------------------------------------------------------------
		    */
    		'domain'=> env('HSTCMS_MANAGE_ROUTE_DOMAIN', ''),
		    /*
		    |--------------------------------------------------------------------------
		    | Manage Route Prefix
		    |--------------------------------------------------------------------------
		    */
    		'prefix'=> env('HSTCMS_MANAGE_ROUTE_PREFIX', 'manage'),
    	]
    ],
    'captcha'=>[
        'width'=> env('CAPTCHA_WIDTH', 120),
        'height'=> env('CAPTCHA_HEIGHT', 60),
        'length'=> env('CAPTCHA_LENGTH', 5)
    ]
];
