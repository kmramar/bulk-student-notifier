<?php

use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\NotificationTemplateController;
use App\Http\Controllers\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [StudentController::class, 'index'])->name('home');
Route::post('/upload', [StudentController::class, 'upload'])->name('csv.upload');

Route::delete('/student/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
Route::post('/student/{id}/update-status', [StudentController::class, 'updateStatus'])->name('student.updateStatus');


/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [StudentController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [StudentController::class, 'adminLogin'])->name('admin.login.post');
Route::get('/admin/logout', [StudentController::class, 'adminLogout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [StudentController::class, 'adminDashboard'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Students
    |--------------------------------------------------------------------------
    */
    Route::get('/students', [StudentController::class, 'adminStudents'])->name('students.index');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::post('/students/{id}/update', [StudentController::class, 'update'])->name('students.update');
    Route::get('/students/{id}', [StudentController::class, 'adminStudentShow'])->name('students.show');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [StudentController::class, 'adminProfile'])->name('profile');

    /*
    |--------------------------------------------------------------------------
    | CSV Upload (Simple)
    |--------------------------------------------------------------------------
    */
    Route::get('/upload', function () {
        return view('admin.csv.upload');
    })->name('upload');

    /*
    |--------------------------------------------------------------------------
    | Password / OTP System
    |--------------------------------------------------------------------------
    */

    // Step 1: Forgot page
    Route::get('/forgot-password', [StudentController::class, 'showForgotPassword'])
        ->name('forgot.password');

    // Step 2: Send OTP
    Route::post('/send-otp', [AuthController::class, 'sendOtp'])
        ->name('send.otp');

    // Step 3: Verify OTP
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])
        ->name('verify.otp');

    // Step 4: Reset password
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('reset.password');

    /*
    |--------------------------------------------------------------------------
    | Email / SMS
    |--------------------------------------------------------------------------
    */
    Route::post('/students/{id}/send-email', [StudentController::class, 'sendStudentEmail'])->name('students.sendEmail');
    Route::post('/students/{id}/send-sms', [StudentController::class, 'sendStudentSms'])->name('students.sendSms');
    Route::post('/students/send-sms-all', [StudentController::class, 'bulkSendSms'])->name('students.bulkSms');
    Route::post('/students/send-email-all', [StudentController::class, 'bulkSendEmail'])->name('students.bulkEmail');

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */
    Route::get('/email', function () {
        $totalStudents = Student::count();
        $emailSent = Student::where('email_status', 1)->count();

        $pendingEmails = Student::where(function ($query) {
            $query->whereNull('email_status')
                ->orWhere('email_status', 0);
        })->count();


        $templates = \App\Models\NotificationTemplate::where('type', 'email')->get();

        return view('admin.email.index', compact(
            'totalStudents',
            'emailSent',
            'pendingEmails',
            'templates'
        ));
    })->name('email');

    Route::get('/sms', function () {
        $totalStudents = Student::count();
        $smsSent = Student::where('sms_status', 1)->count();

        $pendingSms = Student::where(function ($query) {
            $query->whereNull('sms_status')
                ->orWhere('sms_status', 0);
        })->count();

        $templates = \App\Models\NotificationTemplate::where('type', 'sms')->get();

        return view('admin.sms.index', compact(
            'totalStudents',
            'smsSent',
            'pendingSms',
            'templates'
        ));
    })->name('sms');

    Route::get('/reports', function () {
        $totalStudents = Student::count();
        $emailSent = Student::where('email_status', 1)->count();
        $smsSent = Student::where('sms_status', 1)->count();

        $noReply = Student::whereNull('response')
            ->orWhere('response', '')
            ->count();

        return view('admin.reports.index', compact(
            'totalStudents',
            'emailSent',
            'smsSent',
            'noReply'
        ));
    })->name('reports');

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    */
    Route::resource('templates', NotificationTemplateController::class);

    Route::post('/templates/{id}/send-test', [NotificationTemplateController::class, 'sendTest'])
        ->name('templates.sendTest');

    /*
    |--------------------------------------------------------------------------
    | Failed Notifications
    |--------------------------------------------------------------------------
    */
    Route::get('/failed-notifications', [StudentController::class, 'failedNotifications'])
        ->name('failed.notifications');


        Route::get('/admin/profile', function () {
    return view('admin.profile.index');
})->name('admin.profile');

Route::get('/admin/settings', function () {
    return view('admin.settings.index');
})->name('admin.settings');

Route::get('/admin/logout', [StudentController::class, 'adminLogout'])
    ->name('admin.logout');
    
});