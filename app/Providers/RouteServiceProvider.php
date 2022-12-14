<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
      //  $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

    }

    public function register()
    {
        $this->apiRoutes();
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }

//    /**
//     * Configure the rate limiters for the application.
//     *
//     * @return void
//     */
//    protected function configureRateLimiting()
//    {
//        RateLimiter::for('api', function (Request $request) {
//            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
//        });
//    }

    private function apiRoutes()
    {
        \Illuminate\Support\Facades\Route::prefix('api/v1')
//            ->middleware('api')
            ->namespace($this->namespace . '\Api\V1')
            ->group(base_path('routes/api.v1.php'));
    }
}
