<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BulkNotify Admin Panel</title>

   <link rel="stylesheet" href="{{ asset('css/admin-auth.css') }}">

     {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">    

    {{-- Font Awesome for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="login-page">

        {{-- Left Panel --}}
        <div class="login-left">
            <div class="left-overlay-shape"></div>

            <div class="brand">
                <i class="fas fa-bell"></i>
                <span>BulkNotify</span>
            </div>

            <div class="left-content">
                <div class="illustration-wrap">
                    <div class="illustration-circle">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="illustration-card"></div>
                </div>

                <h1>Welcome to BulkNotify</h1>
                <p>
                    Manage student notifications with email and SMS from
                    one dashboard.
                </p>

                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> Bulk Email & SMS</li>
                    <li><i class="fas fa-check-circle"></i> CSV Upload System</li>
                    <li><i class="fas fa-check-circle"></i> Status Tracking</li>
                </ul>
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="login-right">
            <div class="login-card">
                <h2>Sign in</h2>

                @if(session('error'))
                    <div class="alert-box alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-box alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- IMPORTANT: action apne current route ke hisaab se yahi rakho --}}
                <form action="{{ url('/admin/login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-box">
                            <i class="fas fa-envelope"></i>
                            <input
                                type="email"
                                name="email"
                                placeholder="Enter your email"
                                value="{{ old('email') }}"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-box">
                            <i class="fas fa-lock"></i>
                            <input
                                type="password"
                                name="password"
                                placeholder="Enter password"
                                required
                            >
                        </div>
                    </div>

                    <button type="submit" class="login-btn">Sign In</button>

                    <a href="#" class="forgot-link">Forgot Password?</a>
                </form>
            </div>
        </div>

    </div>

</body>
</html>