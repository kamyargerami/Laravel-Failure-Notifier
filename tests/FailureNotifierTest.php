<?php

declare(strict_types=1);

namespace FailureNotifier\Tests;

use FailureNotifier\FailureNotifier;
use FailureNotifier\Tests\Classes\CustomFailureHandler;

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

        $object = FailureNotifier::instance();
        $object->capture($exception, (new CustomFailureHandler()));

        $this->assertEquals(true, $object->isActive());
    }
}