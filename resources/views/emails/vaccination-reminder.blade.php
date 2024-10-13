<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vaccination Reminder</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}!</h1>
    <p>This is a reminder that your COVID vaccination is scheduled for tomorrow ({{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('F j, Y') }}).</p>

    <p><strong>Appointment Details:</strong></p>
    <ul>
        <li><strong>Center:</strong> {{ $appointment->vaccineCenter->name }}</li>
        <li><strong>Location:</strong> {{ $appointment->vaccineCenter->location }}</li>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('F j, Y') }}</li>
        <li><strong>Status:</strong> {{ $appointment->status }}</li>
    </ul>

    <p>Please make sure to arrive at the vaccine center on time. Thank you!</p>
</body>
</html>
