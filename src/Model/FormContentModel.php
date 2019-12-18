<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache;
use Illuminate\Database\Eloquent\Model;

class FormContentModel extends Model
{
    protected $table = '';
    protected $fillable = [];
    public $timestamps = false;
}