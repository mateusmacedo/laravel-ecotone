<?php

declare(strict_types=1);

use Aws\Laravel\AwsServiceProvider;

return [
    /*
    |--------------------------------------------------------------------------
    | AWS SDK Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options set in this file will be passed directly to the
    | `Aws\Sdk` object, from which all client objects are created. This file
    | is published to the application config directory for modification by the
    | user. The full set of possible options are documented at:
    | http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html
    |
    */
    'credentials' => [
        'key' => env('AWS_ACCESS_KEY_ID', 'key'),
        'secret' => env('AWS_SECRET_ACCESS_KEY', 'secret'),
    ],
    'region' => env('AWS_REGION', 'us-east-1'),
    'version' => 'latest',
    'ua_append' => [
        'L5MOD/' . AwsServiceProvider::VERSION,
    ],
    'accountId' => env('AWS_ACCOUNT_ID', '000000000000'),
    'endpoint' => [
        'sqs' => env('AWS_SQS_ENDPOINT', 'http://localstack:4566'),
    ],
];
