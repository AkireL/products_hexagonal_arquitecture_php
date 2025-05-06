<?php

namespace App\Providers;

use App\Features\Order\Domain\Ports\OrderRepositoryInterface;
use App\Features\Order\Infrastructure\Persistence\EloquentOrderRepository;
use App\Features\Product\Domain\Ports\ProductRepositoryInterface;
use App\Features\Product\Infrastructure\Persistence\EloquentProductRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OrderRepositoryInterface::class, function (Application $app) {
            return new EloquentOrderRepository;
        });

        $this->app->singleton(ProductRepositoryInterface::class, function (Application $app) {
            return new EloquentProductRepository;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
