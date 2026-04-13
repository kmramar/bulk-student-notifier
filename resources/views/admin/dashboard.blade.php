@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<h2 class="page-title">Dashboard</h2>

<!-- Stats Cards -->
<div class="row g-4 mb-4">

    <!-- Total Students -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-value">{{ $totalStudents }}</div>
            <div class="stat-card-label">Total Students</div>
        </div>
    </div>

    <!-- Emails Sent -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-card-value">{{ $emailsSent }}</div>
            <div class="stat-card-label">Emails Sent</div>
        </div>
    </div>

    <!-- SMS Sent -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon warning">
                <i class="fas fa-comment-dots"></i>
            </div>
            <div class="stat-card-value">{{ $smsSent }}</div>
            <div class="stat-card-label">SMS Sent</div>
        </div>
    </div>

    <!-- Failed / Pending -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-card-value">{{ $failedCount }}</div>
            <div class="stat-card-label">Failed / Pending</div>
        </div>
    </div>

</div>

<!-- Quick Actions -->
<div class="quick-action-box">
    <h3>Quick Actions</h3>

    <div class="quick-action-buttons">

        <a href="/admin/students" class="btn btn-primary">
            <i class="fas fa-users"></i> Manage Students
        </a>

        <a href="/" class="btn btn-success">
            <i class="fas fa-upload"></i> Upload CSV
        </a>

        <a href="/admin/email" class="btn btn-warning">
            <i class="fas fa-envelope"></i> Send Email
        </a>

        <a href="/admin/sms" class="btn btn-secondary">
            <i class="fas fa-comment-dots"></i> Send SMS
        </a>

    </div>
</div>

@endsection