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

## Api Documentation

Postman documentation can be found [here](https://documenter.getpostman.com/view/39260809/2sAYX8KMmk).

## Endpoints

This API follows standard HTTP status codes:

-   200 family for successful requests (e.g., 200 OK, 201 Created),
-   400 family for client errors.

If you want to use the API, you can use the following endpoints:

### Create a psychologist (POST /psychologists)

Inputs:

| Field   | Required | Description                                |
| ------- | -------- | ------------------------------------------ |
| `name`  | Yes      | Name of the psychologist                   |
| `email` | Yes      | Email of the psychologist (must be unique) |

Example request:

```bash
curl -X POST http://127.0.0.1:8000/psychologists \
-H "Content-Type: application/json" \
-d '{"name": "New Psychologist", "email": "new@email.com"}'
```

Example response:

```json
{
    "message": "Psychologist created successfully",
    "data": {
        "id": 1,
        "name": "New Psychologist",
        "email": "new@email.com"
    }
}
```

### Get list of psychologists (GET /psychologists)

Example request:

```bash
curl http://127.0.0.1:8000/psychologists
```

Example response:

```json
{
    "data": [
        {
            "id": 1,
            "name": "New Psychologist",
            "email": "new@email.com"
        },

        {
            "id": 2,
            "name": "Another Psychologist",
            "email": "another@email.com"
        },

        ...
    ]
}
```

### Create a time slot for a psychologist (POST /psychologists/{psychologist_id}/time-slots)

Inputs:

| Field        | Required | Description                                               |
| ------------ | -------- | --------------------------------------------------------- |
| `start_time` | Yes      | Start time of the time slot (YYYY-MM-DD HH:MM:SS)         |
| `end_time`   | Yes      | End time of the time slot (YYYY-MM-DD HH:MM:SS)           |
| `is_booked`  | No       | Whether the time slot is booked (Boolean, default: false) |

Example request:

```bash
curl -X POST http://127.0.0.1:8000/psychologists/{psychologist_id}/time-slots \
-H "Content-Type: application/json" \
-d '{"start_time": "2024-01-01 10:00:00", "end_time": "2024-01-01 11:00:00"}'
```

Example response:

```json
{
    "message": "Time slot created successfully",
    "data": {
        "id": 1,
        "start_time": "2024-01-01 18:59:59",
        "end_time": "2024-01-01 19:00:00",
        "is_booked": false
    }
}
```

### Get list of time slots for a psychologist (GET /psychologists/{psychologist_id}/time-slots)

Example request:

```bash
curl http://127.0.0.1:8000/psychologists/{psychologist_id}/time-slots
```

Example response:

```json
{
    "data": [
        {
            "id": 1,
            "start_time": "2025-02-07 18:00:00",
            "end_time": "2025-02-07 19:00:00",
            "is_booked": false
        },
        {
            "id": 2,
            "start_time": "2025-02-07 19:00:00",
            "end_time": "2025-02-07 20:00:00",
            "is_booked": true
        }
    ]
}
```

### Create an appointment (POST /appointments)

Inputs:

| Field          | Description         | Required |
| -------------- | ------------------- | -------- |
| `time_slot_id` | ID of the time slot | Yes      |
| `client_name`  | Name of the client  | Yes      |
| `client_email` | Email of the client | Yes      |

Example request:

```bash
curl -X POST http://127.0.0.1:8000/appointments \
-H "Content-Type: application/json" \
-d '{"time_slot_id": 1, "client_name": "John Doe", "client_email": "john@doe.com"}'
```

Example response:

```json
{
    "message": "Appointment created successfully",
    "data": {
        "id": 1,
        "time_slot_id": "1",
        "client_name": "John Doe",
        "client_email": "john@doe.com"
    }
}
```

### Get list of upcoming appointments (GET /appointments)

Example request:

```bash
curl http://127.0.0.1:8000/appointments
```

Example response:

```json
{
    "data": [
        {
            "id": 1,
            "time_slot": {
                "id": 1,
                "psychologist": {
                    "id": 1,
                    "name": "New Psychologist",
                    "email": "new@email.com"
                },
                "start_time": "2025-02-09 18:00:00",
                "end_time": "2025-02-09 19:00:00",
                "is_booked": true
            },
            "client_name": "Name",
            "client_email": "client@email.com"
        }
    ]
}
```
