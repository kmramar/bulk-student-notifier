@extends('admin.layouts.master')

@section('title', 'Admin Profile')
@section('page_title', 'Profile Settings')

@section('content')

<style>
    .prof-wrap { padding: 8px 0 32px; }

    /* ── Two Column Grid ── */
    .prof-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 22px;
        align-items: start;
    }
    @media(max-width:900px){ .prof-grid { grid-template-columns: 1fr; } }

    /* ── Card Base ── */
    .prof-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e4e8f4;
        box-shadow: 0 2px 16px rgba(26,31,54,0.07);
        overflow: hidden;
    }
    .prof-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #e4e8f4;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fafbff;
    }
    .prof-card-header h5 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a1f36;
    }
    .prof-card-header .ch-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .ch-blue  { background: #eef1fd; color: #4361ee; }
    .ch-green { background: #e6f9f1; color: #0ead69; }

    /* ── Avatar Card Body ── */
    .prof-avatar-body {
        padding: 32px 24px 24px;
        text-align: center;
    }
    .prof-avatar-ring {
        width: 88px; height: 88px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4361ee, #7b2ff7);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        box-shadow: 0 4px 20px rgba(67,97,238,0.30);
        letter-spacing: -1px;
    }
    .prof-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a1f36;
        margin: 0 0 4px;
    }
    .prof-email {
        font-size: 0.82rem;
        color: #9aa2c0;
        margin: 0 0 14px;
    }
    .prof-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eef1fd;
        color: #4361ee;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 5px 14px;
        border-radius: 20px;
    }
    .prof-role-badge::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #4361ee;
        display: inline-block;
    }

    /* ── Info Rows ── */
    .prof-info-rows {
        padding: 4px 24px 24px;
    }
    .prof-divider {
        height: 1px;
        background: #f0f2f9;
        margin: 0 0 20px;
    }
    .prof-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 0;
        border-bottom: 1px solid #f0f2f9;
        gap: 12px;
    }
    .prof-info-row:last-child { border-bottom: none; }
    .prof-info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #9aa2c0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        flex-shrink: 0;
    }
    .prof-info-val {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1a1f36;
        text-align: right;
    }
    .prof-id-chip {
        background: #f0f2f9;
        color: #5a607f;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 6px;
        font-family: monospace;
    }

    /* ── Password Card ── */
    .prof-pw-body { padding: 26px 28px 28px; }

    .prof-field { margin-bottom: 20px; }
    .prof-field label {
        display: block;
        font-size: 0.78rem;
        font-weight: 600;
        color: #5a607f;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 7px;
    }
    .prof-field .input-wrap {
        position: relative;
    }
    .prof-field .input-wrap .input-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #b0b7d3;
        font-size: 0.85rem;
        pointer-events: none;
    }
    .prof-field input[type="password"] {
        width: 100%;
        height: 44px;
        padding: 0 14px 0 38px;
        border: 1.5px solid #e4e8f4;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #1a1f36;
        background: #f8f9fe;
        outline: none;
        transition: border 0.15s, background 0.15s;
        font-family: inherit;
    }
    .prof-field input[type="password"]:focus {
        border-color: #4361ee;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(67,97,238,0.10);
    }

    /* strength hint */
    .pw-hint {
        font-size: 0.74rem;
        color: #b0b7d3;
        margin-top: 5px;
    }

    .prof-submit-btn {
        width: 100%;
        height: 46px;
        background: #4361ee;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.17s ease;
        box-shadow: 0 2px 10px rgba(67,97,238,0.25);
        margin-top: 6px;
        font-family: inherit;
    }
    .prof-submit-btn:hover {
        background: #3451d1;
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(67,97,238,0.35);
    }
    .prof-submit-btn:active { transform: translateY(0); }

    /* ── Alert ── */
    .sw-alert-s {
        background: #e8f9f2; border: 1px solid #a7f3d0;
        color: #065f46; border-radius: 10px;
        padding: 12px 18px; font-size: 0.85rem;
        font-weight: 500; margin-bottom: 20px;
        display: flex; align-items: center; gap: 9px;
    }
    .sw-alert-e {
        background: #fff1f1; border: 1px solid #fecaca;
        color: #991b1b; border-radius: 10px;
        padding: 12px 18px; font-size: 0.85rem;
        font-weight: 500; margin-bottom: 20px;
        display: flex; align-items: center; gap: 9px;
    }
</style>

<div class="prof-wrap">

    @if(session('success'))
        <div class="sw-alert-s">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="sw-alert-e">❌ {{ session('error') }}</div>
    @endif

    <div class="prof-grid">

        {{-- ── LEFT: Profile Summary Card ── --}}
        <div class="prof-card">
            <div class="prof-card-header">
                <div class="ch-icon ch-blue"><i class="fas fa-user"></i></div>
                <h5>Admin Profile</h5>
            </div>

            <div class="prof-avatar-body">
                <div class="prof-avatar-ring">
                    {{ strtoupper(substr($adminName ?? 'A', 0, 1)) }}
                </div>
                <p class="prof-name">{{ $adminName }}</p>
                <p class="prof-email">{{ $adminEmail }}</p>
                <span class="prof-role-badge">Administrator</span>
            </div>

            <div class="prof-info-rows">
                <div class="prof-divider"></div>

                <div class="prof-info-row">
                    <span class="prof-info-label">Admin ID</span>
                    <span class="prof-id-chip">#{{ $adminId }}</span>
                </div>

                <div class="prof-info-row">
                    <span class="prof-info-label">Name</span>
                    <span class="prof-info-val">{{ $adminName }}</span>
                </div>

                <div class="prof-info-row">
                    <span class="prof-info-label">Email</span>
                    <span class="prof-info-val" style="font-size:0.8rem;">{{ $adminEmail }}</span>
                </div>

                <div class="prof-info-row">
                    <span class="prof-info-label">Role</span>
                    <span class="prof-info-val">Administrator</span>
                </div>
            </div>
        </div>

        {{-- ── RIGHT: Change Password Card ── --}}
        <div class="prof-card">
            <div class="prof-card-header">
                <div class="ch-icon ch-green"><i class="fas fa-key"></i></div>
                <h5>Change Password</h5>
            </div>

            <div class="prof-pw-body">
                <form action="/admin/profile/update-password" method="POST">
                    @csrf

                    <div class="prof-field">
                        <label>Current Password</label>
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password"
                                   name="current_password"
                                   placeholder="Enter current password">
                        </div>
                    </div>

                    <div class="prof-field">
                        <label>New Password</label>
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fas fa-lock-open"></i></span>
                            <input type="password"
                                   name="new_password"
                                   placeholder="Enter new password">
                        </div>
                        <p class="pw-hint">Minimum 8 characters recommended.</p>
                    </div>

                    <div class="prof-field">
                        <label>Confirm Password</label>
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fas fa-check-circle"></i></span>
                            <input type="password"
                                   name="confirm_password"
                                   placeholder="Re-enter new password">
                        </div>
                    </div>

                    <button type="submit" class="prof-submit-btn">
                        <i class="fas fa-save"></i> Update Password
                    </button>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection