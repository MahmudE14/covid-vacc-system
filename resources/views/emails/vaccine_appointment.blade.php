<!DOCTYPE html>
<html>
<head>
    <title>Welcome to the COVID-19 Vaccine Program</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>

    <p>We are excited to inform you that your vaccine appointment has been scheduled.</p>

    <p><strong>Appointment Details:</strong></p>
    <ul>
        <li><strong>Center:</strong> {{ $appointment->vaccineCenter->name }}</li>
        <li><strong>Location:</strong> {{ $appointment->vaccineCenter->location }}</li>
        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->scheduled_date)->format('F j, Y') }}</li>
        <li><strong>Status:</strong> {{ $appointment->status }}</li>
    </ul>

    <p>Thank you for registering with us! We look forward to seeing you.</p>

    <p>Best regards,<br>The Vaccine Program Team</p>
</body>
</html>
