<?php

declare(strict_types=1);

namespace UsersRemoteService\UsersRemoteService;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class UsersRemoteServiceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('users-remote-service')
            ->hasConfigFile();
    }
}
