<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>

    <!-- Login / auth page CSS -->
    <<link rel="stylesheet" href="{{ asset('css/admin-auth.css') }}">

     {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Full forgot password page wrapper -->
    <div class="login-wrapper">

        <!-- Left side design section -->
        <div class="login-left">
            <div class="left-content">
                <h2>Forgot Password?</h2>
                <p>Reset your admin account password here.</p>
                <p>Bulk Notifier Admin Panel</p>
                <a href="/admin/login" class="left-btn">BACK TO LOGIN</a>
            </div>
        </div>

        <!-- Right side forgot password form -->
        <div class="login-right">
            <div class="login-box">
                <h2>Reset Password</h2>

                @if ($errors->any())
                    <div class="error-message">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Forgot password form -->
                <form action="/admin/forgot-password" method="POST">
                    @csrf

                    <input type="email" name="email" placeholder="Enter admin email" required>
                    <input type="password" name="new_password" placeholder="Enter new password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm new password" required>

                    <button type="submit">UPDATE PASSWORD</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>