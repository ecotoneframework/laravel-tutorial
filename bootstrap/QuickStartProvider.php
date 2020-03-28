<?php

namespace Bootstrap;

use Illuminate\Support\ServiceProvider;

class QuickStartProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                EcotoneQuickstartCommand::class
            ]);
        }

    }
}