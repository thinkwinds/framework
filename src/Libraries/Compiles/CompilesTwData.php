<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries\Compiles;

use Illuminate\Support\Facades\DB;
use Thinkwinds\Framework\Libraries\thinkwindsData;
use Thinkwinds\Framework\Libraries\Compiles\Compiles as bCompiles;

class CompilesTwData extends bCompiles
{
	public $type = ['sql'];

    /**
     * Create a new table on the schema.
     *
     * @param  string    $table
     * @param  \Closure  $callback
     * @return void
     */
    public function compileData($expression = null)
    {
        $bCompiles = new bCompiles();
        $expression = $bCompiles->getExpression($expression);
        print_r($expression);
        if(!isset($expression[0]) || !isset($expression[1])) $data =  [];
        $type = trim($expression[0]);
        $iteration = trim($expression[1]);
        $extends = isset($expression[2]) ? trim($expression[2]) : '';
        $initLoop = $data = '';
        switch ($type)
        {
            case 'sql':
                if($v)
                {
                    $data = "DB::raw('{$v}')->toArray()";
                }
                break;
            default:
                $initLoop .= "\$thinkwindsData = app('Thinkwinds\Framework\Libraries\\thinkwindsData');";
                $data .= "\$thinkwindsData->getData('{$type}', '{$extends}')";
                break;
        }
        $initLoop .= "\$__currentLoopData = {$data}; \$__env->addLoop(\$__currentLoopData);";

        $iterateLoop = '$__env->incrementLoopIndices(); $loop = $__env->getLastLoop();';

        return "<?php {$initLoop} foreach(\$__currentLoopData as {$iteration}): {$iterateLoop} ?>";
    }

    public function compileDataEnd($expression = null)
    {
        return '<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>';
    }
}