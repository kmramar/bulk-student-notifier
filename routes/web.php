<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Models\Student;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home page - upload form and current student table
Route::get('/', [StudentController::class, 'index']);

// Upload CSV file
Route::post('/upload', [StudentController::class, 'upload']);

// Delete student
Route::delete('/student/{id}', [StudentController::class, 'destroy']);

// Update student status from detail page
Route::post('/student/{id}/update-status', [StudentController::class, 'updateStatus']);

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

// Show admin login page
Route::get('/admin/login', [StudentController::class, 'showAdminLogin'])->name('admin.login');

// Check admin login form
Route::post('/admin/login', [StudentController::class, 'adminLogin']);

// Logout admin
Route::get('/admin/logout', [StudentController::class, 'adminLogout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/

// Admin dashboard page
Route::get('/admin/dashboard', [StudentController::class, 'adminDashboard']);

// Admin students list page
Route::get('/admin/students', [StudentController::class, 'adminStudents']);

// Admin single student details page
Route::get('/admin/students/{id}', [StudentController::class, 'adminStudentShow']);

// Admin profile page
Route::get('/admin/profile', [StudentController::class, 'adminProfile']);

// Show forgot password page
Route::get('/admin/forgot-password', [StudentController::class, 'showForgotPassword'])->name('admin.forgot.password');

// Handle forgot password form submit
Route::post('/admin/forgot-password', [StudentController::class, 'forgotPassword']);

// Update admin password from profile page
Route::post('/admin/profile/update-password', [StudentController::class, 'updateAdminPassword']);

// Send real email to a single student
Route::post('/admin/students/{id}/send-email', [StudentController::class, 'sendStudentEmail']);

// Send real SMS to a single student
Route::post('/admin/students/{id}/send-sms', [StudentController::class, 'sendStudentSms']);

// Send real SMS to all students
Route::post('/admin/students/send-sms-all', [StudentController::class, 'bulkSendSms']);

// Send real email to all students
Route::post('/admin/students/send-email-all', [StudentController::class, 'bulkSendEmail']);

Route::get('/admin/students/{id}/edit', [StudentController::class, 'edit']);

Route::post('/admin/students/{id}/update', [StudentController::class, 'update']);

// Admin email page
Route::get('/admin/email', function () {
    $totalStudents = Student::count();
    $emailSent = Student::where('email_status', 1)->count();
    $pendingEmails = Student::where(function ($query) {
        $query->whereNull('email_status')
              ->orWhere('email_status', 0);
    })->count();

    return view('admin.email.index', compact('totalStudents', 'emailSent', 'pendingEmails'));
});

// Admin SMS page
Route::get('/admin/sms', function () {
    $totalStudents = Student::count();
    $smsSent = Student::where('sms_status', 1)->count();
    $pendingSms = Student::where(function ($query) {
        $query->whereNull('sms_status')
              ->orWhere('sms_status', 0);
    })->count();

    return view('admin.sms.index', compact('totalStudents', 'smsSent', 'pendingSms'));
});

// Admin reports page
Route::get('/admin/reports', function () {
    $totalStudents = Student::count();
    $emailSent = Student::where('email_status', 1)->count();
    $smsSent = Student::where('sms_status', 1)->count();
    $noReply = Student::whereNull('response')
        ->orWhere('response', '')
        ->count();

    return view('admin.reports.index', compact('totalStudents', 'emailSent', 'smsSent', 'noReply'));

    
});