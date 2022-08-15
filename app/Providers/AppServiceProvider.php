<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    protected $namespace = 'App\\Http\\Controllers';
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        
        //$this->configureRateLimiting();
        /*
        $this->routes(function () {
            Route::middleware('web')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/web.php'));
        });
        */
    }
}
