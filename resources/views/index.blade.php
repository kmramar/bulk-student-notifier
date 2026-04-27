<!DOCTYPE html>
<html>
<head>
    <title>Bulk Notifier</title>
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="upload-container">
        <h2>Upload CSV File</h2>

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

       <form action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="csv" accept=".csv" required>

    <button type="submit">
        Upload & Process
    </button>
</form>
        <p class="note">Accepted format: .csv only</p>

        @if(isset($students) && $students->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Message</th>
                        <th>Email Status</th>
                        <th>SMS Status</th>
                        <th>Response</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->course }}</td>
                            <td>{{ $student->message }}</td>

                            <td>
                                @if($student->email_status == 1)
                                    <span class="status-sent">Sent</span>
                                @else
                                    <span class="status-pending">Pending</span>
                                @endif
                            </td>

                            <td>
                                @if($student->sms_status == 1)
                                    <span class="status-sent">Sent</span>
                                @else
                                    <span class="status-pending">Pending</span>
                                @endif
                            </td>

                            <td>
                                @if($student->response)
                                    {{ $student->response }}
                                @else
                                    No Reply
                                @endif
                            </td>
                            {{-- Ye kya kar raha hai
                                                action="/student/{{ $student->id }}"
                                                Us student ki ID wale route par request bhej raha hai
                                                method="POST"
                                                HTML forms direct DELETE nahi bhejte, isliye POST use hota hai
                                                @method('DELETE')
                                                Laravel ko batata hai ki is request ko DELETE treat karo
                                                @csrf
                                                {{-- Security token -- --}}

                            <td class="action-cell">
                                <button type="button" class="action-btn view-btn" disabled>
                                    View
                                </button>

                                <form action="/student/{{ $student->id }}" method="POST" class="inline-form"
                                      onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</body>
</html>