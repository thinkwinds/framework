<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Gregwar\Image\Image;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\AttachmentModel;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;
/**
* 
*/
class ImageController extends BasicController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function view($aid, Request $request)
    {
        if(!$aid) exit();
        if(!ini_get('safe_mode')) 
        {
            ignore_user_abort(true);
            set_time_limit(0);
        }
        $attachInfo = AttachmentModel::getAttach($aid);
        if(!$attachInfo) 
        {
            exit();
        }
        header("Cache-control: max-age=600");
        header('Location: ' . $attachInfo['url']);
        exit;
    }

    public function resize($aid, $type = '', $width = 0, $height = 0, Request $request)
    {
        if(!$aid) exit();
        if(!ini_get('safe_mode')) 
        {
            ignore_user_abort(true);
            set_time_limit(0);
        }
        if(!$width || !$height) 
        {
            $attachInfo = AttachmentModel::getAttach($aid);
            if(!$attachInfo) 
            {
                exit();
            }
            header("Cache-control: max-age=600");
            header('Location: ' . $attachInfo['url']);
            exit;
        }
        $url = tw_image_resize($aid, [
            'type'=>$type,
            'width'=>$width,
            'height'=>$height
        ]);
        header("Cache-control: max-age=600");
        header('Location: ' . $url);
        exit;
    }
}