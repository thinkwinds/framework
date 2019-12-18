<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Illuminate\Database\Eloquent\Model;

class CallBlockModel extends Model
{
    protected $table = 'call_block';
    protected $fillable = [
        'id', 'times', 'name', 'module', 'type', 'isopen', 'upsetting', 'configures'
    ];
    public $timestamps = false;

    static function getInfo($id = 0)
    {
        $info = CallBlockModel::where('id', $id)->first();
        if(!$info)
        {
            return [];
        }
        $info['upsetting'] = (array)unserialize($info['upsetting']);
        $info['configures'] = (array)unserialize($info['configures']);
        return $info->toArray();
    }
}