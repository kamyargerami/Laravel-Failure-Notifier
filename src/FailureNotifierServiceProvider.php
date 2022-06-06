<?php

namespace FailureNotifier;

use Illuminate\Support\ServiceProvider;

class FailureNotifierServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/failure-notifier.php' => config_path('failure-notifier.php'),
        ]);
    }

    public function register(): void
    {
        $this->app->singleton(FailureNotifier::class, function ($app) {
            return new FailureNotifier();
        });
    }
}
