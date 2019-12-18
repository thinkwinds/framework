<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Illuminate\Database\Eloquent\Model;

class ManageLoginLogModel extends Model
{
    protected $table = 'manage_login_log';
    protected $fillable = [
        'uid', 'username', 'times', 'remark', 'ip', 'port', 'device', 'browser'
    ];
    public $timestamps = false;

    static function addLog($user = [], $remark = '')
    {
        if(!$user) 
        {
            $user = [
                'uid'=>0, 
                'username'=>'system'
            ];
        }
        $postData = [
            'uid'=>$user['uid'],
            'username'=>$user['username'],
            'times'=>tw_time(),
            'ip'=>tw_ip(),
            'port'=>tw_port(),
            'platform'=>tw_agent()->platform(),
            'browser'=>tw_agent()->browser(),
            'remark'=>$remark
        ];
        ManageLoginLogModel::insert($postData);
    }
}