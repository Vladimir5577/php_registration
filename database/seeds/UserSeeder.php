<?php

require_once 'vendor/autoload.php';
require_once 'config/config.php';

use App\Models\User;
use App\Services\AuthService;

/**
 * Class UserSeeder
 */
class UserSeeder
{
    private $authService;

    /**
     * UserSeeder constructor.
     * @param $authService
     */
    public function __construct($authService)
    {
        $this->authService = $authService;
    }

    /**
     * seed database
     */
    public function runSeeder()
    {
        $authService = new AuthService;

        User::create([
            'email' => 'bob@bob.com',
            'password' => $authService->hashUserPassword(1234),
            'key' => $authService->generateRandomKeyForUser(),
            'name' => 'Bob',
            'photo' => 'ava_2.jpeg',
            'is_active' => true,
            'registered_at' => $authService->setDateUserRegistration(),
        ]);

        User::create([
            'email' => 'mike@mike.com',
            'password' => $authService->hashUserPassword(3456),
            'key' => $authService->generateRandomKeyForUser(),
            'name' => 'Mike',
            'photo' => 'ava_1.png',
            'is_active' => true,
            'registered_at' => $authService->setDateUserRegistration(),
        ]);

        User::create([
            'email' => 'jack@jack.com',
            'password' => $authService->hashUserPassword(7777),
            'key' => $authService->generateRandomKeyForUser(),
            'name' => 'Jack',
            'photo' => 'ava_3.png',
            'is_active' => true,
            'registered_at' => $authService->setDateUserRegistration(),
        ]);

        User::create([
            'email' => 'donna@donna.com',
            'password' => $authService->hashUserPassword(3333),
            'key' => $authService->generateRandomKeyForUser(),
            'name' => 'Donna',
            'photo' => 'ava_4.png',
            'is_active' => true,
            'registered_at' => $authService->setDateUserRegistration(),
        ]);
    }
}

$authService = new AuthService;
$userSeeder = new UserSeeder($authService);
$userSeeder->runSeeder();

dump('Seeder run seccessfully!');