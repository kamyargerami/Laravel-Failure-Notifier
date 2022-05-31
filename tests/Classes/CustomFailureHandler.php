<?php

namespace FailureNotifier\Tests\Classes;

use FailureNotifier\FailureHandler;
use Throwable;

class CustomFailureHandler implements FailureHandler
{
    public function handle(Throwable $exception, int $failureCount)
    {
        $exceptionClass = get_class($exception);

        switch ($exceptionClass) {
            default:
                break;
        }
    }
}