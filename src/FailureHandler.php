<?php

namespace FailureNotifier;

use Throwable;

interface FailureHandler
{
    public function handle(Throwable $exception, int $failureCount);
}
