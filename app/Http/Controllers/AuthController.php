<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Trang đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhậppublic function login(Request $request)
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        $user = Auth::user();

        // Lấy tenant hiện tại
        $tenantId = session('tenant_id'); // hoặc tenant('id') nếu dùng package tenancy

        // Kiểm tra tenant và vị trí
        if ($user->role === 'employee') {
            $employee = $user->employee;

            if (!$employee) {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'email' => 'Nhân viên chưa được gán vào tenant.'
                ]);
            }

            // Kiểm tra tenant_id
            if ($employee->tenant_id !== $tenantId) {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'email' => 'Bạn không thuộc tenant này.'
                ]);
            }

            // Kiểm tra vị trí
            if ($employee->position?->name === 'Trưởng phòng') {
                return redirect()->route('manager.dashboard');
            }

        
        }

        // Employee
        if ($user->role === 'employee') {
            return redirect()->route('employee.dashboard');
        }

        // Admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Email hoặc mật khẩu không đúng!',
    ]);
}


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
