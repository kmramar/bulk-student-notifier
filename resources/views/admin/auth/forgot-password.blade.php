@extends('admin.layouts.auth')

@section('content')

<div class="login-card">

    <div class="brand">
        <div class="brand-icon">
            <i class="fas fa-key"></i>
        </div>
        <h1>Bulk Notifier</h1>
        <p>Reset your admin password</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.send.otp') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter admin email" required>
            </div>
        </div>

        <button class="login-btn">Send OTP →</button>
    </form>

    <a class="forgot" href="{{ route('admin.login') }}">Back to Login</a>

</div>

@endsection