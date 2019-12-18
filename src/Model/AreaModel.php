<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache; 
use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    protected $table = 'area';
    protected $fillable = [
        'areaid', 'name', 'joinname', 'parentid', 'vieworder', 'zip', 'initials'
    ];
    public $timestamps = false;

    static function getInfo($areaid = 0)
    {
        if(!$areaid) 
        {
            return [];
        }
        $cacheName = 'thinkwinds:area:info:'.$areaid;
        if (!Cache::has($cacheName)) 
        {
            $info = self::setCacheInfo($areaid);
        } else {
            $info = Cache::get($cacheName, []);
        }
        if(!$info) 
        {
            return [];
        }
        return $info;
    }

    static function setCacheInfo($areaid = 0)
    {
        $info = AreaModel::where('areaid', $areaid)->first();
        $cacheName = 'thinkwinds:area:info:'.$areaid;
        if($info) 
        {
            Cache::forever($cacheName, $info->toArray());
            return $info->toArray();
        }
        Cache::forever($cacheName, []);
        return [];
    }

    static function delCacheInfo($areaid = 0)
    {
        $cacheName = 'thinkwinds:area:info:'.$areaid;
        Cache::forget($cacheName);
    }

    static function updateData($areaid = 0, $data = []) 
    {
        if(!$areaid) 
        {
            return false;
        }
        AreaModel::firstOrCreate(['areaid' => $areaid]);
        AreaModel::where('areaid', $areaid)->update($data);
        return true;
    }

    static function getInfoByAreaid($areaid = 0, $subordinate = false)
    {
        $info = self::getInfo($areaid);
        if(!$info) 
        {
            return [];
        }
        if(!$info['parentid']) 
        {
            $data = [
                'areaid'=>$info['areaid'],
                'name'=>$info['name'],
                'joinname'=>$info['joinname'],
                'joinnames'=>explode('|', $info['joinname']),
                'joinids'=>[$areaid],
                'initials'=>$info['initials']
            ];
            if($subordinate) 
            {
                $data['sublist'] = self::getSubByAreaid($areaid, $subordinate);
            }
            return $data;
        }
        if($info['parentid']) {
            $pinfo = AreaModel::where('areaid', $info['parentid'])->select('areaid', 'parentid')->first();
            if(!$pinfo['parentid']) 
            {
                $data =  [
                    'areaid'=>$info['areaid'],
                    'name'=>$info['name'],
                    'joinname'=>$info['joinname'],
                    'joinnames'=>explode('|', $info['joinname']),
                    'joinids'=>[$info['parentid'], $areaid],
                    'initials'=>$info['initials']
                ];
                if($subordinate) 
                {
                    $data['sublist'] = self::getSubByAreaid($areaid, $subordinate);
                }
                return $data;
            }
            if($pinfo['parentid']) 
            {
                $ppinfo = AreaModel::where('areaid', $pinfo['parentid'])->select('areaid')->first();
                $data =  [
                    'areaid'=>$info['areaid'],
                    'name'=>$info['name'],
                    'joinname'=>$info['joinname'],
                    'joinnames'=>explode('|', $info['joinname']),
                    'joinids'=>[$ppinfo['areaid'], $info['parentid'], $areaid],
                    'initials'=>$info['initials']
                ];
                if($subordinate) 
                {
                    $data['sublist'] = self::getSubByAreaid($areaid, $subordinate);
                }
                return $data;
            }
        }
    }

    static function getSubByAreaid($areaid = 0, $sublist = false) 
    {
        $cacheName = 'thinkwinds:area:parentid:'.$areaid;
        if (!Cache::has($cacheName)) 
        {
            $data = self::setCacheSubByAreaid($areaid);
        } else {
            $data = Cache::get($cacheName, []);
        }
        if(!$data) 
        {
            return [];
        }
        if($sublist) 
        {
            foreach ($data as $key => $value) 
            {
                $data[$key]['sublist'] = self::getSubByAreaid($value['areaid'], $sublist);
            }
        }
        return $data;
    }

    static function setCacheSubByAreaid($areaid = 0)
    {
        $data = AreaModel::where('parentid', $areaid)->select('areaid', 'name', 'joinname', 'parentid', 'zip', 'initials')->get();
        $cacheName = 'thinkwinds:area:parentid:'.$areaid;
        if($data) 
        {
            Cache::forever($cacheName, $data->toArray());
            return $data->toArray();
        }
        Cache::forever($cacheName, []);
        return [];
    }

    static function getCacheCityAll()
    {
        $cacheName = 'thinkwinds:area:citys';
        if (!Cache::has($cacheName)) 
        {
            $data = self::setCacheCityAll();
        } else {
            $data = Cache::get($cacheName, []);
        }
        if(!$data) 
        {
            return [];
        }
        return $data;
    }

    static function setCacheCityAll() 
    {
        $list = self::getSubByAreaid(0);
        $areaids = [];
        foreach ($list as $key => $value) 
        {
            $areaids[] = $value['areaid'];
        }
        $cacheName = 'thinkwinds:area:citys';
        $data = AreaModel::whereIn('parentid', $areaids)->select('areaid', 'name', 'joinname', 'parentid', 'zip', 'initials')->get();
        if($data) 
        {
            Cache::forever($cacheName, $data->toArray());
            return $data->toArray();
        }
        Cache::forever($cacheName, []);
        return [];
    }
}
