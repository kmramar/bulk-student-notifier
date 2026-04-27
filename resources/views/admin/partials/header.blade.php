<!-- 🔽 HEADER / NAVBAR -->
<div class="navbar">

    <!-- RIGHT SIDE PROFILE -->
    <div class="admin-profile-dropdown">
        <button class="profile-btn" onclick="toggleProfileMenu()">
            <img src="https://i.pravatar.cc/150?img=3" alt="Admin">
            <div class="profile-info">
                <strong>{{ session('admin_name') ?? 'Admin' }}</strong>
                <span>{{ session('admin_email') ?? 'admin@example.com' }}</span>
            </div>
            <i class="fas fa-chevron-down"></i>
        </button>

        <!-- DROPDOWN -->
        <div class="profile-menu" id="profileMenu">
            <a href="#">
                <i class="far fa-user"></i>
                My Profile
            </a>

            <a href="#">
                <i class="fas fa-cog"></i>
                Settings
            </a>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>

</div>

<!-- 🔽 CSS -->
<style>
/* Navbar container */
.navbar {
    display: flex;
    justify-content: flex-end; /* 🔥 right alignment */
    align-items: center;
    padding: 15px 25px;
}

/* Dropdown wrapper */
.admin-profile-dropdown {
    position: relative;
}

/* Button */
.profile-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #182666;
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 10px 14px;
    cursor: pointer;
}

/* Image */
.profile-btn img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
}

/* Text */
.profile-info span {
    display: block;
    font-size: 13px;
}

/* Dropdown menu */
.profile-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 70px;
    width: 230px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,.2);
    overflow: hidden;
    z-index: 999;
}

.profile-menu.show {
    display: block;
}

/* Links + buttons */
.profile-menu a,
.profile-menu button {
    width: 100%;
    padding: 15px 20px;
    border: none;
    background: #fff;
    color: #222;
    display: flex;
    gap: 10px;
    align-items: center;
    cursor: pointer;
    text-decoration: none;
}

/* Logout red */
.profile-menu button {
    color: rgb(20, 11, 11);
    border-top: 1px solid #ddd;
}
</style>

<!-- 🔽 JS -->
<script>
function toggleProfileMenu() {
    document.getElementById('profileMenu').classList.toggle('show');
}

document.addEventListener('click', function(e) {
    const dropdown = document.querySelector('.admin-profile-dropdown');
    if (dropdown && !dropdown.contains(e.target)) {
        document.getElementById('profileMenu').classList.remove('show');
    }
});
</script>