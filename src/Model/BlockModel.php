<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Thinkwinds\Framework\Model\AttachmentModel;

class BlockModel extends Model
{
    protected $table = 'block';
    protected $fillable = [
        'id', 'name', 'isopen', 'content', 'type', 'times'
    ];
    // type：text/html/image/url
    public $timestamps = false;

    static function getInfo($id) 
    {
        if(!$id) 
        {
            return [];
        }
        $info = self::getCache($id);
        if(!$info) 
        {
            return [];
        }
        $info['times_str'] = tw_time2str($info['times']);
        $info['image'] = [];
        $info['attach'] = [];
        if($info['type'] == 'image') 
        {
            $info['image'] = unserialize($info['content']);
            $info['attach'] = $info['image']['image'] ? AttachmentModel::getAttach($info['image']['image']) : [];;
            $info['content'] = '';
        }
        return $info;
    }

    static function showBlock($id, $data = false)
    {
        $info = self::getInfo($id);
        if(!$info && $data == false) 
        {
            return '';
        }
        if(!$info && $data != false) 
        {
            return [];
        }
        if($data) {
            return $info;
        }
        if($info['type'] == 'image') 
        {
            $result = '<img src="'.$info['attach']['url'].'" title="'.$info['name'].'" alt="'.$info['name'].'"/>';
            if($info['image']['link']) 
            {
                $result = '<a href="'.$info['image']['link'].'">'.$result.'</a>';
            }
            return $result;
        } else {
            return $info['content'];
        }
    }

    static function getCache($id = 0) 
    {
        $cacheName = 'block:'.$id;
        if (!Cache::has($cacheName)) 
        {
            $info = self::setCache($id);
        } else {
            $info = Cache::get($cacheName, []);
        }
        return $info;
    } 

    static function setCache($id = 0) 
    {
        if($id > 0) 
        {
            $cacheName = 'block:'.$id;
            $info = BlockModel::where('id', $id)->first();
            if(!$info) 
            {
                return [];
            }
            Cache::forever($cacheName, $info);
            return $info;
        }
        $list = BlockModel::where('id', '>', 0)->get();
        if($list) 
        {
            foreach ($list as $key => $value) 
            {
                Cache::forever('block:'.$value['id'], $value);
            }
        }
        return true;
    }

    static function deleteBlock($id) 
    {
        $cacheName = 'block:'.$id;
        $result = BlockModel::where('id', $id)->delete();
        Cache::forget($cacheName);
        return $result;
    }
}