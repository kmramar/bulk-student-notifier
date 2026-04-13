<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Mail\StudentNotificationMail;
use Illuminate\Support\Facades\Mail;
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
    

    // Upload CSV file and save only new students
    public function upload(Request $request)
    {
        // Validate uploaded CSV file
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        // Get uploaded file
        $file = $request->file('file');

        // Get file path
        $path = $file->getRealPath();

        // Convert CSV into array
        $rows = array_map('str_getcsv', file($path));

        // Remove header row
        unset($rows[0]);

        // Counters for result message
        $savedCount = 0;
        $duplicateCount = 0;

        // Save CSV rows into database
        foreach ($rows as $row) {
            $name = $row[0] ?? null;
            $email = trim($row[1] ?? '');
            $phone = $row[2] ?? null;
            $course = $row[3] ?? null;
            $message = $row[4] ?? null;

            // Skip row if email is empty
            if (empty($email)) {
                continue;
            }

            // Check duplicate by email
            $studentExists = Student::where('email', $email)->exists();

            if ($studentExists) {
                $duplicateCount++;
            } else {
                Student::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'course' => $course,
                    'message' => $message,
                    'email_status' => 0,
                    'sms_status' => 0,
                    'response' => null,
                ]);

                $savedCount++;
            }
        }

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

    // Handle forgot password form submit and update password in database
    public function forgotPassword(Request $request)
    {
        // Validate form fields
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        // Find admin by email
        $admin = Admin::where('email', $request->email)->first();

        // Check if admin exists
        if (!$admin) {
            return back()->with('error', 'Admin email not found');
        }

        // Update hashed password in database
        $admin->update([
            'password' => bcrypt($request->new_password)
        ]);

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

    // Send real email to all students and update email status
    public function bulkSendEmail()
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
        }

        // Get all students
        $students = Student::all();

        // Counters for final result
        $successCount = 0;
        $failCount = 0;

        // Loop through all students
        foreach ($students as $student) {
            if (empty($student->email)) {
                $student->update([
                    'email_status' => 0
                ]);
                $failCount++;
                continue;
            }

            try {
                Mail::to($student->email)->send(new StudentNotificationMail($student));

                $student->update([
                    'email_status' => 1
                ]);

                $successCount++;
            } catch (\Exception $e) {
                $student->update([
                    'email_status' => 0
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
    public function bulkSendSms()
    {
        // Protect admin page
        if (!session('admin_logged_in')) {
            return redirect('/admin/login')->with('error', 'Please login first');
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

}