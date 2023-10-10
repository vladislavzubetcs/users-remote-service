<?php

declare(strict_types=1);

return [
    'endpoint' => 'https://reqres.in/api',

    'providers' => [
        \UsersRemoteService\UsersRemoteService\UsersRemoteServiceServiceProvider::class,
    ],

    'aliases' => [
        'UserService' => UsersRemoteService\UsersRemoteService\Services\UserService::class,
    ],
];
