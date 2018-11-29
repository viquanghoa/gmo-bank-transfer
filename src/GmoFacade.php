<?php

namespace HoaVQ\GmoPG;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Collective\Html\GmoFunctions
 */
class GmoFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gmo';
    }
}
