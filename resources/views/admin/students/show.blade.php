@extends('admin.layouts.master')

@section('title', 'Student Details')
@section('page_title', 'Student Details')

@section('content')
    <div class="mb-3">
        <a href="/admin/students" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Students
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Student Information Card -->
            <div class="card mb-24">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Student Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="detail-row">
                        <span class="label">ID:</span>
                        <span>{{ $student->id }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Name:</span>
                        <span>{{ $student->name }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Email:</span>
                        <span>{{ $student->email }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Phone:</span>
                        <span>{{ $student->phone }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Course:</span>
                        <span>{{ $student->course }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Message:</span>
                        <span>{{ $student->message }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Email Status:</span>
                        <span>
                            @if($student->email_status == 1)
                                <span class="badge badge-sent">Sent</span>
                            @else
                                <span class="badge badge-pending">Pending</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">SMS Status:</span>
                        <span>
                            @if($student->sms_status == 1)
                                <span class="badge badge-sent">Sent</span>
                            @else
                                <span class="badge badge-pending">Pending</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="label">Response:</span>
                        <span>{{ $student->response ?? 'No Reply' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Actions Card -->
            <div class="card mb-24">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/admin/students/{{ $student->id }}/send-email" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-envelope me-2"></i>Send Email
                        </button>
                    </form>
                    
                    <form action="/admin/students/{{ $student->id }}/send-sms" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-warning text-white w-100">
                            <i class="fas fa-sms me-2"></i>Send SMS
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Update Status Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Update Status
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/student/{{ $student->id }}/update-status" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Email Status</label>
                            <select name="email_status" class="form-select">
                                <option value="0" {{ $student->email_status == 0 ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $student->email_status == 1 ? 'selected' : '' }}>Sent</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">SMS Status</label>
                            <select name="sms_status" class="form-select">
                                <option value="0" {{ $student->sms_status == 0 ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $student->sms_status == 1 ? 'selected' : '' }}>Sent</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Response</label>
                            <input type="text" name="response" class="form-control" value="{{ $student->response }}" placeholder="Enter response">
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
