<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Meeting;
use App\Models\Settings\Thana;
use Illuminate\Support\Facades\View;
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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('include.header', function ($view) {
            $meeting = Customer::where('is_meeting', 0)->latest()->get();
            $total = $meeting->count();
            $view->with([
                'meeting' => $meeting,
                'total' => $total,
            ]);
        });
    }
}
