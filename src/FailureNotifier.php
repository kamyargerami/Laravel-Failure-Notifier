<?php

namespace FailureNotifier;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Throwable;

class FailureNotifier
{
    /**
     * @var Throwable
     */
    protected \Throwable $exception;

    /**
     * @var string
     */
    protected string $exceptionClass;

    /**
     * @var Collection
     */
    protected Collection $configurations;

    /**
     * @var string
     */
    protected string $cacheName;

    /**
     * @var self
     */
    protected static $instance;

    public static function instance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function capture(Throwable $exception, FailureHandler $handler): void
    {
        $this->set($exception);

        if (!$this->isActive()) {
            return;
        }

        $this->increaseCount();

        if ($this->isLock() or !$this->mustNotify()) {
            return;
        }

        $handler->handle($exception, $this->getCount());

        $this->lock();
        $this->resetCount();
    }

    public function set(Throwable $exception)
    {
        $this->exception = $exception;
        $this->exceptionClass = get_class($this->exception);
        $this->configurations = $this->getExceptionConfigurations();
        $this->cacheName = 'failure_count_' . $this->exceptionClass;
    }

    public function getExceptionConfigurations(): Collection
    {
        $exceptions = config('failure-notifier.exceptions');
        $configurations = $exceptions[$this->exceptionClass] ?? $exceptions['default'];
        return collect($configurations);
    }

    public function isActive(): bool
    {
        return $this->configurations->get('active') and config('failure-notifier.active');
    }

    public function increaseCount(): void
    {
        if (Cache::has($this->cacheName)) {
            Cache::increment($this->cacheName);
            return;
        }

        Cache::put($this->cacheName, 1, $this->configurations->get('interval'));
    }

    public function lock(): void
    {
        Cache::put($this->cacheName . '_lock', 1, $this->configurations->get('lock_until'));
    }

    public function isLock(): bool
    {
        return Cache::has($this->cacheName . '_lock');
    }

    public function getCount(): mixed
    {
        return Cache::get($this->cacheName);
    }

    public function mustNotify(): bool
    {
        return $this->getCount() >= $this->configurations->get('count');
    }

    public function resetCount(): void
    {
        Cache::forget($this->cacheName);
    }
}