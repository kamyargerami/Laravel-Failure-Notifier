<?php

namespace FailureNotifier\Tests\Classes;

use FailureNotifier\FailureHandlerInterface;
use Illuminate\Support\Facades\Log;
use Throwable;

class FailureHandler implements FailureHandlerInterface
{
    public function handleException(Throwable $exception, int $failureCount)
    {
        $exceptionClass = get_class($exception);

        switch ($exceptionClass) {
            default:
                Log::warning('Handle default exception', ['class' => $exceptionClass]);
                break;
        }
    }
}