<?php

declare(strict_types=1);

namespace UsersRemoteService\UsersRemoteService\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;
use Traversable;
use UsersRemoteService\UsersRemoteService\Data\UserDto;
use UsersRemoteService\UsersRemoteService\Exceptions\UserNotFoundException;

class UserService
{
    public function __construct(
        private readonly Client $client
    ) {
    }

    public function find(int $id): UserDto|null
    {
        try {
            $response = $this->client->get(sprintf(
                '%s/%s',
                config('users-remote-service')['endpoint'],
                $id
            ));

            $user = json_decode(
                $response->getBody()->getContents(),
                false,
                512,
                JSON_THROW_ON_ERROR
            );

            if (empty($user)) {
                throw new UserNotFoundException();
            }
        } catch (GuzzleException|JsonException $e) {
            throw new RuntimeException($e->getMessage());
        } catch (UserNotFoundException $e) {
            return null;
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
                '%s?page=%s&per_page=%s',
                config('users-remote-service')['endpoint'],
                $page,
                $perPage
            ));

            $users = json_decode(
                $response->getBody()->getContents(),
                false,
                512,
                JSON_THROW_ON_ERROR
            )->data;

            if (empty($users)) {
                throw new UserNotFoundException();
            }
        } catch (GuzzleException|JsonException $e) {
            throw new RuntimeException($e->getMessage());
        } catch (UserNotFoundException $e) {
            return null;
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
                config('users-remote-service')['endpoint'],
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
