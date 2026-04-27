@extends('admin.layouts.auth')

@section('content')

<div class="login-card">

    <div class="brand">
        <h1>Set New Password</h1>
    </div>

    <form method="POST" action="{{ route('admin.reset.password') }}">
        @csrf

        <input type="hidden" name="email" value="{{ session('email') }}">

        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button class="login-btn">Update Password</button>
    </form>

</div>

@endsection