<?php

namespace FailureNotifier;

use Illuminate\Support\ServiceProvider;

class FailureNotifierServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/failure-notifier.php' => config_path('failure-notifier.php'),
        ]);
    }
}
