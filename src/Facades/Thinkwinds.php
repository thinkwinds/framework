<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2019-2100 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Facades;

use Illuminate\Support\Facades\Facade;

class Thinkwinds extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'thinkwinds';
    }
}
