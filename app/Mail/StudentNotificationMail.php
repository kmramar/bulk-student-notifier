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
*/

class StudentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    // Store student data
    public $student;

    /**
     * Create a new message instance.
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Notification for '.$this->student->name)
            ->view('admin.emails.student-notification');
    }
    
}
