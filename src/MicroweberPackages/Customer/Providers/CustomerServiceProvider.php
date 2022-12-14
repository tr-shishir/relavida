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

namespace MicroweberPackages\Customer\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::addNamespace('customer', __DIR__.'/../resources/views');

        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/');
    }
}
