<?php

declare(strict_types=1);

namespace FailureNotifier\Tests;

use FailureNotifier\FailureHandlerInterface;
use FailureNotifier\FailureNotifier;
use FailureNotifier\Tests\Classes\FailureHandler;

class FailureNotifierTest extends TestCase
{
    /**
     * @covers
     */
    public function test_new_instance(): void
    {
        $object = FailureNotifier::instance();

        $this->assertInstanceOf(FailureNotifier::class, $object);
    }

    /**
     * @covers
     */
    public function test_capture_function()
    {
        $exception = new \Exception('Test');

        app()->singleton(FailureHandlerInterface::class, function ($app) {
            return new FailureHandler();
        });

        $object = FailureNotifier::instance();
        $object->capture($exception);

        $this->assertEquals(true, $object->isActive());
    }
}