<!-- Admin Sidebar -->
<div class="admin-sidebar">
    <div class="logo">
        <i class="fas fa-bell"></i>
        <span>Bulk Notifier</span>
    </div>

    <ul class="sidebar-menu">

        {{-- Dashboard --}}
        <li>
            <a href="{{ route('admin.dashboard') }}" 
               class="{{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Notifications --}}
        <li class="menu-heading">Notifications</li>

        <li>
            <a href="{{ route('admin.email') }}" 
               class="{{ request()->is('admin/email') || request()->is('admin/sms') ? 'active-menu' : '' }}">
                <i class="fas fa-paper-plane"></i>
                <span class="fw-bold">Send Notification</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.reports') }}" 
               class="{{ request()->routeIs('admin.reports') ? 'active-menu' : '' }}">
                <i class="fas fa-history"></i>
                <span>History</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.failed.notifications') }}" 
               class="{{ request()->routeIs('admin.failed.notifications') ? 'active-menu' : '' }}">
                <i class="fas fa-exclamation-circle"></i>
                <span>Failed Notifications</span>
            </a>
        </li>

        {{-- Templates --}}
        <li class="menu-heading">Templates</li>

        <li>
            <a href="{{ route('admin.templates.index') }}" 
               class="{{ request()->routeIs('admin.templates.*') ? 'active-menu' : '' }}">
                <i class="fas fa-layer-group"></i>
                <span>All Templates</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.templates.create') }}" 
               class="{{ request()->routeIs('admin.templates.create') ? 'active-menu' : '' }}">
                <i class="fas fa-plus-circle"></i>
                <span>Add Template</span>
            </a>
        </li>

        {{-- Audience --}}
        <li class="menu-heading">Audience</li>

        <li>
            <a href="{{ route('admin.students.index') }}" 
               class="{{ request()->is('admin/students*') ? 'active-menu' : '' }}">
                <i class="fas fa-users"></i>
                <span>Students</span>
            </a>
        </li>

        {{-- CSV Upload --}}
        <li class="menu-heading">Excel / CSV</li>

        <li>
            <a href="{{ route('home') }}" 
               class="{{ request()->routeIs('home') ? 'active-menu' : '' }}">
                <i class="fas fa-file-upload"></i>
                <span>Upload CSV / Excel</span>
            </a>
        </li>

        {{-- Settings --}}
        <li class="menu-heading">Settings</li>

        <li>
            <a href="{{ route('admin.profile') }}" 
               class="{{ request()->routeIs('admin.profile') ? 'active-menu' : '' }}">
                <i class="fas fa-user-cog"></i>
                <span>Profile</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.logout') }}">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>
</div>