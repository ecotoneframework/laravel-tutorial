<?php

namespace Bootstrap;

use Illuminate\Support\ServiceProvider;
use Enqueue\AmqpLib\AmqpConnectionFactory;

class QuickStartProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AmqpConnectionFactory::class, function () {
            return new AmqpConnectionFactory("amqp+lib://guest:guest@rabbitmq:5672//");
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