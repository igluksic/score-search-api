#SCORE API DEMO
By Igor Luksic

##Find score for your popular term

Want to know what your term scores on Github? Search it up. More sources to be added.

##Installation:

1. Do the composer install to install all necessary dependencies
```
composer install
cp .env.example .env
```

2. Edit .env to setup your DB access, after that run migrations to create relevant tables and seed them afterwards:
```
php artisan migrate
php artisan db:seed
```

3. Run your local php server service (or set up your own server by pointing document root to public/ directory):
```
php -S localhost:8000 -t public
```

4. Enabling authorization in .env: (optional)
```
USE_AUTH=1
```
Seeder already added demo user for your convinience:

```
email: demouser@test.local
password: DemoPass123
```
Delete this user if not needed.


##Authorization

How to get Oauth token:

Send POST request to /auth/login route with "email" and "password" parameters; e.g. in Postman:
```
POST http://localhost:8000/auth/login?email=demouser@test.local&password=DemoPass123
```
You will be provided with token param which can be used to authorize with API, e.g.:
```
GET http://localhost:8000/score/ruby?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJzY29yZSIsInN1YiI6MSwiaWF0IjoxNTQwODI1MzI4LCJleHAiOjE1NDA4Mjg5Mjh9.JlLg2M2yKQOONl_6QyU07BMbuOsabpwxsmB9IXjasBU
```

##API usage

Please note that if authorization is enabled, token param is required with every request.

### V1 endpoint
[base_uri]/score/{term}

Where {term} is the term we want to find out score [0, 10] for

V1 api request example:
```
http://localhost:8000/score/ruby
```
Response:
```
{
    "term": "ruby",
    "score": "2.25"
}
```

## V2 endpoint
To comply with [JSONAPI schema](http://jsonapi.org) minimal requirements

[base_uri]/v2/score/{term}

V2 api request example:
```
http://localhost:8000/v2/score/ruby
+Set "Accept" header to: application/vnd.api+json
```
Response:
```
{
    "data": {
        "type": "score",
        "id": 5,
        "attributes": {
            "term": "ruby",
            "score": "2.25"
        }
    }
}
```

#Built with help of Lumen:
See documentation for requirements

# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
