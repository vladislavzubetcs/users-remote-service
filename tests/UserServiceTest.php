<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use UsersRemoteService\UsersRemoteService\Data\UserDto;
use UsersRemoteService\UsersRemoteService\Services\UserService;

it('can find a user by ID', function () {
    $clientMock = Mockery::mock(Client::class);
    $clientMock->allows('get')->andReturns(
        new \GuzzleHttp\Psr7\Response(200, [], '{"data":{"id":1,"email":"test@example.com","first_name":"John","last_name":"Doe","avatar":"avatar.jpg"}}')
    );

    $userService = new UserService($clientMock);

    $user = $userService->find(1);

    expect($user)->toBeInstanceOf(UserDto::class);
    expect($user->id)->toBe(1);
    expect($user->email)->toBe('test@example.com');
    expect($user->first_name)->toBe('John');
    expect($user->last_name)->toBe('Doe');
    expect($user->avatar)->toBe('avatar.jpg');
});

it('can paginate users', function () {
    $clientMock = Mockery::mock(Client::class);
    $clientMock->allows('get')->andReturns(
        new \GuzzleHttp\Psr7\Response(200, [], '{"data":[{"id":1,"email":"test1@example.com","first_name":"John","last_name":"Doe","avatar":"avatar1.jpg"},{"id":2,"email":"test2@example.com","first_name":"Jane","last_name":"Smith","avatar":"avatar2.jpg"}]}')
    );

    $userService = new UserService($clientMock);

    $users = iterator_to_array($userService->paginate(1, 2));

    expect(count($users))->toBe(2);
    expect($users[0])->toBeInstanceOf(UserDto::class);
    expect($users[1])->toBeInstanceOf(UserDto::class);
});

it('can create a new user', function () {
    $clientMock = Mockery::mock(Client::class);
    $clientMock->allows('post')->andReturns(
        new \GuzzleHttp\Psr7\Response(201, [], '{"id": 101}')
    );

    $userService = new UserService($clientMock);

    $userId = $userService->create('New User', 'Developer');

    expect($userId)->toBe(101);
});
