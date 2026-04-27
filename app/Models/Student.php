<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'course',
        'message',
        'email_status',
        'sms_status',
        'response',
        'notification_status',
        'notification_error',
         'notification_sent_at',
    ];
}