<?php

namespace FailureNotifier;

use Throwable;

interface FailureHandlerInterface
{
    public function handleException(Throwable $exception, int $failureCount);
}
