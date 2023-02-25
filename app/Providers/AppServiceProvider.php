<?php

declare(strict_types=1);

namespace App\Providers;

use Enqueue\AmqpExt\AmqpConnectionFactory;
use Enqueue\Redis\RedisConnectionFactory;
use Enqueue\Sqs\SqsConnectionFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            // $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            // $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        }
        $this->app->singleton(SqsConnectionFactory::class, function () {
            $config = [
                'key' => null,
                'secret' => config('aws.credentials.secret'),
                'token' => config('aws.credentials.key'),
                'region' => config('aws.region'),
                'retries' => 3,
                'version' => 'latest',
                'lazy' => true,
                'endpoint' => config('queue.connections.sqs.prefix'),
                'profile' => null,
                'queue_owner_aws_account_id' => null
            ];
            return new SqsConnectionFactory($config);
            /*   $connectionString = 'sqs:?key=' . config('aws.credentials.key') . '&secret=' . config('aws.credentials.secret') . '&region=' . config('aws.region') . '&endpoint=' . config('aws.endpoint.sqs') . '/' . config('aws.queues.users') . '&version=' . config('aws.version');
            return new SqsConnectionFactory($connectionString); */
        });
        $this->app->singleton(AmqpConnectionFactory::class, function () {
            $connectionString = 'amqp+lib://' . config('rabbitmq.user') . ':' . config('rabbitmq.password') . '@' . config('rabbitmq.host') . ':' . config('rabbitmq.port') . '/';
            return new AmqpConnectionFactory($connectionString);
        });
        $this->app->singleton(AmqpConnectionFactory::class, function () {
            return new AmqpConnectionFactory("amqp+lib://guest:guest@rabbitmq:5672//");
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
