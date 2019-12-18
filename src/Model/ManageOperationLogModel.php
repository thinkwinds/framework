<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Illuminate\Database\Eloquent\Model;

class ManageOperationLogModel extends Model
{
    protected $table = 'manage_operation_log';
    protected $fillable = [
        'uid', 'username', 'times', 'status', 'ip', 'port', 'platform', 'browser', 'suid', 'susername', 'stimes', 'olddata', 'newdata', 'change', 'remark'
    ];
    public $timestamps = false;

    static function addLog($user, $remark = '', $change = '', $newdata = [], $olddata = [])
    {
        $postData = [
            'uid'=>$user['uid'],
            'username'=>$user['username'],
            'times'=>tw_time(),
            'ip'=>tw_ip(),
            'port'=>tw_port(),
            'platform'=>tw_agent()->platform(),
            'browser'=>tw_agent()->browser(),
            'status'=>0,
            'remark'=>$remark,
            'change'=>$change,
            'olddata'=>serialize($olddata),
            'newdata'=>serialize($newdata),
            'suid'=>0,
            'susername'=>0,
            'stimes'=>0
        ];
        ManageOperationLogModel::insert($postData);
    }
}