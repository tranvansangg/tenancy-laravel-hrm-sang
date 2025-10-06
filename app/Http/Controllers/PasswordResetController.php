<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\Account;

class PasswordResetController extends Controller
{
    // Form nhập email quên mật khẩu
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Xử lý gửi link reset
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = Account::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống']);
        }

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = url("/reset-password/$token?email=" . urlencode($request->email));

        // Gửi email (hoặc log)
        Mail::raw("Nhấn vào link sau để đổi mật khẩu: $resetLink", function($message) use ($request){
            $message->to($request->email)
                    ->subject('Reset mật khẩu');
        });

        return back()->with('status', 'Link reset đã được gửi vào email của bạn');
    }

    // Form đổi mật khẩu
    public function showResetForm($token, Request $request)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // Xử lý đổi mật khẩu
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Token không hợp lệ']);
        }

        $user = Account::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Đổi mật khẩu thành công! Đăng nhập lại.');
    }
}
