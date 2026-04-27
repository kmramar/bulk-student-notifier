<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bulk Notifier | Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background:
                linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px),
                radial-gradient(circle at top right, rgba(128, 0, 255, .22), transparent 32%),
                radial-gradient(circle at bottom left, rgba(0, 170, 255, .18), transparent 30%),
                #0f0f12;
            background-size: 42px 42px, 42px 42px, auto, auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #fff;
        }

        .login-card {
            width: 430px;
            background: rgba(24, 24, 27, .92);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 26px;
            padding: 42px;
            box-shadow: 0 30px 90px rgba(0,0,0,.55);
            backdrop-filter: blur(18px);
        }

        .brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-icon {
            width: 68px;
            height: 68px;
            margin: 0 auto 18px;
            border-radius: 22px;
            background: linear-gradient(135deg, #9333ea, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 18px 40px rgba(147, 51, 234, .35);
            font-size: 28px;
        }

        .brand h1 {
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .brand p {
            margin-top: 8px;
            color: #a1a1aa;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            margin-bottom: 14px;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(147, 51, 234, .14);
            color: #d8b4fe;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .alert-success {
            background: rgba(34, 197, 94, .12);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, .22);
        }

        .alert-error {
            background: rgba(239, 68, 68, .12);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, .22);
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            color: #e4e4e7;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #71717a;
            font-size: 15px;
        }

        input {
            width: 100%;
            height: 54px;
            padding: 0 16px 0 46px;
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,.08);
            outline: none;
            background: rgba(39, 39, 42, .85);
            color: #fff;
            font-size: 14px;
        }

        input:focus {
            border-color: rgba(147, 51, 234, .75);
            box-shadow: 0 0 0 4px rgba(147, 51, 234, .12);
        }

        input::placeholder {
            color: #71717a;
        }

        .forgot {
            display: block;
            margin: 4px 0 22px;
            color: #d4d4d8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .forgot:hover {
            color: #c084fc;
        }

        .login-btn {
            width: 100%;
            height: 56px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, #9333ea, #2563eb);
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 18px 38px rgba(37, 99, 235, .25);
        }

        .login-btn:hover {
            transform: translateY(-1px);
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            color: #71717a;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand">
        <div class="brand-icon">
            <i class="fas fa-bell"></i>
        </div>

        <span class="badge">Admin Access</span>
        <h1>Bulk Notifier</h1>
        <p>Manage student notifications in one secure dashboard.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
        </div>

        <a class="forgot" href="{{ route('admin.forgot.password') }}">Forgot Password?</a>

        <button type="submit" class="login-btn">
            Login to Dashboard <i class="fas fa-arrow-right"></i>
        </button>
    </form>

    <div class="footer-text">
        © {{ date('Y') }} Bulk Notifier. Admin Panel.
    </div>
</div>

</body>
</html>