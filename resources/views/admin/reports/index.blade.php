@extends('admin.layouts.master')

@section('title', 'Reports')
@section('page_title', 'Reports / History')

@section('content')

<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-value">{{ $totalStudents ?? 0 }}</div>
            <div class="stat-card-label">Total Students</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-card-value">{{ $emailSent ?? 0 }}</div>
            <div class="stat-card-label">Emails Sent</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-sms"></i>
            </div>
            <div class="stat-card-value">{{ $smsSent ?? 0 }}</div>
            <div class="stat-card-label">SMS Sent</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon danger">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-value">{{ $noReply ?? 0 }}</div>
            <div class="stat-card-label">No Reply</div>
        </div>
    </div>
</div>

<div class="card mb-24">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-chart-line me-2"></i>Summary Report
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="details-side-card text-center h-100">
                    <h3>Total Students</h3>
                    <div class="stat-card-value">{{ $totalStudents ?? 0 }}</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="details-side-card text-center h-100">
                    <h3>Email Success</h3>
                    <div class="stat-card-value">{{ $emailSent ?? 0 }}</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="details-side-card text-center h-100">
                    <h3>SMS Success</h3>
                    <div class="stat-card-value">{{ $smsSent ?? 0 }}</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="details-side-card text-center h-100">
                    <h3>No Reply</h3>
                    <div class="stat-card-value">{{ $noReply ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-24">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-link me-2"></i>Quick Navigation
        </h5>
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <a href="/admin/students" class="btn btn-primary">
                <i class="fas fa-users me-2"></i>Students
            </a>

            <a href="/admin/email" class="btn btn-success">
                <i class="fas fa-envelope me-2"></i>Bulk Email
            </a>

            <a href="/admin/sms" class="btn btn-warning">
                <i class="fas fa-sms me-2"></i>Bulk SMS
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
            <i class="fas fa-info-circle me-2"></i>Report Notes
        </h5>
    </div>
    <div class="card-body">
        <p class="text-muted mb-2">This section provides a quick overview of bulk notification activity.</p>
        <p class="text-muted mb-2">You can use the students page to review individual status badges for email, SMS, and response.</p>
        <p class="text-muted mb-0">For a stronger GitHub/project showcase, this reports page acts as an admin summary dashboard.</p>
    </div>
</div>

@endsection