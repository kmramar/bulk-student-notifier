@extends('admin.layouts.master')

@section('title', 'Students List')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

    .sw-wrap * { box-sizing: border-box; font-family: 'DM Sans', sans-serif; }

    .sw-wrap {
        padding: 24px;
        background: #f0f2f9;
        min-height: 100vh;
    }

    /* ── Stat Grid ── */
    .sw-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .sw-stat-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e4e8f4;
        padding: 20px 22px;
        box-shadow: 0 2px 12px rgba(26,31,54,0.07);
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .sw-stat-icon {
        width: 46px; height: 46px;
        border-radius: 10px;
        display: flex; align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .sw-ic-dark   { background: #eef0f6; }
    .sw-ic-blue   { background: #eef1fd; }
    .sw-ic-green  { background: #e6f9f1; }
    .sw-ic-yellow { background: #fff8e6; }

    .sw-stat-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #9aa2c0;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin: 0 0 4px;
    }
    .sw-stat-val {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1a1f36;
        margin: 0;
        line-height: 1;
    }

    /* ── Alert ── */
    .sw-alert {
        background: #e8f9f2;
        border: 1px solid #a7f3d0;
        color: #065f46;
        border-radius: 10px;
        padding: 12px 18px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    /* ── Table Card ── */
    .sw-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e4e8f4;
        box-shadow: 0 2px 16px rgba(26,31,54,0.08);
        overflow: hidden;
    }

    /* ── Toolbar ── */
    .sw-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px 22px;
        border-bottom: 1px solid #e4e8f4;
    }
    .sw-search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .sw-search-form input[type="text"] {
        height: 40px;
        padding: 0 14px;
        border: 1.5px solid #e4e8f4;
        border-radius: 8px;
        font-size: 0.84rem;
        color: #1a1f36;
        outline: none;
        width: 240px;
        background: #f8f9fe;
        transition: border 0.15s;
        font-family: 'DM Sans', sans-serif;
    }
    .sw-search-form input[type="text"]:focus {
        border-color: #4361ee;
        background: #fff;
    }
    .sw-bulk-btns {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* ── Buttons ── */
    .sw-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 40px;
        padding: 0 18px;
        border-radius: 8px;
        border: none;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none !important;
        white-space: nowrap;
        transition: all 0.17s ease;
        box-shadow: 0 1px 6px rgba(0,0,0,0.09);
        line-height: 1;
    }
    .sw-btn:hover { transform: translateY(-1px); }
    .sw-btn:active { transform: translateY(0); }

    .sw-btn-dark  { background: #1a1f36; color: #fff !important; }
    .sw-btn-dark:hover  { background: #0d1124; color: #fff !important; box-shadow: 0 4px 12px rgba(26,31,54,0.25); }

    .sw-btn-blue  { background: #4361ee; color: #fff !important; }
    .sw-btn-blue:hover  { background: #3451d1; color: #fff !important; box-shadow: 0 4px 12px rgba(67,97,238,0.32); }

    .sw-btn-green { background: #0ead69; color: #fff !important; }
    .sw-btn-green:hover { background: #0b9659; color: #fff !important; box-shadow: 0 4px 12px rgba(14,173,105,0.28); }

    .sw-btn-ghost {
        background: #f0f2f9;
        color: #5a607f !important;
        border: 1.5px solid #e4e8f4;
        box-shadow: none;
    }
    .sw-btn-ghost:hover { background: #e4e8f4; color: #1a1f36 !important; transform: none; }

    /* ── Table ── */
    .sw-table { width: 100%; border-collapse: collapse; }

    .sw-table thead tr { background: #1a1f36; }
    .sw-table thead th {
        color: rgba(255,255,255,0.82);
        font-size: 0.71rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        padding: 14px 16px;
        border: none;
        white-space: nowrap;
    }
    .sw-table thead th:first-child { padding-left: 24px; }
    .sw-table thead th:last-child  { padding-right: 24px; text-align: center; }

    .sw-table tbody tr {
        border-bottom: 1px solid #edf0f9;
        transition: background 0.1s;
    }
    .sw-table tbody tr:last-child { border-bottom: none; }
    .sw-table tbody tr:hover { background: #f4f6ff; }

    .sw-table tbody td {
        padding: 13px 16px;
        font-size: 0.86rem;
        color: #1a1f36;
        vertical-align: middle;
        border: none;
    }
    .sw-table tbody td:first-child { padding-left: 24px; }
    .sw-table tbody td:last-child  { padding-right: 24px; text-align: center; }

    .sw-id   { font-size: 0.78rem; color: #9aa2c0; font-weight: 500; }
    .sw-name { font-weight: 600; }
    .sw-mono { font-size: 0.81rem; color: #5a607f; }

    /* ── Badges ── */
    .sw-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 0.71rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .sw-badge::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        display: inline-block;
    }
    .sw-sent    { background: #d4f7e7; color: #0a7a44; }
    .sw-sent::before    { background: #0ead69; }
    .sw-pending { background: #fff4d6; color: #92640a; }
    .sw-pending::before { background: #f59e0b; }

    /* ── Row Action Buttons ── */
    .sw-action-group { display: inline-flex; align-items: center; gap: 7px; }
    .sw-row-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        border-radius: 7px;
        border: none;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.77rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none !important;
        transition: all 0.15s;
        white-space: nowrap;
    }
    .sw-view-btn   { background: #eef1fd; color: #4361ee !important; }
    .sw-view-btn:hover   { background: #4361ee; color: #fff !important; }
    .sw-delete-btn { background: #fff0f0; color: #dc2626 !important; }
    .sw-delete-btn:hover { background: #dc2626; color: #fff !important; }

    .sw-inline-form { display: inline; }

    /* ── Empty State ── */
    .sw-empty {
        text-align: center;
        padding: 70px 30px;
    }
    .sw-empty-icon { font-size: 3rem; opacity: .35; display: block; margin-bottom: 14px; }
    .sw-empty h3   { font-size: 1rem; font-weight: 700; color: #1a1f36; margin-bottom: 6px; }
    .sw-empty p    { font-size: 0.85rem; color: #9aa2c0; margin: 0; }

    @media (max-width: 900px) {
        .sw-stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .sw-stat-grid { grid-template-columns: 1fr 1fr; }
        .sw-toolbar { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="sw-wrap">

    {{-- ── Stat Cards ── --}}
    <div class="sw-stat-grid">
        <div class="sw-stat-card">
            <div class="sw-stat-icon sw-ic-dark">👥</div>
            <div>
                <p class="sw-stat-label">Total Students</p>
                <p class="sw-stat-val">{{ $totalStudents }}</p>
            </div>
        </div>
        <div class="sw-stat-card">
            <div class="sw-stat-icon sw-ic-blue">✉️</div>
            <div>
                <p class="sw-stat-label">Email Sent</p>
                <p class="sw-stat-val">{{ $emailSent }}</p>
            </div>
        </div>
        <div class="sw-stat-card">
            <div class="sw-stat-icon sw-ic-green">💬</div>
            <div>
                <p class="sw-stat-label">SMS Sent</p>
                <p class="sw-stat-val">{{ $smsSent }}</p>
            </div>
        </div>
        <div class="sw-stat-card">
            <div class="sw-stat-icon sw-ic-yellow">🔕</div>
            <div>
                <p class="sw-stat-label">No Reply</p>
                <p class="sw-stat-val">{{ $noReply }}</p>
            </div>
        </div>
    </div>

    {{-- ── Alert ── --}}
    @if(session('success'))
        <div class="sw-alert">✅ {{ session('success') }}</div>
    @endif

    {{-- ── Main Card ── --}}
    <div class="sw-card">

        <div class="sw-toolbar">
            <form action="/admin/students" method="GET" class="sw-search-form">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="🔍  Search name, email or course">
                <button type="submit" class="sw-btn sw-btn-dark">Search</button>
                <a href="/admin/students" class="sw-btn sw-btn-ghost">Reset</a>
            </form>

            <div class="sw-bulk-btns">
                <form action="/admin/students/send-email-all" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="sw-btn sw-btn-blue"
                            onclick="return confirm('Are you sure you want to send email to all students?')">
                        ✉️ Send Email to All
                    </button>
                </form>
                <form action="/admin/students/send-sms-all" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="sw-btn sw-btn-green"
                            onclick="return confirm('Are you sure you want to send SMS to all students?')">
                        💬 Send SMS to All
                    </button>
                </form>
            </div>
        </div>

        @if(isset($students) && $students->count() > 0)
        <div style="overflow-x:auto;">
            <table class="sw-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Course</th>
                        <th>Email Status</th>
                        <th>SMS Status</th>
                        <th>Response</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td><span class="sw-id">{{ $student->id }}</span></td>
                        <td><span class="sw-name">{{ $student->name }}</span></td>
                        <td><span class="sw-mono">{{ $student->email }}</span></td>
                        <td><span class="sw-mono">{{ $student->phone }}</span></td>
                        <td>{{ $student->course }}</td>

                        <td>
                            @if($student->email_status == 1)
                                <span class="sw-badge sw-sent">Sent</span>
                            @else
                                <span class="sw-badge sw-pending">Pending</span>
                            @endif
                        </td>

                        <td>
                            @if($student->sms_status == 1)
                                <span class="sw-badge sw-sent">Sent</span>
                            @else
                                <span class="sw-badge sw-pending">Pending</span>
                            @endif
                        </td>

                        <td>
                            @if($student->response)
                                {{ $student->response }}
                            @else
                                <span style="color:#9aa2c0;font-size:0.8rem;">No Reply</span>
                            @endif
                        </td>

                        <td>
                            <div class="sw-action-group">
                                <a href="/admin/students/{{ $student->id }}"
                                   class="sw-row-btn sw-view-btn">👁 View</a>

                                <form action="/student/{{ $student->id }}" method="POST"
                                      class="sw-inline-form"
                                      onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="sw-row-btn sw-delete-btn">
                                        🗑 Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else
        <div class="sw-empty">
            <span class="sw-empty-icon">📂</span>
            <h3>No students found.</h3>
            <p>Please upload a CSV file to get started.</p>
        </div>
        @endif

    </div>

</div>

@endsection
