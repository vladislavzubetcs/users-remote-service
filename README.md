# package users-remote-service

## Installation

You can install the package via composer:

```bash
composer require vladislavzubetcs/users-remote-service
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="users-remote-service-config"
```

This is the contents of the published config file:

```php
return [
    'endpoint' => 'https://reqres.in/api',

    'providers' => [
        \UsersRemoteService\UsersRemoteService\UsersRemoteServiceServiceProvider::class,
    ],

    'aliases' => [
        'UserService' => UsersRemoteService\UsersRemoteService\Services\UserService::class,
    ],
];
```

## Usage

```php
use GuzzleHttp\Client;
use UsersRemoteService\UsersRemoteService\Services\UserService;

// Create an instance of the GuzzleHttp Client (you may need to configure it with base_uri, authentication, etc.)
$client = new Client();

// Create an instance of the UserService class, passing in the Guzzle client
$userService = new UserService($client);

// Find a user by ID (replace 1 with the desired user ID)
try {
    $user = $userService->find(1);
    
    // Output user details
    echo "User ID: " . $user->id . PHP_EOL;
    echo "Email: " . $user->email . PHP_EOL;
    echo "First Name: " . $user->first_name . PHP_EOL;
    echo "Last Name: " . $user->last_name . PHP_EOL;
    echo "Avatar URL: " . $user->avatar . PHP_EOL;
} catch (RuntimeException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

// Paginate through users (replace 1 and 10 with desired page and per_page values)
try {
    $page = 1;
    $perPage = 10;
    $users = $userService->paginate($page, $perPage);
    
    // Output user details for each user
    foreach ($users as $user) {
        echo "User ID: " . $user->id . PHP_EOL;
        echo "Email: " . $user->email . PHP_EOL;
        echo "First Name: " . $user->first_name . PHP_EOL;
        echo "Last Name: " . $user->last_name . PHP_EOL;
        echo "Avatar URL: " . $user->avatar . PHP_EOL;
        echo "---" . PHP_EOL;
    }
} catch (RuntimeException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

// Create a new user (replace 'New User' and 'Developer' with desired name and job values)
try {
    $name = 'New User';
    $job = 'Developer';
    $newUserId = $userService->create($name, $job);
    
    // Output the newly created user's ID
    echo "New User ID: " . $newUserId . PHP_EOL;
} catch (RuntimeException $e) {
    // Handle any exceptions that may occur
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Vladislav Zubetcs](https://github.com/vladislavzubetcs)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
