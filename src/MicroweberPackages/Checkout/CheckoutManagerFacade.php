<?php
/*
 * This file is part of the Dropienda framework.
 *
 * (c) Dropienda CMS LTD
 *
 * For full license information see
 * https://github.com/microweber/microweber/blob/master/LICENSE
 *
 */

namespace MicroweberPackages\Checkout;

use Illuminate\Support\Facades\Facade;

class CheckoutManagerFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'checkout_manager';
    }
}
