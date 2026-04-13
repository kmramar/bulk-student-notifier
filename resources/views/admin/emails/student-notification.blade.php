<!DOCTYPE html>
<html>
<head>
    <title>Student Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; padding: 20px;">
    

    <div style="max-width: 600px; background: white; margin: auto; padding: 25px; border-radius: 10px; border: 1px solid #ddd;">
        <h2 style="color: #2563eb; margin-bottom: 20px;">Student Notification</h2>

        <p><strong>Hello {{ $student->name }},</strong></p>

        <p>This is a notification regarding your course details.</p>

        <p><strong>Course:</strong> {{ $student->course }}</p>
        <p><strong>Message:</strong> {{ $student->message }}</p>

        <p style="margin-top: 20px;">Thank you.</p>
        <p><strong>Bulk Notifier Team</strong></p>
    </div>

</body>
</html>