<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $otp = rand(100000, 999999);

        session([
            'otp' => $otp,
            'email' => $request->email
        ]);

        Mail::raw("Your OTP is: $otp", function ($msg) use ($request) {
            $msg->to($request->email)->subject('OTP Verification');
        });

        return view('admin.auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        if ($request->otp == session('otp')) {
            return view('admin.auth.reset-password');
        }

        return back()->with('error', 'Invalid OTP');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        DB::table('admins')
            ->where('email', session('email'))
            ->update([
                'password' => bcrypt($request->password)
            ]);

        session()->forget(['otp', 'email']);

        return redirect('/admin/login')->with('success', 'Password updated successfully');
    }
}