@extends('admin.layouts.master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <!-- Statistics Cards -->
    <div class="row">
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

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="/admin/students" class="btn btn-primary w-100">
                        <i class="fas fa-users me-2"></i>Manage Students
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/" class="btn btn-success w-100">
                        <i class="fas fa-upload me-2"></i>Upload CSV
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="/admin/profile" class="btn btn-secondary w-100">
                        <i class="fas fa-user-cog me-2"></i>Profile Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection