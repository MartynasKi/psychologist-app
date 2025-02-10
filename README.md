# Psychologist API

## Setup

Clone this GIT repository and run the following commands:

```bash
composer install && cp .env.example .env && php artisan key:generate && php artisan migrate
```

## Run tests

```bash
php artisan test
```

## Usage

```bash
php artisan serve
```

## API Documentation

This API follows standard HTTP status codes:

-   200 family for successful requests (e.g., 200 OK, 201 Created),
-   400 family for client errors.

Postman documentation can be found [here](https://documenter.getpostman.com/view/39260809/2sAYX8KMmk).
