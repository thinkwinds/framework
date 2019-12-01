<?php 

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
