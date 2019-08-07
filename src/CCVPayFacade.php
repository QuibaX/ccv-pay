<?php

namespace QuibaX\CCVPay;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Skeleton\CCVPayClass
 */
class CCVPayFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'skeleton';
    }
}
