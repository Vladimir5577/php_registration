## PHP Registration

## Installation

```bash
composer install
```

Copy .env file and then write your credentials 

```bash
cp .env.example .env
```

Run migration user

```bash
php database/migrations/user_migration.php
```

Run user seeder

```bash
php database/seeds/UserSeeder.php
```

Run project locally - go to public folder:

```bash
cd public/
php -S localhost:8000
```
Then type in the browser 

```bash 
localhost:8000
```

## Work with api

In postman login with email and password - post request

```bash
/api/login
```

it will return token.

Get json users data with jwt - get request
add given jwt from login

```bash
/api/get_users
```

Get users in xml - get request

```bash
/api/get_users_xml
```




