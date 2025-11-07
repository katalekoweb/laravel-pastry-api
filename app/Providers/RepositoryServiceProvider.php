<?php

namespace App\Providers;

use App\Repositories\V1\ClientRepository;
use App\Repositories\V1\ClientRepositoryInterface;
use App\Repositories\V1\ProductRepository;
use App\Repositories\V1\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
    }
}
