# Laravel Failure Notifier

This package helps you to track your exceptions and do what you want to do with them such as sending an **SMS** or an
**Email**.

You can specify the amount of time to count the exceptions.

If you had more exceptions than you expect, the service will run your **function**, then you can send a notification or
whatever you want.

This package uses your default cache driver to count the exceptions. You are free to choose the driver, but we suggest
you to use **Redis** for that.

## Installation

You need to add this package to your project by:

```
composer require kam2yar/failure-notifier
```

Optional: The service provider will automatically get registered. Or you may manually add the service provider in your
`config/app.php` file:

```
'providers' => [
    // ...
    FailureNotifier\FailureNotifierServiceProvider::class
]
```

After you need to run the below command to copy the configuration file to your project directory.

```
php artisan vendor:publish --provider="FailureNotifier\FailureNotifierServiceProvider"
```

After this, you are free to remove it from your provider's array.

### Add the service to the handler

You must add the service to the `Exceptions\Handler.php` file to capture the exceptions.

Add the report method to the "Handler" class as below:

```
public function report(Throwable $exception)
{
    if ($this->shouldReport($exception) and app()->bound(FailureNotifier::class) and app()->bound(FailureHandlerInterface::class)) {
        app(FailureNotifier::class)->capture($exception);
    }

    parent::report($exception);
}
```

### Write your custom failure handler

You must write a new class in your project and pass it to the capture method that implements
the `FailureHandlerInterface`
interface:

```
use FailureNotifier\FailureHandlerInterface;.
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
```

### Bind your custom handler to your application

Now you need to add your custom failure handler to your `App\Providers\AppServiceProvider` file.

Add the bellow code to the boot function:

```
public function boot()
{
    $this->app->singleton(FailureHandlerInterface::class, function ($app) {
        // Your custom failure handler
        
        return new FailureHandler();       
    });
}
```

## Configuration

You can change the service configuration by editing the `config\failure-notifier.php` file.

You can have a setting for each type of exception. or you can leave it to use the default configuration.

To add a new exception you need to add a new record to the "exceptions" array like the below example:

```
   \App\Exceptions\ExampleException::class => [
       'count' => 5,
       'interval' => 600,
       'lock_until' => 600,
       'active' => true
   ],
```

### Parameters

**Count:** Minimum count of exceptions needs to raise to run your function.

**Interval:** Seconds to store the count of exceptions in the cache.

**Lock Until:** Seconds to prevent sending duplicate notify

**Active:** Enable or disable service for this type of exception

### Deactivate the service

If you need to disable the service, you can set a new key in your `.env` file.

```
FAILURE_NOTIFIER_ACTIVE=false
```

### Contribution

Please tell me about the feature or issues before start developing it. Thank you.
