<!-- Admin Sidebar -->
<div class="admin-sidebar">
    
    <!-- Logo -->
    <div class="logo">
        <i class="fas fa-bell"></i>
        <span>Bulk Notify</span>
    </div>

    <!-- Menu -->
    <ul class="sidebar-menu">

        <!-- Dashboard -->
        <li>
            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active-menu' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Students -->
        <li>
            <a href="/admin/students" class="{{ request()->is('admin/students') || request()->is('admin/students/*') ? 'active-menu' : '' }}">
                <i class="fas fa-users"></i>
                <span>Students</span>
            </a>
        </li>

        <!-- Upload CSV -->
        <li>
            <a href="/" class="{{ request()->is('/') ? 'active-menu' : '' }}">
                <i class="fas fa-file-upload"></i>
                <span>Upload CSV</span>
            </a>
        </li>

        <!-- Bulk Email -->
        <li>
            <a href="/admin/email" class="{{ request()->is('admin/email') ? 'active-menu' : '' }}">
                <i class="fas fa-envelope"></i>
                <span>Bulk Email</span>
            </a>
        </li>

        <!-- Bulk SMS -->
        <li>
            <a href="/admin/sms" class="{{ request()->is('admin/sms') ? 'active-menu' : '' }}">
                <i class="fas fa-comment-dots"></i>
                <span>Bulk SMS</span>
            </a>
        </li>

        <!-- Reports -->
        <li>
            <a href="/admin/reports" class="{{ request()->is('admin/reports') ? 'active-menu' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Reports / History</span>
            </a>
        </li>

        <!-- Profile -->
        <li>
            <a href="/admin/profile" class="{{ request()->is('admin/profile') ? 'active-menu' : '' }}">
                <i class="fas fa-user-cog"></i>
                <span>Settings / Profile</span>
            </a>
        </li>

        <!-- Logout -->
        <li>
            <a href="/admin/logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

</div>