<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bulk Notifier | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}

        body{
            min-height:100vh;
            background:
                radial-gradient(circle at top right,rgba(147,51,234,.25),transparent 30%),
                radial-gradient(circle at bottom left,rgba(37,99,235,.22),transparent 30%),
                #0f0f12;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
            color:#fff;
        }

        .login-card{
            width:430px;
            background:rgba(24,24,27,.94);
            border:1px solid rgba(255,255,255,.08);
            border-radius:26px;
            padding:42px;
            box-shadow:0 30px 90px rgba(0,0,0,.55);
        }

        .brand{text-align:center;margin-bottom:28px}
        .brand-icon{
            width:68px;height:68px;margin:0 auto 18px;border-radius:22px;
            background:linear-gradient(135deg,#9333ea,#2563eb);
            display:flex;align-items:center;justify-content:center;font-size:28px;
        }

        .brand h1{font-size:30px;font-weight:800}
        .brand p{margin-top:8px;color:#a1a1aa;font-size:14px}

        .form-group{margin-bottom:18px}
        label{display:block;margin-bottom:9px;color:#e4e4e7;font-size:13px;font-weight:700}

        .input-wrap{position:relative}
        .input-wrap i{
            position:absolute;left:16px;top:50%;transform:translateY(-50%);
            color:#71717a;
        }

        input{
            width:100%;height:54px;padding:0 16px 0 46px;
            border-radius:15px;border:1px solid rgba(255,255,255,.08);
            background:rgba(39,39,42,.85);color:#fff;outline:none;
        }

        input:focus{
            border-color:rgba(147,51,234,.75);
            box-shadow:0 0 0 4px rgba(147,51,234,.12);
        }

        .login-btn{
            width:100%;height:56px;border:none;border-radius:16px;
            background:linear-gradient(135deg,#9333ea,#2563eb);
            color:#fff;font-weight:800;cursor:pointer;
        }

        .forgot{
            display:block;text-align:center;margin-top:18px;
            color:#d4d4d8;text-decoration:none;font-size:14px;font-weight:600;
        }

        .alert{
            padding:12px 14px;border-radius:14px;margin-bottom:18px;font-size:14px;
        }

        .alert-success{background:rgba(34,197,94,.12);color:#86efac}
        .alert-error{background:rgba(239,68,68,.12);color:#fca5a5}
    </style>
</head>
<body>

@yield('content')

</body>
</html>