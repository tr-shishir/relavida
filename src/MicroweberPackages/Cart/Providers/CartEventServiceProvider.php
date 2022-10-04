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


namespace MicroweberPackages\Cart\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use MicroweberPackages\Cart\Listeners\UserLoginListener;

class CartEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        Login::class => [
            UserLoginListener::class,
        ]
    ];
}
