<?php

declare(strict_types=1);

namespace UsersRemoteService\UsersRemoteService\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;
use Traversable;
use UsersRemoteService\UsersRemoteService\Data\UserDto;

class UserService
{
    public function __construct(
        private readonly Client $client
    ) {
    }

    public function find(int $id): UserDto
    {
        try {
            $response = $this->client->get(sprintf(
                'https://reqres.in/api/users/%s',
                $id
            ));

            $user = json_decode(
                $response->getBody()->getContents(),
                false,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (GuzzleException|JsonException $e) {
            throw new RuntimeException($e->getMessage());
        }

        return new UserDto(
            $user->data->id,
            $user->data->email,
            $user->data->first_name,
            $user->data->last_name,
            $user->data->avatar,
        );
    }

    public function paginate(int $page = 1, int $perPage = 10): Traversable
    {
        try {
            $response = $this->client->get(sprintf(
                'https://reqres.in/api/users?page=%s&per_page=%s',
                $page,
                $perPage
            ));

            $users = json_decode(
                $response->getBody()->getContents(),
                false,
                512,
                JSON_THROW_ON_ERROR
            )->data;
        } catch (GuzzleException|JsonException $e) {
            throw new RuntimeException($e->getMessage());
        }

        foreach ($users as $user) {
            yield new UserDto(
                $user->id,
                $user->email,
                $user->first_name,
                $user->last_name,
                $user->avatar,
            );
        }
    }

    public function create(string $name, string $job): int
    {
        try {
            $response = $this->client->post(
                'https://reqres.in/api/users',
                [
                    'json' => [
                        'name' => $name,
                        'job' => $job,
                    ],
                ]
            );

            $user = json_decode(
                $response->getBody()->getContents(),
                false,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (GuzzleException|JsonException $e) {
            throw new RuntimeException($e->getMessage());
        }

        return $user->id;
    }
}
