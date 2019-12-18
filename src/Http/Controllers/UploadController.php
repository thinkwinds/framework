<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Thinkwinds\Framework\Model\AttachmentModel;
use Thinkwinds\Framework\Libraries\ThinkwindsUpload;
use Thinkwinds\Framework\Libraries\ThinkwindsStorage;
use Thinkwinds\Framework\Http\Controllers\GlobalBasicController as BaseController;

/**
* 
*/
class UploadController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function save(Request $request)
    {
        $file = $request->file('filedata');
        $upapp = $request->get('upapp');
        $appid = $request->get('appid');
        $dir = $request->get('dir');
        $aid = (int)$request->get('aid');
        $name = (string)$request->get('name');
        $tempid = (string)$request->get('tempid');
        $islogin = (int)$request->get('islogin');
        $uid = (int)$request->get('uid');
        if($islogin) 
        {
            $uid = Auth::id();
        }
        $thinkwindsUpload = new ThinkwindsUpload();
        if($upapp) 
        {
            $thinkwindsUpload->app = $upapp;
        }
        if($appid) 
        {
            $thinkwindsUpload->appid = $appid;
        }
        if($uid) 
        {
            $thinkwindsUpload->uid = $uid;
        }
        if($tempid) 
        {
            $thinkwindsUpload->tempid = $tempid;
        }
        if($aid) 
        {
            $attachInfo = AttachmentModel::getAttach($aid);
            if($attachInfo) 
            {
                $name = basename($attachInfo['path'], ".".$attachInfo['type']);
            }
            $thinkwindsUpload->aid = $aid;
        }
        $thinkwindsUploads = $thinkwindsUpload->setFile($file);
        if (tw_message_verify($thinkwindsUploads) ) return $this->showError($thinkwindsUploads['message']);
        if($dir) 
        {
            $thinkwindsUploads->setDirs($dir);
        }
        if($name) 
        {
            $thinkwindsUploads->setFileName($name);
        }
        $thinkwindsUploads->doSave();
        $data = $thinkwindsUploads->getData();
        $this->viewData['data'] = $data;
        return $this->showMessage('success');
    }

    public function imageSave(Request $request)
    {
        $file = $request->file('filedata');
        $upapp = $request->get('upapp');
        $appid = $request->get('appid');
        $dir = $request->get('dir');
        $aid = (int)$request->get('aid');
        $name = (string)$request->get('name');
        $tempid = (string)$request->get('tempid');
        $islogin = (int)$request->get('islogin');
        $uid = (int)$request->get('uid');
        if($islogin) 
        {
            $uid = Auth::id();
        }
        $thinkwindsUpload = new ThinkwindsUpload();
        if($upapp) 
        {
            $thinkwindsUpload->app = $upapp;
        }
        if($appid) 
        {
            $thinkwindsUpload->appid = $appid;
        }
        if($uid) 
        {
            $thinkwindsUpload->uid = $uid;
        }
        if($tempid) 
        {
            $thinkwindsUpload->tempid = $tempid;
        }
        if($aid) 
        {
            $attachInfo = AttachmentModel::getAttach($aid);
            if($attachInfo) 
            {
                $name = basename($attachInfo['path'], ".".$attachInfo['type']);
            }
            $thinkwindsUpload->aid = $aid;
        }
        $thinkwindsUploads = $thinkwindsUpload->setFile($file);
        if (tw_message_verify($thinkwindsUploads) ) return $this->showError($thinkwindsUploads['message']);
        if($name) 
        {
            $thinkwindsUploads->setFileName($name);
        }
        if($dir) 
        {
            $thinkwindsUploads->setDirs($dir);
        }
        $thinkwindsUploads->doSave();
        $data = $thinkwindsUploads->getData();
        $this->viewData['data'] = $data;
        return $this->showMessage('success');
    }

    public function kindeditorImage(Request $request)
    {
        $file = $request->file('filedata');
        $upapp = $request->get('upapp');
        $appid = $request->get('appid');
        $dir = $request->get('dirs');
        $aid = (int)$request->get('aid');
        $name = (string)$request->get('name');
        $tempid = (string)$request->get('tempid');
        $islogin = (int)$request->get('islogin');
        $uid = (int)$request->get('uid');
        if($islogin) {
            $uid = Auth::id();
        }
        $thinkwindsUpload = new ThinkwindsUpload();
        if($upapp) 
        {
            $thinkwindsUpload->app = $upapp;
        }
        if($appid) 
        {
            $thinkwindsUpload->appid = $appid;
        }
        if($uid) 
        {
            $thinkwindsUpload->uid = $uid;
        }
        if($tempid) 
        {
            $thinkwindsUpload->tempid = $tempid;
        }
        if($aid) 
        {
            $attachInfo = AttachmentModel::getAttach($aid);
            if($attachInfo) 
            {
                $name = basename($attachInfo['path'], ".".$attachInfo['type']);
            }
            $thinkwindsUpload->aid = $aid;
        }
        $thinkwindsUploads = $thinkwindsUpload->setFile($file);
        if (tw_message_verify($thinkwindsUploads) ) 
        {
            return response()->json(['error'=>1, 'message'=>$thinkwindsUploads['message']]);
        };
        if($name) 
        {
            $thinkwindsUploads->setFileName($name);
        }
        if($dir) 
        {
            $thinkwindsUploads->setDirs($dir);
        }
        $thinkwindsUploads->doSave();
        $data = $thinkwindsUploads->getData();
        return response()->json([
            'error'=>0,
            'url'=>$data['url']
        ]);
    }
}