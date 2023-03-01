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
            $connectionString = 'sqs:?key=' . config('aws.credentials.key') . '&secret=' . config('aws.credentials.secret') . '&region=' . config('aws.region') . '&endpoint=' . config('aws.endpoint.sqs') . '&version=' . config('aws.version');
            return new SqsConnectionFactory($connectionString);
        });
        $this->app->singleton(AmqpConnectionFactory::class, function () {
            $connectionString = 'amqp+lib://' . config('rabbitmq.user') . ':' . config('rabbitmq.password') . '@' . config('rabbitmq.host') . ':' . config('rabbitmq.port') . '/';
            return new AmqpConnectionFactory($connectionString);
        });
        $this->app->singleton(RedisConnectionFactory::class, function () {
            $connectionString = 'redis://' . config('database.redis.default.host') . ':' . config('database.redis.default.port') . '/' . config('database.redis.default.database');
            return new RedisConnectionFactory($connectionString);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
