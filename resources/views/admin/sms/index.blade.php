@extends('admin.layouts.master')

@section('title', 'Bulk SMS')
@section('page_title', 'Bulk SMS')

@section('content')

<div class="row mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-sms"></i>
            </div>
            <div class="stat-card-value">{{ $smsSent ?? 0 }}</div>
            <div class="stat-card-label">SMS Sent</div>
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
            <div class="stat-card-icon danger">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-value">{{ $pendingSms ?? 0 }}</div>
            <div class="stat-card-label">Pending SMS</div>
        </div>
    </div>
</div>

<div class="card mb-24">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-comment-dots me-2"></i>Bulk SMS Actions
        </h5>
    </div>
    <div class="card-body">
        <p class="text-muted mb-4">
            Send SMS alerts to all students directly from the admin dashboard.
        </p>

        <div class="d-flex flex-wrap gap-2">
            <form action="/admin/students/send-sms-all" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning" onclick="return confirm('Send SMS to all students?')">
                    <i class="fas fa-sms me-2"></i>Send SMS to All
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
            <i class="fas fa-mobile-alt me-2"></i>SMS Module Overview
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="details-side-card h-100">
                    <h3>Fast Alerts</h3>
                    <p class="text-muted mb-0">Use this module to notify all students instantly using bulk SMS workflow.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="details-side-card h-100">
                    <h3>Student Data</h3>
                    <p class="text-muted mb-0">SMS targets are based on the student records available in the system.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="details-side-card h-100">
                    <h3>Status Monitoring</h3>
                    <p class="text-muted mb-0">Track sending progress using student status and reporting modules.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection