<?php

namespace FailureNotifier\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('failure-notifier', [
            'active' => env('FAILURE_NOTIFIER_ACTIVE', 1),
            'exceptions' => [
                'default' => [
                    'count' => 10,
                    'interval' => 600,
                    'lock_until' => 600,
                    'active' => true
                ]
            ]
        ]);

    }
}