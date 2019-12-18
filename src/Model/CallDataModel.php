<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Illuminate\Database\Eloquent\Model;

class CallDataModel extends Model
{
    protected $table = 'call_data';
    protected $fillable = [
        'id', 'times', 'block_id', 'is_edit', 'start_times', 'end_times', 'sort', 'type', 'content'
    ];
    public $timestamps = false;
}