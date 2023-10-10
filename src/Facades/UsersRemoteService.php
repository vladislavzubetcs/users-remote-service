<?php

declare(strict_types=1);

namespace UsersRemoteService\UsersRemoteService\Facades;

use Illuminate\Support\Facades\Facade;
use UsersRemoteService\UsersRemoteService\Services\UserService;

class UsersRemoteService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return UserService::class;
    }
}
