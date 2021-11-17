<?php

namespace App\Providers;

use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\EmailTemplate;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            Route::bind(
                'customer',
                fn ($id) => Customer::where('id', $id)
                    ->where('user_id', $this->app->request->user()->id)
                    ->firstOrFail()
            );

            Route::bind(
                'customerGroup',
                fn ($id) => CustomerGroup::where('id', $id)
                    ->where('user_id', $this->app->request->user()->id)
                    ->firstOrFail()
            );

            Route::middleware(['web', 'auth.basic:,name'])
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }
}
