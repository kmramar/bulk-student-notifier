<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
</head>
<body>

<div class="admin-layout">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main -->
    <div class="admin-main">

        <!-- Header -->
        @include('admin.partials.header')

        <!-- Content -->
        <div class="admin-content">
            @yield('content')
        </div>

    </div>

</div>

</body>
</html>