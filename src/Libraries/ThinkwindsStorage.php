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

class ThinkwindsStorage
{

	public $aid = 0;
	public $file = '';
	public $name = '';
	public $headers = [];
    public $disks = 'public';

	public function __construct() 
    {
		self::setStorage();
	}

    public function setStorage($disks = '')
    {
        if($disks) 
        {
        	$this->disks = $disks;
            return $this;
        }
        $this->disks = tw_config('attachment', 'storage');
        return $this;
    }

    public function download() 
    {
    	if($this->aid) 
        {
    		$attachInfo = AttachmentModel::where('aid', $this->aid)->first();
    		if(!$attachInfo) 
            {
    			return tw_message('thinkwinds::public.download.file.error.001');
    		}
    		$name = $this->name ? $this->name : $attachInfo['name'];
    		$disk = $attachInfo['disk'] ? $attachInfo['disk'] : $this->disks;
    		if(!Storage::disk($disk)->exists($attachInfo['path'])) 
            {
    			return tw_message('thinkwinds::public.download.file.error.001');
    		}
    		return Storage::disk($disk)->download($attachInfo['path'], $name, $this->headers);
    	} else {
    		if(!$this->file) 
            {
    			return tw_message('thinkwinds::public.download.file.error.001');
    		}
    		if(!Storage::disk($this->disks)->exists($this->file)) 
            {
    			return tw_message('thinkwinds::public.download.file.error.001');
    		}
    		return Storage::disk($disk)->download($this->file, $this->name, $this->headers);
    	}
    }

    public function delete($file) 
    {	
    	return Storage::disk($this->disk)->delete($file);
    }
}