<?php

namespace App\Providers;

use App\Repositories\CartRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductSupplierRepository;
use App\Interfaces\ProductSupplierRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductSupplierRepositoryInterface::class, ProductSupplierRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
