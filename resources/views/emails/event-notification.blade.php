<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Registration Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 40px;
            line-height: 1.6;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        h1 {
            color: #002c5f;
            font-size: 24px;
        }
        p {
            font-size: 16px;
            margin-bottom: 16px;
        }
        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #004080;
        }
        .details strong {
            display: inline-block;
            width: 100px;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Event Registration Confirmed!</h1>

        <p>Dear {{ $studentName }},</p>

        <p>We are pleased to inform you that your registration for the following event has been successfully processed:</p>

        <div class="details">
            <p><strong>Event:</strong> {{ $event->program_name }}</p>
            <p><strong>Date:</strong> {{ $event->date }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Club:</strong> {{ $event->club_name }}</p>
            <p><strong>Fee:</strong>RM {{ $event->fee }}.00</p>
        </div>

        <p>We look forward to your active participation and hope the event provides valuable and enriching experiences.</p>

        <p>If you have any questions or require further assistance, please feel free to contact our support team.</p>

        <p>Sincerely,</p>
        <p><strong>UTHM Campus Event Management System</strong></p>

        <div class="footer">
            This is an automated message. Kindly do not reply to this email.
        </div>
    </div>
</body>
</html>
