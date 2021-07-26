## PHP Registration

Install project

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

Run project locally:

```bash
cd public/
php -S localhost:8000
```
Then type in the browser 

```bash 
localhost:8000
```

In postman login with post request with email and password

```bash
/api/login
```

it will return token.

Get users data with jwt

```bash
/api/get_users
```

Get users in xml

```bash
/api/get_users_xml
```




