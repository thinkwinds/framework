<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;

class ApiModel extends Model
{
    protected $table = 'api';
    protected $fillable = [
        'id', 'name', 'appid', 'secret', 'addtimes', 'edittimes', 'status'
    ];
    public $timestamps = false;

    static function setCache() 
    {
        $cacheName = 'thinkwinds:api';
        $data = ApiModel::where('id', '>', 0)->get();
        $cacheData = [];
        if($data)
        {
            foreach ($data as $key => $value) {
                $cacheData[$value['appid']] = [
                    'name'=>$value['name'],
                    'appid'=>$value['appid'],
                    'secret'=>$value['secret'],
                    'addtimes'=>$value['addtimes'],
                    'edittimes'=>$value['edittimes'],
                    'status'=>$value['status']
                ];
            }
        }
        Cache::forever($cacheName, $cacheData);
        return $cacheData;
    }
}