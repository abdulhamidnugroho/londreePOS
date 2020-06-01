# LaravelAPIBoilerplateJWTBook

[![Build Status](https://travis-ci.org/Tony133/LaravelAPIBoilerplateJWTBook.svg?branch=master)](https://travis-ci.org/Tony133/LaravelAPIBoilerplateJWTBook)

Simple Example Api Rest Book with Laravel 7.x and Json Web Token

## Install with Composer

```
    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install or composer install
```

## Set Environment

```
    $ cp .env.example .env
```

## Set the application key

```
   $ php artisan key:generate
```

## Generate jwt secret key

```
    $ php artisan jwt:secret
```

## Run migrations and seeds

```
   $ php artisan migrate --seed
```

## Getting with Curl Books

```
    $ curl -H 'content-type: application/json' -v -X GET http://127.0.0.1:8000/api/books -H 'Authorization: Bearer [:token]'
    $ curl -H 'content-type: application/json' -v -X GET http://127.0.0.1:8000/api/books/:id -H 'Authorization: Bearer [:token]'
    $ curl -H 'content-type: application/json' -v -X POST -d '{"title":"Foo bar","description":"Lorem ipsum", "category": 2}' http://127.0.0.1:8000/api/books -H 'Authorization: Bearer [:token]'
    $ curl -H 'content-type: application/json' -v -X PUT -d '{"title":"Foo bar","description":"Lorem ipsum"}' http://127.0.0.1:8000/api/books/:id -H 'Authorization: Bearer [:token]'
    $ curl -H 'content-type: application/json' -v -X DELETE http://127.0.0.1:8000/api/books/:id -H 'Authorization: Bearer [:token]'
```

## Getting with Curl Categories

```
    $ curl -H 'content-type: application/json' -v -X GET http://127.0.0.1:8000/api/categories -H 'Authorization: Bearer [:token]'
    $ curl -H 'content-type: application/json' -v -X GET http://127.0.0.1:8000/api/categories/:id -H 'Authorization: Bearer [:token]'
    $ curl -H 'content-type: application/json' -v -X POST -d '{"book_id":"2","name":"Foo Bar"}' http://127.0.0.1:8000/api/categories -H 'Authorization: Bearer [:token]'
    $ curl -H 'content-type: application/json' -v -X PUT -d '{"book_id":"2","name":"Foo Bar"}' http://127.0.0.1:8000/api/categories/:id -H 'Authorization: Bearer [:token]'
    $ curl -H 'content-type: application/json' -v -X DELETE http://127.0.0.1:8000/api/categories/:id -H 'Authorization: Bearer [:token]'
```

## User Registration with Curl

```
    $ curl  -H 'content-type: application/json' -v -X POST -d '{"name":"tony","email":"tony_admin@laravel.com","password":"secret"}' http://127.0.0.1:8000/api/auth/register
```

## User Authentication with Curl

```
    $ curl  -H 'content-type: application/json' -v -X POST -d '{"email":"tony_admin@laravel.com","password":"secret"}' http://127.0.0.1:8000/api/auth/login
```

## Get the logged in user with Curl

```
    $ curl  -H 'content-type: application/json' -v -X GET http://127.0.0.1:8000/api/auth/me?token=[:token]
```

## User Logout with curl

```
    $ curl  -H 'content-type: application/json' -v -X GET http://127.0.0.1:8000/api/auth/logout?token=[:token]

```

## Refresh token with curl

```
    $ curl  -H 'content-type: application/json' -v -X GET http://127.0.0.1:8000/api/auth/refresh?token=[:token]

```

## User Forgot Password with Curl

```
    $ curl -H 'content-type: application/json' -v POST -d '{"email": "tony_admin@laravel.com"}' http://127.0.0.1:8000/api/auth/forgot
```

## User Change Password with Curl

```
    $ curl -H 'content-type: application/json' -v POST -d '{"email": "tony_admin@laravel.com", "password": "secret"}' http://127.0.0.1:8000/api/auth/change?token=[:token]
```

## Example Created using LaravelAPIBoilerplateJWT

[LaravelAPIBoilerplateJWT](https://github.com/Tony133/LaravelAPIBoilerplateJWT)
