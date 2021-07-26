## PHP Registration

Install

	$ composer install

Copy .env file and then write your credentials 

	$ cp .env.example .env


Run migration user
	$ php database/migrations/user_migration.php

Run user seeder

	$ php database/seeds/UserSeeder.php

In postman login with post request email and password

	/api/login

it will return token.

Get users data with jwt

/api/get_users

Get users in xml

/api/get_users_xml



