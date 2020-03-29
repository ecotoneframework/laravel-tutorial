<?php

namespace Bootstrap;

use App\Domain\Product\InMemoryProductRepository;
use Illuminate\Support\ServiceProvider;

class QuickStartProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(InMemoryProductRepository::class, function(){
            return new InMemoryProductRepository();
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