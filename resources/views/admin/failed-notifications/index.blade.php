@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Failed Notifications</h4>
            <a href="{{ route('admin.students.index') }}" class="btn btn-light btn-sm">
                Back to Students
            </a>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Email Status</th>
                                <th>SMS Status</th>
                                <th>Error</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->name ?? 'N/A' }}</td>
                                    <td>{{ $student->email ?? 'N/A' }}</td>
                                    <td>{{ $student->phone ?? 'N/A' }}</td>

                                    <td>
                                        @if($student->email_status == 1)
                                            <span class="badge bg-success">Sent</span>
                                        @else
                                            <span class="badge bg-danger">Failed/Pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($student->sms_status == 1)
                                            <span class="badge bg-success">Sent</span>
                                        @else
                                            <span class="badge bg-danger">Failed/Pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $student->notification_error ?? 'No error message' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    No failed notifications found.
                </div>
            @endif

        </div>
    </div>

</div>
@endsection