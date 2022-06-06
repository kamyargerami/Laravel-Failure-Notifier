<?php

declare(strict_types=1);

namespace FailureNotifier\Tests;

use FailureNotifier\FailureHandlerInterface;
use FailureNotifier\FailureNotifier;
use FailureNotifier\Tests\Classes\FailureHandler;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class FailureNotifierTest extends TestCase
{
    public function setupHandler()
    {
        app()->singleton(FailureHandlerInterface::class, function ($app) {
            return new FailureHandler();
        });
    }
    
    /**
     * @covers
     */
    public function test_new_instance(): void
    {
        $object = app(FailureNotifier::class);

        $this->assertInstanceOf(FailureNotifier::class, $object);
    }

    /**
     * @covers
     */
    public function test_capture_function()
    {
        $this->setupHandler();

        $exception = new \Exception('Test');

        $object = app(FailureNotifier::class);
        $object->capture($exception);

        $this->assertEquals(true, $object->isActive());
    }

    /**
     * @covers
     */
    public function test_hole_functionality()
    {
        $this->setupHandler();

        $exception = new \Exception('Test');

        $object = app(FailureNotifier::class);

        for($i = 0; $i < 9; $i++){
            $object->capture($exception);
        }

        $this->assertEquals(9, $object->getCount());

        $object->capture($exception);

        $this->assertEquals(true, $object->isLock());

        $this->assertEquals(0, $object->getCount());
    }
}