<?php

return [
    'active' => env('FAILURE_NOTIFIER_ACTIVE', 1),
    'exceptions' => [
        'default' => [
            'count' => 10,
            'interval' => 600,
            'lock_until' => 600,
            'active' => true
        ],
        /*
         * Add your custom exceptions here like below example:
         *      \App\Exceptions\GetCredentialFailed::class => [
                    'count' => 5, // count of exceptions need to send notify
                    'interval' => 600, // seconds to store the count of exceptions
                    'lock_until' => 600, // seconds to prevent send duplicate notify
                    'active' => true, // enable or disable notify sender for this type of exception
                ],
         */
    ]
];
