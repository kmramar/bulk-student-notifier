<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Admin Model
|--------------------------------------------------------------------------
| This model is used for admin login and profile data.
*/

class Admin extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}