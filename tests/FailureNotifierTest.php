<?php

declare(strict_types=1);

namespace Tests;

use FailureNotifier\FailureNotifier;
use PHPUnit\Framework\TestCase;

final class FailureNotifierTest extends TestCase
{
    /**
     * @covers
     */
    public function test_new_instance(): void
    {
        $object = FailureNotifier::instance();

        $this->assertInstanceOf(FailureNotifier::class, $object);
    }

    public function test_set_function()
    {
        $exception = new \Exception('Test');

        $object = FailureNotifier::instance();
        $object->set($exception);
    }
}