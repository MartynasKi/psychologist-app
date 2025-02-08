<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body>
    <h1>Hello {{ $appointment->client_name }},</h1>
    <p>Your appointment has been successfully booked.</p>
    <p><strong>Date & Time:</strong> {{ $appointment->timeSlot->start_time }} - {{ $appointment->timeSlot->end_time }}</p>
    <p><strong>Psychologist:</strong> {{ $appointment->timeSlot->psychologist->name }}</p>
    <p>Thank you for choosing our service.</p>
</body>
</html>