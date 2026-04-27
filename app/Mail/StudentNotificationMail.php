<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/*
|--------------------------------------------------------------------------
| Student Notification Mail
|--------------------------------------------------------------------------
| This mail class sends notification email to a single student.
| Supports custom subject and body from templates.
*/

class StudentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    // Store student data
    public $student;
    
    // Custom subject and body from template
    public $customSubject;
    public $customBody;

    /**
     * Create a new message instance.
     * 
     * @param Student $student
     * @param string|null $customSubject Custom email subject from template
     * @param string|null $customBody Custom email body from template
     */
    public function __construct(Student $student, $customSubject = null, $customBody = null)
    {
        $this->student = $student;
        $this->customSubject = $customSubject;
        $this->customBody = $customBody;
    }

    /**
     * Build the message.
     * Uses template subject/body if provided, otherwise falls back to defaults.
     */
    public function build()
    {
        $subject = $this->customSubject ?? 'Notification for ' . $this->student->name;
        $view = $this->customBody 
            ? $this->view('admin.emails.student-notification-template')->with('customBody', $this->customBody)
            : $this->view('admin.emails.student-notification');
        
        return $view->subject($subject);
    }
    
}
