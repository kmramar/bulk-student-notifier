<!DOCTYPE html>
<html>
<head>
    <title>Student Details</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container" style="max-width: 700px;">
        <h2>Student Details</h2>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <div class="detail-row">
            <span class="label">Name:</span>
            {{ $student->name }}
        </div>

        <div class="detail-row">
            <span class="label">Email:</span>
            {{ $student->email }}
        </div>

        <div class="detail-row">
            <span class="label">Phone:</span>
            {{ $student->phone }}
        </div>

        <div class="detail-row">
            <span class="label">Course:</span>
            {{ $student->course }}
        </div>

        <div class="detail-row">
            <span class="label">Message:</span>
            {{ $student->message }}
        </div>

        <div class="detail-row">
            <span class="label">Email Status:</span>
            @if($student->email_status == 1)
                <span class="status-sent">Sent</span>
            @else
                <span class="status-pending">Pending</span>
            @endif
        </div>

        <div class="detail-row">
            <span class="label">SMS Status:</span>
            @if($student->sms_status == 1)
                <span class="status-sent">Sent</span>
            @else
                <span class="status-pending">Pending</span>
            @endif
        </div>

        <div class="detail-row">
            <span class="label">Response:</span>
            {{ $student->response ?? 'No Reply' }}
        </div>

        <hr style="margin: 25px 0;">

        <h3 style="margin-bottom: 20px;">Update Status</h3>

        <form action="/student/{{ $student->id }}/update-status" method="POST">
            @csrf

            <div class="detail-row">
                <span class="label">Email Status:</span>
                <select name="email_status">
                    <option value="0" {{ $student->email_status == 0 ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ $student->email_status == 1 ? 'selected' : '' }}>Sent</option>
                </select>
            </div>

            <div class="detail-row">
                <span class="label">SMS Status:</span>
                <select name="sms_status">
                    <option value="0" {{ $student->sms_status == 0 ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ $student->sms_status == 1 ? 'selected' : '' }}>Sent</option>
                </select>
            </div>

            <div class="detail-row">
                <span class="label">Response:</span>
                <input type="text" name="response" value="{{ $student->response }}" placeholder="Enter response">
            </div>

            <button type="submit">Update</button>
        </form>

        <a href="/" class="back-btn">Back</a>
    </div>

</body>
</html>