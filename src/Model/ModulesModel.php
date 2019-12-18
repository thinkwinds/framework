<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;

class ModulesModel extends Model
{
    protected $table = 'modules';
    protected $fillable = [
        'name', 'slug', 'description', 'times', 'version', 'enabled'
    ];
    public $timestamps = false;

    static function getData()
    {
        if (!Cache::has('thinkwinds:modules')) 
        {
            $data = self::setCache();
        } else {
            $data = Cache::get('thinkwinds:modules');
        }
        return $data;
    }

    static function setCache($result = true) 
    {
        $cacheData = [];
        $data = ModulesModel::where('id', '>', '0')->get();
        if($data) 
        {
            foreach ($data as $key => $value) 
            {
                $cacheData[$key] = [
                    'id'=>trim($value['id']),
                    'name'=>trim($value['name']),
                    'slug'=>trim($value['slug']),
                    'description'=>$value['description'],
                    'times'=>$value['times'],
                    'version'=>$value['version'],
                    'enabled'=>$value['enabled'],
                    'setting'=>tw_config('md'.$value['slug'])
                ];
            }
        }
        Cache::forget('thinkwinds:modules');
        Cache::forever('thinkwinds:modules', $cacheData);
        if(!$result) 
        {
            unset($cacheData);
            return '';
        }
        return $cacheData;
    }
}