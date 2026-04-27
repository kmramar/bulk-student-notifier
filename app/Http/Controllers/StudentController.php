<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Admin;
use App\Models\NotificationTemplate;
use Illuminate\Support\Facades\Hash;
use App\Mail\StudentNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class StudentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Public Pages
    |--------------------------------------------------------------------------
    */

    // Show upload form and public student list
    public function index()
    {
        $students = Student::latest()->get();
        return view('index', compact('students'));
    }

    //admin profile page
    
    

    // Upload CSV file
// If uploaded from admin mapping page => go to mapping
// If uploaded from simple upload page => save directly
public function upload(Request $request)
{
    if (!$request->hasFile('csv')) {
        return back()->with('error', 'CSV file not received. Check input name="csv" and enctype.');
    }

    $request->validate([
        'csv' => 'required|file|mimes:csv,txt|max:2048',
        'upload_type' => 'nullable|string',
    ]);

    $file = $request->file('csv');

    /*
    |----------------------------------
    |--------------------------------------------------------------------------
    | Simple Upload Direct Save
    |--------------------------------------------------------------------------
    */
    $rows = array_map('str_getcsv', file($file->getRealPath()));

    // Remove header row
    array_shift($rows);

    $savedCount = 0;
    $duplicateCount = 0;
    $skippedCount = 0;

    foreach ($rows as $row) {
        $email = trim($row[1] ?? '');

        if (empty($email)) {
            $skippedCount++;
            continue;
        }

        if (Student::where('email', $email)->exists()) {
            $duplicateCount++;
            continue;
        }

        Student::create([
            'name' => trim($row[0] ?? ''),
            'email' => $email,
            'phone' => trim($row[2] ?? ''),
            'course' => trim($row[3] ?? ''),
            'message' => trim($row[4] ?? ''),
            'email_status' => 0,
            'sms_status' => 0,
            'response' => null,
        ]);

        $savedCount++;
    }

    return redirect('/')
        ->with(
            'success',
            "Upload completed. New students saved: {$savedCount}, Duplicates skipped: {$duplicateCount}, Invalid rows skipped: {$skippedCount}"
        );
}
    // Process CSV with column mapping
    public function processCsvMapping(Request $request)
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        // Get mapping from request
        $mapping = $request->input('mapping', []);
        
        // Get temp file path from session
        $tempPath = session('csv_temp_file');
        
        if (!$tempPath || !file_exists(Storage::path($tempPath))) {
            return redirect('/')->with('error', 'CSV file not found. Please upload again.');
        }

        // Read CSV file
        $rows = array_map('str_getcsv', file(Storage::path($tempPath)));

        // First row contains headers (already processed in upload)
        unset($rows[0]);

        // Counters for result message
        $savedCount = 0;
        $duplicateCount = 0;

        // Available columns in students table (no 'role' column exists)
        $availableColumns = ['name', 'email', 'phone', 'course', 'message'];

        // Save CSV rows into database using mapping
        foreach ($rows as $row) {
            $data = [];

            // Map CSV columns to database fields based on mapping
            foreach ($mapping as $csvIndex => $dbField) {
                if (empty($dbField) || !in_array($dbField, $availableColumns)) {
                    continue; // Skip unmapped or invalid fields
                }

                $csvIndex = (int) $csvIndex;
                $data[$dbField] = $row[$csvIndex] ?? null;
            }

            // Skip row if email is empty
            $email = trim($data['email'] ?? '');
            if (empty($email)) {
                continue;
            }

            // Check duplicate by email
            $studentExists = Student::where('email', $email)->exists();

            if ($studentExists) {
                $duplicateCount++;
            } else {
                Student::create([
                    'name' => $data['name'] ?? null,
                    'email' => $email,
                    'phone' => $data['phone'] ?? null,
                    'course' => $data['course'] ?? null,
                    'message' => $data['message'] ?? null,
                    'email_status' => 0,
                    'sms_status' => 0,
                    'response' => null,
                ]);

                $savedCount++;
            }
        }

        // Clean up temp file and session
        Storage::delete($tempPath);
        session()->forget(['csv_temp_file', 'csv_headers']);

        return redirect('/')->with(
            'success',
            'Upload completed. New students saved: ' . $savedCount . ', Duplicates skipped: ' . $duplicateCount
        );
    }

    // Delete student record
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect('/')->with('success', 'Student deleted successfully');
    }

    // Update student status and response
    public function updateStatus(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // Validate form input
        $request->validate([
            'email_status' => 'required|in:0,1',
            'sms_status' => 'required|in:0,1',
            'response' => 'nullable|string|max:255',
        ]);

        // Update values in database
        $student->update([
            'email_status' => $request->email_status,
            'sms_status' => $request->sms_status,
            'response' => $request->response,
        ]);

        return redirect('/admin/students/' . $student->id)->with('success', 'Student status updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Authentication
    |--------------------------------------------------------------------------
    */

    // Show admin login page
    public function showAdminLogin()
    {
        return view('admin.auth.login');
    }

    // Check admin login credentials from database
    public function adminLogin(Request $request)
    {
        // Validate login form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Find admin by email
        $admin = Admin::where('email', $request->email)->first();

        // Check if admin exists and password is correct
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Save real admin data in session
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_email' => $admin->email
            ]);

            return redirect('/admin/dashboard')->with('success', 'Login successful');
        }

        // Wrong credentials
        return back()->with('error', 'Invalid email or password');
    }

    // Logout admin
    public function adminLogout()
    {
        session()->forget([
            'admin_logged_in',
            'admin_id',
            'admin_name',
            'admin_email'
        ]);

        return redirect('/admin/login')->with('success', 'Logout successful');
    }

    // Show forgot password page
    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    // Handle forgot password: send OTP first, then verify to reset password
    public function forgotPassword(Request $request)
    {
        // Validate form fields
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
            'otp' => 'nullable|numeric|digits:6'
        ]);

        // Find admin by email
        $admin = Admin::where('email', $request->email)->first();

        // Check if admin exists
        if (!$admin) {
            return back()->with('error', 'Admin email not found');
        }

        // If OTP not submitted, generate and send OTP
        if (!$request->filled('otp')) {
            $otp = rand(100000, 999999);
            
            // Store OTP in session (valid 10 minutes)
            session([
                'otp' => $otp,
                'otp_email' => $admin->email,
                'otp_expiry' => now()->addMinutes(10)
            ]);

            // Send OTP email immediately (no queue)
            try {
                Mail::send([], [], function ($message) use ($admin, $otp) {
                    $message->to($admin->email)
                            ->subject('Password Reset OTP')
                            ->setBody("Your OTP for password reset is: $otp. Valid for 10 minutes.");
                });
                Log::info("OTP sent to {$admin->email}: $otp");
            } catch (\Exception $e) {
                Log::error("OTP send failed to {$admin->email}: " . $e->getMessage());
                return back()->with('error', 'Failed to send OTP. Please try again.');
            }

            return back()->with('success', 'OTP sent to your email. Enter it below to reset password.');
        }

        // Verify submitted OTP
        $sessionOtp = session('otp');
        $sessionEmail = session('otp_email');
        $otpExpiry = session('otp_expiry');

        if (!$sessionOtp || $sessionEmail !== $admin->email || now()->gt($otpExpiry)) {
            return back()->with('error', 'Invalid or expired OTP. Request a new one.');
        }

        if ($request->otp != $sessionOtp) {
            return back()->with('error', 'Incorrect OTP.');
        }

        // OTP verified: update password
        $admin->update([
            'password' => bcrypt($request->new_password)
        ]);

        // Clear OTP session data
        session()->forget(['otp', 'otp_email', 'otp_expiry']);

        return redirect('/admin/login')->with('success', 'Password updated successfully. Please login with your new password.');
    }

    // Update admin password from profile page and save into database
    public function updateAdminPassword(Request $request)
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        // Validate form fields
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        // Find current logged-in admin
        $admin = Admin::find(session('admin_id'));

        // Check if admin exists
        if (!$admin) {
            return back()->with('error', 'Admin not found');
        }

        // Check current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        // Update hashed password in database
        $admin->update([
            'password' => bcrypt($request->new_password)
        ]);

        return redirect('/admin/profile')->with('success', 'Password updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Pages
    |--------------------------------------------------------------------------
    */

    // Show admin dashboard with summary cards
    public function adminDashboard()
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        $totalStudents = Student::count();
        $emailSent = Student::where('email_status', 1)->count();
        $smsSent = Student::where('sms_status', 1)->count();
        $noReply = Student::whereNull('response')->count();

        return view('admin.dashboard.index', compact(
            'totalStudents',
            'emailSent',
            'smsSent',
            'noReply'
        ));
    }

    // Show admin students list page with search feature and top summary cards
    public function adminStudents(Request $request)
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        // Get search text from URL
        $search = $request->search;

        // Start student query
        $studentsQuery = Student::query();

        // Apply search on name, email and course
        if (!empty($search)) {
            $studentsQuery->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('course', 'like', '%' . $search . '%');
        }

        // Final student list
        $students = $studentsQuery->latest()->get();

        // Top summary cards data
        $totalStudents = Student::count();
        $emailSent = Student::where('email_status', 1)->count();
        $smsSent = Student::where('sms_status', 1)->count();
        $noReply = Student::whereNull('response')->orWhere('response', '')->count();

        return view('admin.students.index', compact(
            'students',
            'search',
            'totalStudents',
            'emailSent',
            'smsSent',
            'noReply'
        ));
    }

    // Show admin single student details page
    public function adminStudentShow($id)
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        $student = Student::findOrFail($id);
        return view('admin.students.show', compact('student'));
    }

    // Show admin profile page with real session data
    public function adminProfile()
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        // Get admin session data
        $adminId = session('admin_id');
        $adminName = session('admin_name');
        $adminEmail = session('admin_email');

        return view('admin.profile.index', compact('adminId', 'adminName', 'adminEmail'));
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Replace placeholders in content with student data.
     * Supported placeholders: {name}, {email}, {phone}, {course}, {roll_number}, {message}
     * If a value is missing, replaces with empty string.
     *
     * @param string $content The content with placeholders
     * @param Student $student The student object
     * @return string Content with placeholders replaced
     */
    private function replacePlaceholders($content, $student)
    {
        if (empty($content)) {
            return $content;
        }

        $placeholders = [
            '{name}' => $student->name ?? '',
            '{email}' => $student->email ?? '',
            '{phone}' => $student->phone ?? '',
            '{course}' => $student->course ?? '',
            '{roll_number}' => $student->roll_number ?? '',
            '{message}' => $student->message ?? '',
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $content);
    }

    /*
    |--------------------------------------------------------------------------
    | Email and SMS Features
    |--------------------------------------------------------------------------
    */

    // Send real email to a single student.
    // If email fails, automatically try SMS fallback.
    public function sendStudentEmail($id)
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        // Find student by ID
        $student = Student::findOrFail($id);

        // Check if student email exists
        if (empty($student->email)) {
            return back()->with('error', 'Student email not found');
        }

        try {
            // Try sending real email first
            Mail::to($student->email)->send(new StudentNotificationMail($student));

            // Email success
            $student->update([
                'email_status' => 1
            ]);

            return back()->with('success', 'Email sent successfully');
        } catch (\Exception $emailError) {
            // Email failed
            $student->update([
                'email_status' => 0
            ]);

            // Try SMS fallback
            try {
                if (empty($student->phone)) {
                    return back()->with('error', 'Email failed and student phone number not found for SMS fallback.');
                }

                $phone = $student->phone;
                if (strpos($phone, '+') !== 0) {
                    $phone = '+91' . ltrim($phone, '0');
                }

                $twilio = new Client(
                    env('TWILIO_SID'),
                    env('TWILIO_AUTH_TOKEN')
                );

                $twilio->messages->create(
                    $phone,
                    [
                        'from' => env('TWILIO_PHONE_NUMBER'),
                        'body' => 'Hello ' . $student->name . ', Course: ' . $student->course . ', Message: ' . $student->message
                    ]
                );

                $student->update([
                    'sms_status' => 1
                ]);

                return back()->with('success', 'Email failed, but SMS sent successfully as fallback.');
            } catch (\Exception $smsError) {
                $student->update([
                    'sms_status' => 0
                ]);

                return back()->with(
                    'error',
                    'Email failed: ' . $emailError->getMessage() . ' | SMS fallback failed: ' . $smsError->getMessage()
                );
            }
        }
    }

    // Bulk send email to multiple students
    public function bulkSendEmail(Request $request)
    {
        $request->validate([
            'template_id' => 'nullable|exists:notification_templates,id',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
    ]);

    $successCount = 0;
    $failCount = 0;

    $template = null;

    if ($request->filled('template_id')) {
        $template = NotificationTemplate::find($request->template_id);
    }

    $students = Student::whereNotNull('email')
        ->where('email', '!=', '')
        ->get();

    foreach ($students as $student) {
        try {
            if ($template) {
                $subject = $this->replacePlaceholders($template->subject, $student);
                $body = $this->replacePlaceholders($template->message, $student);
            } else {
                $subject = $request->subject ?? 'Student Notification';
                $body = $request->message ?? 'Hello ' . $student->name;
            }

            Mail::to($student->email)->send(
                new StudentNotificationMail($student, $subject, $body)
            );

            $student->update([
                'email_status' => 1,
                'notification_status' => 'sent',
                'notification_error' => null,
                'notification_sent_at' => now(),
            ]);

            $successCount++;
        } catch (\Exception $e) {
            $student->update([
                'email_status' => 0,
                'notification_status' => 'failed',
                'notification_error' => $e->getMessage(),
                'notification_sent_at' => null,
            ]);

            $failCount++;
        }
    }

    return redirect('/admin/students')->with(
        'success',
        'Bulk email completed. Sent: ' . $successCount . ', Failed: ' . $failCount
    );
}

    // Send real SMS to a single student
    public function sendStudentSms($id)
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        // Find student by ID
        $student = Student::findOrFail($id);

        // Check if student phone exists
        if (empty($student->phone)) {
            return back()->with('error', 'Student phone number not found');
        }

        try {
            // Convert Indian phone to international format if needed
            $phone = $student->phone;
            if (strpos($phone, '+') !== 0) {
                $phone = '+91' . ltrim($phone, '0');
            }

            // Create Twilio client
            $twilio = new Client(
                env('TWILIO_SID'),
                env('TWILIO_AUTH_TOKEN')
            );

            // Send SMS
            $twilio->messages->create(
                $phone,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => 'Hello ' . $student->name . ', Course: ' . $student->course . ', Message: ' . $student->message
                ]
            );

            // SMS success
            $student->update([
                'sms_status' => 1
            ]);

            return back()->with('success', 'SMS sent successfully');
        } catch (\Exception $smsError) {
            $student->update([
                'sms_status' => 0
            ]);

            return back()->with('error', 'SMS failed: ' . $smsError->getMessage());
        }
    }

    // Send real SMS to all students and update sms status
    // Supports template selection: uses template message if template_id provided
    public function bulkSendSms(Request $request)
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        // Get template if selected
        $template = null;
        if ($request->filled('template_id')) {
            $template = NotificationTemplate::where('id', $request->template_id)
                ->where('type', 'sms')
                ->first();
        }

        // Get all students
        $students = Student::all();

        // Create Twilio client once
        $twilio = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );

        // Counters for final result
        $successCount = 0;
        $failCount = 0;

        // Loop through all students
        foreach ($students as $student) {
            if (empty($student->phone)) {
                $student->update([
                    'sms_status' => 0
                ]);
                $failCount++;
                continue;
            }

            $phone = $student->phone;
            if (strpos($phone, '+') !== 0) {
                $phone = '+91' . ltrim($phone, '0');
            }

            try {
                // Use template if available, otherwise fallback to default message
                if ($template) {
                    // Replace placeholders and ensure plain text for SMS
                    $smsBody = strip_tags($this->replacePlaceholders($template->message, $student));
                } else {
                    // Fallback to old behavior
                    $smsBody = 'Hello ' . $student->name . ', Course: ' . $student->course . ', Message: ' . ($student->message ?? '');
                }

                $twilio->messages->create(
                    $phone,
                    [
                        'from' => env('TWILIO_PHONE_NUMBER'),
                        'body' => $smsBody
                    ]
                );

                $student->update([
                    'sms_status' => 1
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $student->update([
                    'sms_status' => 0
                ]);

                $failCount++;
            }
        }

        return redirect('/admin/students')->with(
            'success',
            'Bulk SMS completed. Sent: ' . $successCount . ', Failed: ' . $failCount
        );
        
    }
    public function edit($id)
{
    $student = Student::findOrFail($id);
    return view('admin.students.edit', compact('student'));
}

public function update(Request $request, $id)
{
    $student = Student::findOrFail($id);

    $student->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'course' => $request->course,
    ]);

    return redirect('/admin/students')->with('success', 'Student updated successfully');
}
public function failedNotifications()
{
    $students = Student::where('email_status', 0)
        ->orWhere('sms_status', 0)
        ->orWhereNotNull('notification_error')
        ->latest()
        ->get();

    return view('admin.failed-notifications.index', compact('students'));
}

}