<!DOCTYPE html>
<html>
<head>
    <title>Event Notification</title>
</head>
<body>
    <h1>Hello {{ $studentName }},</h1>
    <p>You have successfully registered for the event: <strong>{{ $event->program_name }}</strong>.</p>
    <p>Date: {{ $event->date }}</p>
    <p>Location: {{ $event->location }}</p>
    <p>Thank you!</p>
</body>
</html>
