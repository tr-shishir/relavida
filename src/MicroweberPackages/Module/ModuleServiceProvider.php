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

namespace MicroweberPackages\Module;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;


class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->singleton('module_manager', function ($app) {
            return new ModuleManager();
        });

        $this->app->bind('module',function(){
            return new Module();
        });

        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('ModuleManager', \MicroweberPackages\Module\Facades\ModuleManager::class);

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }
}
