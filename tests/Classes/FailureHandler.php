<?php

namespace FailureNotifier\Tests\Classes;

use FailureNotifier\FailureHandlerInterface;
use Throwable;

class FailureHandler implements FailureHandlerInterface
{
    public function handleException(Throwable $exception, int $failureCount)
    {
        $exceptionClass = get_class($exception);

        switch ($exceptionClass) {
            default:
                break;
        }
    }
}