@extends('admin.layouts.master')

@section('title', 'Students List')
@section('page_title', 'Students Management')

@section('content')

<!-- Statistics Cards: Shows overall counts on top of the page -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-value">{{ $totalStudents }}</div>
            <div class="stat-card-label">Total Students</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-card-value">{{ $emailSent }}</div>
            <div class="stat-card-label">Emails Sent</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-sms"></i>
            </div>
            <div class="stat-card-value">{{ $smsSent }}</div>
            <div class="stat-card-label">SMS Sent</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon danger">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-value">{{ $noReply }}</div>
            <div class="stat-card-label">No Reply</div>
        </div>
    </div>
</div>

<!-- Action Bar: Buttons for sending bulk email, SMS, and CSV upload -->
<div class="action-bar mb-3">
    <div class="d-flex align-items-center gap-2 flex-wrap">

        <!-- Bulk Email Button -->
        <form action="/admin/students/send-email-all" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success"
                onclick="return confirm('Send email to all students?')">
                <i class="fas fa-envelope me-2"></i>Email All
            </button>
        </form>

        <!-- Bulk SMS Button -->
        <form action="/admin/students/send-sms-all" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning text-white"
                onclick="return confirm('Send SMS to all students?')">
                <i class="fas fa-sms me-2"></i>SMS All
            </button>
        </form>

        <!-- CSV Upload Button -->
        <a href="/" class="btn btn-primary">
            <i class="fas fa-upload me-2"></i>Upload CSV
        </a>
    </div>

    <!-- Search Box: Search students by name, email, or course -->
    <div class="search-box mt-2">
        <form action="/admin/students" method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                class="form-control" placeholder="Search name, email or course">

            <button type="submit" class="btn btn-primary btn-sm">Search</button>

            @if($search)
                <a href="/admin/students" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>
    </div>
</div>

<!-- Students Table: Displays all uploaded students -->
<div class="card">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>S.No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Email Status</th>

                        <!-- Shows failed email error reason if email sending fails -->
                        <th>Failed Reason</th>

                        <th>SMS Status</th>
                        <th>Response</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($students as $student)
                        <tr>

                            <!-- Serial number for each student row -->
                            <td>{{ $loop->iteration }}</td>

                            <!-- Student basic details -->
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->course }}</td>

                            <!-- Email Status: Shows Sent if email_status is 1, otherwise Pending -->
                            <td>
                                @if($student->email_status == 1)
                                    <span class="badge bg-success">Sent</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            <!-- Failed Reason: Shows error message if notification_error exists -->
                            <td>
                                @if(!empty($student->notification_error))
                                    <span class="badge bg-danger">Failed</span>
                                    <br>
                                    <small class="text-danger">
                                        {{ \Illuminate\Support\Str::limit($student->notification_error, 45) }}
                                    </small>
                                @else
                                    <span class="badge bg-success">No Error</span>
                                @endif
                            </td>

                            <!-- SMS Status: Shows Sent if sms_status is 1, otherwise Pending -->
                            <td>
                                @if($student->sms_status == 1)
                                    <span class="badge bg-success">Sent</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            <!-- Response: Shows student response or No Reply -->
                            <td>
                                @if($student->response)
                                    <span class="badge bg-info text-dark">{{ $student->response }}</span>
                                @else
                                    <span class="badge bg-secondary">No Reply</span>
                                @endif
                            </td>

                            <!-- Actions: Edit, View, and Delete student -->
                            <td>
                                <div class="d-flex gap-1">

                                    <!-- Edit Button -->
                                    <a href="/admin/students/{{ $student->id }}/edit" class="action-btn edit-btn">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- View Button -->
                                    <a href="/admin/students/{{ $student->id }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="/student/{{ $student->id }}" method="POST"
                                        onsubmit="return confirm('Delete this student?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- No Data Message: Shows when no students are available -->
@if($students->count() == 0)
    <div class="card mt-3">
        <div class="card-body text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No students found</h5>
            <a href="/" class="btn btn-primary mt-3">Upload CSV File</a>
        </div>
    </div>
@endif

@endsection