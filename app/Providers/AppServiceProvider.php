<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CategoryServiceInterface;
use App\Services\CategoryService;
use App\Interfaces\ProductServiceInterface;
use App\Services\ProductService;
use App\Interfaces\SupplierServiceInterface;
use App\Services\SupplierService;
use App\Interfaces\CustomerServiceInterface;
use App\Services\CustomerService;
use App\Interfaces\BillingServiceInterface;
use App\Services\BillingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->bind(CategoryServiceInterface::class,CategoryService::class);
         $this->app->bind(ProductServiceInterface::class,ProductService::class);
         $this->app->bind(SupplierServiceInterface::class,SupplierService::class);
         $this->app->bind(CustomerServiceInterface::class,CustomerService::class);
         $this->app->bind(BillingServiceInterface::class,BillingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
