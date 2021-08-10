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
composer migrate
```

Run user seeder

```bash
composer run:seeder
```

Run project locally:

```bash
composer serve
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




