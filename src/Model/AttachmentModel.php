<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Thinkwinds\Framework\Libraries\ThinkwindsStorage;

class AttachmentModel extends Model
{
    protected $table = 'attachments';
    protected $fillable = [
        'aid', 'name', 'type', 'size', 'path', 'ifthumb', 'uid', 'times', 'module', 'module_id', 'descrip', 'disk'
    ];
    public $timestamps = false;

    static function getStorages($k = '') 
    {
        $storages = [
            'local' => [
                'name'=>tw_lang('thinkwinds::manage.attachment.local'),
                'desc'=>'',
                'manageurl'=>''
            ],
            'public' => [
                'name'=>tw_lang('thinkwinds::manage.attachment.public'),
                'desc'=>'',
                'manageurl'=>''
            ],
            'ftp' => [
                'name'=>tw_lang('thinkwinds::manage.attachment.ftp'),
                'desc'=>'',
                'manageurl'=>''
            ]
        ];
        $storages = thinkwinds_widget('s_attachment', $storages, true);
        if($k) 
        {
            return isset($storages[$k]) ? $storages[$k] : [];
        }
        return $storages;
    }

    static function getAttach($aid = 0)
    {
        if(!$aid) 
        {
            return [];
        }
        $cacheName = 'thinkwinds:attachment:info:'.$aid;
        if (!Cache::has($cacheName)) 
        {
            $info = self::setCacheInfo($aid);
        } else {
            $info = Cache::get($cacheName, []);
        }
        if(!$info) 
        {
            return [];
        }
        $info['url'] = tw_storage_url($info['path'], $info['disk']);
        return $info;
    }

    static function setCacheInfo($aid = 0)
    {
        $info = AttachmentModel::where('aid', $aid)->first();
        $cacheName = 'thinkwinds:attachment:info:'.$aid;
        if($info) 
        {
            Cache::forever($cacheName, $info->toArray());
            return $info->toArray();
        }
        return [];
    }

    static function delCacheInfo($aid = 0)
    {
        $cacheName = 'thinkwinds:attachment:info:'.$aid;
        Cache::forget($cacheName);
    }

    static function getAttachs($aids = [])
    {
        if(!$aids) 
        {
            return [];
        }
        foreach ($aids as $aid) 
        {
            $attachs[] = self::getAttach($aid);
        }
        return $attachs;
    }

    static function deleteAttach($aid) 
    {
        $attachInfo = AttachmentModel::where('aid', $aid)->first();
        if($attachInfo) 
        {
            $thinkwindsStorage = new ThinkwindsStorage();
            $thinkwindsStorage->disk = $attachInfo['disk'];
            $thinkwindsStorage->delete($attachInfo['path']);
            AttachmentModel::where('aid', $aid)->delete();
        }
        return true;
    }

    static function deleteAttachByAppId($module = '', $module_id) 
    {
        $attachs = AttachmentModel::where('module', $module)->where('module_id', $module_id)->select('aid')->get();
        if($attachs) {
            foreach ($attachs as $key => $value) {
                self::deleteAttach($value['aid']);
            }
        }
        return true;
    }

    static function updateAttach($aid, $module_id)
    {
        $postData = [
            'module_id'=>$module_id
        ];
        AttachmentModel::where('aid', $aid)->update($postData);
    }

    static function setTempData($tempid = '', $aid = 0)
    {
        if(!$tempid || !$aid) 
        {
            return true;
        }
        $cacheName = 'thinkwinds:attachment:temp:'.$tempid;
        $data = Cache::get($cacheName, []);
        array_push($data, $aid);
        Cache::forever($cacheName, $data);
        return true;
    }

    static function delTempData($tempid = '')
    {
        if(!$tempid) 
        {
            return true;
        }
        $cacheName = 'thinkwinds:attachment:temp:'.$tempid;
        Cache::forget($cacheName);
        return true;
    }
}