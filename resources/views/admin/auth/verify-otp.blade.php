@extends('admin.layouts.auth')

@section('content')

<div class="login-card">

    <div class="brand">
        <h1>Verify OTP</h1>
        <p>Enter OTP sent to your email</p>
    </div>

    <form method="POST" action="{{ route('admin.verify.otp') }}">
        @csrf

        <input type="hidden" name="email" value="{{ session('email') }}">

        <div class="form-group">
            <label>OTP</label>
            <div class="input-wrap">
                <i class="fas fa-shield-alt"></i>
                <input type="text" name="otp" placeholder="Enter OTP" required>
            </div>
        </div>

        <button class="login-btn">Verify OTP</button>
    </form>

</div>

@endsection