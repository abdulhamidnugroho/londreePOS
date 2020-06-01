# LondreePOS-Laravel

LondreePOS Laravel-RESTful API

## Install with Composer

```
    1. Clone / Download Repo
    2. $ php composer.phar install or composer install
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

## For using the API with Postman

```
   1. Login with the credentials
   2. Get the Token
   3. Use the Token in the Authorization Header for every request
```

