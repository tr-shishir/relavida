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

namespace MicroweberPackages\Database;

use Illuminate\Support\ServiceProvider;


class DatabaseManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @property \MicroweberPackages\Database\DatabaseManager    $database_manager
         */
        $this->app->singleton('database_manager', function ($app) {
            return new DatabaseManager($app);
        });
    }
}
