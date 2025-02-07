# Psychologist API

## Setup

```bash
composer install && cp .env.example .env && php artisan key:generate && php artisan migrate --seed
```

## Run tests

```bash
php artisan test
```

## Usage

```bash
php artisan serve
```

## Endpoints

### Create a psychologist

```bash
curl -X POST http://127.0.0.1:8000/psychologists -H "Content-Type: application/json" -d '{"name": "John Doe", "email": "john@doe.com"}'
```

### Get list of psychologists

```bash
curl http://127.0.0.1:8000/psychologists
```

### Create a time slot

```bash
curl -X POST http://127.0.0.1:8000/psychologists/{id}/time-slots -H "Content-Type: application/json" -d '{"start_time": "2024-01-01 10:00:00", "end_time": "2024-01-01 11:00:00"}'
```

### Get list of time slots

```bash
curl http://127.0.0.1:8000/psychologists/{id}/time-slots
```

### Update a time slot

```bash
curl -X PUT http://127.0.0.1:8000/time-slots/{id} -H "Content-Type: application/json" -d '{"start_time": "2024-01-01 10:00:00", "end_time": "2024-01-01 11:00:00"}'
```

### Create an appointment

```bash
curl -X POST http://127.0.0.1:8000/appointments -H "Content-Type: application/json" -d '{"time_slot_id": 1, "client_name": "John Doe", "client_email": "john@doe.com"}'
```

### Get list of appointments

```bash
curl http://127.0.0.1:8000/appointments
```
