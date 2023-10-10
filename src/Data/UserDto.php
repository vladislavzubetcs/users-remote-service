<?php

declare(strict_types=1);

namespace UsersRemoteService\UsersRemoteService\Data;

use Spatie\LaravelData\Data;

class UserDto extends Data
{
    public function __construct(
        public int $id,
        public string $email,
        public string $first_name,
        public string $last_name,
        public string $avatar,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => $this->avatar,
        ];
    }
}
