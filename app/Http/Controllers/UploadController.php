<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function upload(Request $request)
    {
     $request->validate([
    'email' => 'required|email|unique:students,email',
]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $rows = array_map('str_getcsv', file($path));

        $header = $rows[0];
        unset($rows[0]);

        foreach ($rows as $row) {
            Student::create([
                'name' => $row[0] ?? null,
                'email' => $row[1] ?? null,
                'phone' => $row[2] ?? null,
                'course' => $row[3] ?? null,
                'message' => $row[4] ?? null,
                'email_status' => 0,
                'sms_status' => 0,
                'response' => null,
            ]);
        }

        return view('index', compact('rows', 'header'));
    }
}

