<?php

namespace App\Providers;

use App\Services\Contracts\MoneyTransferDataInterface;
use App\Services\Contracts\MoneyTransferInterface;
use App\Services\MoneyTransferDataService;
use App\Services\MoneyTransferService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        $this->app->singleton(MoneyTransferInterface::class, MoneyTransferService::class);
    }

    public $bindings = [
        MoneyTransferDataInterface::class => MoneyTransferDataService::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Validator::extend('foo', function ($attribute, $value, $parameters, $validator){
//
//            return $value == 'foo';
//
//        });
    }
}
