@extends('admin.layouts.master')

@section('title', 'Bulk Email')
@section('page_title', 'Bulk Email')

@section('content')

<div class="row mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-card-value">{{ $emailSent ?? 0 }}</div>
            <div class="stat-card-label">Emails Sent</div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-value">{{ $totalStudents ?? 0 }}</div>
            <div class="stat-card-label">Total Students</div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-value">{{ $pendingEmails ?? 0 }}</div>
            <div class="stat-card-label">Pending Emails</div>
        </div>
    </div>
</div>

<div class="card mb-24">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-paper-plane me-2"></i>Bulk Email Actions
        </h5>
    </div>
    <div class="card-body">
        <p class="text-muted mb-4">
            Send notification email to all available students from one place.
        </p>

        <div class="d-flex flex-wrap gap-2">
            <form action="/admin/students/send-email-all" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('Send email to all students?')">
                    <i class="fas fa-envelope me-2"></i>Send Email to All
                </button>
            </form>

            <a href="/admin/students" class="btn btn-primary">
                <i class="fas fa-users me-2"></i>Manage Students
            </a>

            <a href="/" class="btn btn-secondary">
                <i class="fas fa-upload me-2"></i>Upload CSV
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-info-circle me-2"></i>Email Module Overview
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="details-side-card h-100">
                    <h3>Purpose</h3>
                    <p class="text-muted mb-0">Send bulk notification emails to students quickly from the admin panel.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="details-side-card h-100">
                    <h3>Input Source</h3>
                    <p class="text-muted mb-0">Student data is managed from the students list and CSV upload module.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="details-side-card h-100">
                    <h3>Status Tracking</h3>
                    <p class="text-muted mb-0">Delivery and pending status can be reviewed from the students and reports pages.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection