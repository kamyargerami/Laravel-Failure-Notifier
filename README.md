# Laravel Failure Notifier

This package helps you to track your exceptions and do what you want to do with them such as sending an **SMS** or and
**Email**.

You can specify the amount of time to count the exceptions.

If you had more exceptions than you expect, the service will run your **callback function**, then you can send a notification
or whatever you want.

This package uses your default cache driver to count the exceptions. You are free to choose the driver, but we suggest
you to use **Redis** for that.

## Installation

You need to add this package to your project by:

```
composer require kam2yar/failure-notifier
```

Then add the provider to the `config/app.php` file, at the end of the "providers" array.

```
FailureNotifier\FailureNotifierServiceProvider::class
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
        if ($this->shouldReport($exception)) {
            FailureNotifier::instance()->capture($exception, (new CustomFailureHandler()));
        }

        parent::report($exception);
    }
```

### Write your custom failure handler

You must write a new class in your project and pass it to the capture method that implements the `FailureHandler` interface:

```
use FailureNotifier\FailureHandler;
use Throwable;

class CustomFailureHandler implements FailureHandler
{
    public function handle(Throwable $exception, int $failureCount){
        $exceptionClass = get_class($exception);

        switch ($exceptionClass){
            // Add your exception class names to send custom notify
            default:
                // TODO send sms or email
                break;
        }
    }
}
```

## Configuration

You can change the service configuration by editing the `config\failure-notifier.php` file.

You can have a setting for each type of exception. or you can leave it to use the default configuration.

To add a new exception you need to add a new record to the "exceptions" array like the below example:

```
   \App\Exceptions\GetCredentialFailed::class => [
       'count' => 5,
       'interval' => 600,
       'lock_until' => 600,
       'active' => true
   ],
```

### Parameters

**Count:** Minimum count of exceptions needs to raise to run your callback function.

**Interval:** Seconds to store the count of exceptions in the cache.

**Lock Until:** Seconds to prevent sending duplicate notify

**Active:** Enable or disable service for this type of exception

### Deactivate the service

If you need to disable the service, you can set a new key in your `.env` file. if

```
FAILURE_NOTIFIER_ACTIVE=false
```

### Contribution

Please contact us before starting to develop a new fork and tell us more about the issue or feature.
