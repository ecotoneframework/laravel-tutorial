<?php

namespace Bootstrap;

use App\Domain\Product\ProductService;
use Illuminate\Support\ServiceProvider;

class QuickStartProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ProductService::class, function(){
            return new ProductService();
        });
    }


    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                EcotoneQuickstartCommand::class
            ]);
        }

    }
}