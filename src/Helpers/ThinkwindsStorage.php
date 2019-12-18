<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2019-2100 thinkwinds.com
 * @license http://www.thinkwinds.com
 */

use Gregwar\Image\Image;
use Illuminate\Support\Facades\Storage;
use Thinkwinds\Framework\Model\AttachmentModel;
use Thinkwinds\Framework\Libraries\ThinkwindsStorage;

if ( ! function_exists('tw_storage_url'))
{    
    function tw_storage_url($v = '', $disk = '')
    {
    	if(is_numeric($v)) 
        {
    		$attachInfo = AttachmentModel::where('aid', $v)->first();
    		if(!$attachInfo) {
    			return '';
    		}
    		return storage::disk($attachInfo['disk'])->url($attachInfo['path']);
    	} else {
    		if(!$disk) {
    			$disk = tw_config('attachment', 'storage');
    		}
    		return storage::disk($disk)->url($v);
    	}
    }
}

if ( ! function_exists('tw_storage_delete'))
{    
    function tw_storage_delete($v = '', $disk = '')
    {
    	if(is_numeric($v)) {
    		return AttachmentModel::deleteAttach($v);
    	} else {
            $thinkwindsStorage = new ThinkwindsStorage();
    		if($disk) {
            	$thinkwindsStorage->disk = $disk;
    		}
    		return $thinkwindsStorage->delete($v);
    	}
    }
}

if ( ! function_exists('tw_storage_download'))
{    
    function tw_storage_download($v = '', $disk = '')
    {
        $thinkwindsStorage = new ThinkwindsStorage();
        if(is_numeric($v)) {
            $thinkwindsStorage->aid = $v;
        } else {
            if($disk) {
                $thinkwindsStorage->disk = $disk;
            }
        }
        $result = $thinkwindsStorage->download();
        if(tw_message_verify($result)) {
            return $result;
        }
        return $result;
    }
}


if ( ! function_exists('tw_image_resize'))
{    
    function tw_image_resize($v = '', $option = [], $disk = '')
    {
        $type = isset($option['type']) && $option['type'] ? $option['type'] : '';
        $width = isset($option['width']) && $option['width'] ? (int)$option['width'] : 0;
        $height = isset($option['height']) && $option['height'] ? (int)$option['height'] : 0;
        $background = isset($option['background']) && $option['background'] ? $option['background'] : 'transparent';
        $xPos = isset($option['xPos']) && $option['xPos'] ? (int)$option['xPos'] : 0;
        $yPos = isset($option['yPos']) && $option['yPos'] ? (int)$option['yPos'] : 0;
        if(is_numeric($v)) {
            $attachInfo = AttachmentModel::where('aid', $v)->first();
            if(!$attachInfo) {
                return '';
            }
            $url = storage::disk($attachInfo['disk'])->url($attachInfo['path']);
        } else {
            if(!$disk) {
                $disk = tw_config('attachment', 'storage');
            }
            $url = storage::disk($disk)->url($v);
        }
        if(!$width || !$height) {
            return $url;
        }
        $image = Image::open($url);
        switch ($type) {
            case 'scale':
                $image->scaleResize($width, $height, $background);
                break;
            case 'force':
                $image->forceResize($width, $height, $background);
                break;
            case 'crop':
                $image->cropResize($width, $height, $background);
                break;
            case 'zoom':
                $image->zoomResize($width, $height, $background, $xPos, $yPos);
                break;
            default:  //resize
                $image->resize($width, $height, $background);
                break;
        }
        if($background === 'transparent') {
            // $image->negate();
        }
        $url = $image->guess(100);
        return url($url);
    }
}

