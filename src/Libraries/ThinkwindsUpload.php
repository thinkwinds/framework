<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

use Illuminate\Support\Facades\DB;
use League\Flysystem\Util\MimeType;
use Illuminate\Support\Facades\Storage;
use Thinkwinds\Framework\Model\AttachmentModel;

class ThinkwindsUpload
{
    public $saveDir = '';
    public $allowExtsizes = [];
    public $app = 'system';

    public $fileName = '';
    public $fileSize = 0;
    public $extension = '';
    public $clientName = '';
    public $file = '';
    public $tempid = '';
    public $aid = '';
    public $uid = 0;

    public $disks = 'public';

    public function __construct() 
    {
        self::setStorage();
    }

    public function setStorage($disks = '')
    {
        if($disks) {
            $this->disks = $disks;
            return $this;
        }
        $this->disks = tw_config('attachment', 'storage');
    }

    public function setAid($aid = '')
    {
        $this->aid = $aid;
        return $this;
    }

    public function setUid($uid = '')
    {
        $this->uid = $uid;
        return $this;
    }

    public function  setFile($file)
    {
        if(!$file) {
            return tw_message('no file');
        }
        $this->file = $file;
        $attachmentConfig = tw_config('attachment');
        $this->extension = $file->getClientOriginalExtension();
        $this->fileSize = $file->getClientSize();
        $this->clientName = $file->getClientOriginalName();
        $extsizes = array_keys($attachmentConfig['extsize']);
        //判断文件上传过程中是否出错
        if ($file->isValid()) 
        {
            $mimeType = MimeType::getExtensionToMimeTypeMap();
            if (!empty($extsizes)) 
            {
                if (!in_array($this->extension, $extsizes)) 
                {
                    return tw_message('thinkwinds::public.file.type.is.not.allowed.to.upload');
                }
            }
            if (isset($this->allowExtension) && $this->allowExtension) 
            {
                foreach ($this->allowExtension as $item) 
                {
                    if (!in_array(FileClass::getMimeTypeByExtension($item), $mimeType)) 
                    {
                        return tw_message('thinkwinds::public.file.type.is.not.allowed.to.upload');
                    }
                }
            }
            if (!in_array($file->getMimeType(), $mimeType)) 
            {
                return tw_message('thinkwinds::public.unknown.file.type');
            }
            $attachmentConfig['extsize'][$this->extension] = isset($attachmentConfig['extsize'][$this->extension]) ? $attachmentConfig['extsize'][$this->extension] : 2048;
            if ($this->fileSize > $file->getMaxFilesize() || $this->fileSize > $attachmentConfig['extsize'][$this->extension] * 1024) 
            {
                return tw_message('thinkwinds::public.upload.files.beyond.the server.size.limit');
            }
            $this->setDirs();
            $this->setFileName();
            return $this;
        }
        return tw_message('thinkwinds::public.upload.error');
    }

    public function setExtsize($allowExtsizes = []) 
    {
        $this->allowExtsizes = $allowExtsizes;
        return $this;
    }

    public function setDirs($dir = '') 
    {
        if($dir) {
            $this->saveDir = $dir;
            return $this;
        }
        $attachmentConfig = tw_config('attachment');
        $storagedir = isset($attachmentConfig['dirs']) ? $attachmentConfig['dirs'] : 'ymd';
        $sdir = '';
        switch ($storagedir) 
        {
            case 'y':
                $sdir = tw_time2str(tw_time(), 'Y');
                break;
            case 'ym':
                $sdir = tw_time2str(tw_time(), 'Y/m');
                break;
            default:
                $sdir = tw_time2str(tw_time(), 'Y/m/d');
                break;
        }
        if($this->app != 'system') 
        {
            $this->saveDir =  $this->app.'/'.$sdir;
        } else {
            $this->saveDir = $sdir;
        }
        return $this;
    }

    public function setFileName($name = '') 
    {
        if($name) 
        {
            $this->fileName = $name . '.' . $this->extension;
            return $this;
        }
        $this->fileName = md5((substr($this->clientName, 0, (strlen($this->clientName) - strlen($this->extension) - 1))) . time()) . '.' . $this->extension;
        return $this;
    }

    public function setTempId($tempid = '')
    {
        $this->tempid = $tempid;
        return $this;
    }

    public function doSave() 
    {
        //判断文件上传过程中是否出错
        if ($this->file->isValid()) 
        {
            $status = Storage::disk($this->disks)->putFileAs($this->saveDir, $this->file, $this->fileName);
            if($status) {
                return true;
            }
        }
        return tw_message('thinkwinds::public.upload.error');
    }

    public function getData ()
    {
        $postData = [
            'name'=>$this->clientName,
            'type'=>$this->extension,
            'size'=>$this->fileSize,
            'path'=>$this->saveDir .'/'. $this->fileName,
            'ifthumb'=>0,
            'uid'=>$this->uid,
            'times'=>tw_time(),
            'module'=>$this->app,
            'module_id'=>0,
            'descrip'=>'',
            'disk'=>$this->disks
        ];
        if($this->aid) 
        {
            AttachmentModel::where('aid', $this->aid)->update([
                'name'=>$this->clientName,
                'type'=>$this->extension,
                'size'=>$this->fileSize,
                'path'=>$this->saveDir .'/'. $this->fileName,
                'module'=>$this->app,
                'disk'=>$this->disks
            ]);
            $aid = $this->aid;
        } else {
            $aid = AttachmentModel::insertGetId($postData);
            if(!$aid) {
                return [];
            }
        }
        AttachmentModel::setCacheInfo($aid);
        $data = [
            'name'=>$this->clientName,
            'fileName'=>$this->fileName,
            'type'=>$this->extension,
            'size'=>$this->fileSize,
            'path'=>$this->saveDir. '/'. $this->fileName,
            'ifthumb'=>0,
            'aid'=>$aid,
            'descrip'=>''
        ];
        if($this->tempid) 
        {
            AttachmentModel::setTempData($this->tempid, $aid);
        }
        // if($this->disks != 'local') 
        // {
            $data['url'] = storage::disk($this->disks)->url($data['path']);
        // }
        return $data;
    }
}