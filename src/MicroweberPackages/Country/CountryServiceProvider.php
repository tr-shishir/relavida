<?php
/*
 * This file is part of the Droptienda framework.
 *
 * (c) Droptienda CMS LTD
 *
 * For full license information see
 * https://github.com/microweber/microweber/blob/master/LICENSE
 *
 */

namespace MicroweberPackages\Country;

use Illuminate\Support\ServiceProvider;

class CountryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/');
    }
}
