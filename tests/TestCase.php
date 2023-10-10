<?php

declare(strict_types=1);

namespace UsersRemoteService\UsersRemoteService\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use UsersRemoteService\UsersRemoteService\UsersRemoteServiceServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            UsersRemoteServiceServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }
}
