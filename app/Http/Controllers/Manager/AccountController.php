<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {
        // Kiểm tra user là trưởng phòng trước khi vào bất kỳ function nào
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user || !$user->employee || $user->employee->position->name !== 'Trưởng phòng') {
                return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập.');
            }
            return $next($request);
        });
    }

    // Hiển thị form chỉnh sửa thông tin
    public function editt()
    {
        $user = Auth::user();
        return view('manager.account.edit', compact('user'));
    }

    // Cập nhật thông tin
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'nullable|string|max:50',
            'phone'      => 'nullable|string|max:20|unique:users,phone,' . $user->id,
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'avatar'     => 'nullable|image|max:2048',
        ]);

        $data = $request->only('first_name',  'phone', 'email');

        if ($request->hasFile('avatar')) {
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success_info', 'Manager cập nhật thông tin thành công.');
    }

    // Hiển thị form đổi mật khẩu
    public function changePasswordForm()
    {
        return view('manager.account.change-password');
    }

    // Xử lý đổi mật khẩu

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password'     => 'required|min:6|confirmed',
    ]);

    $user = Auth::user();
    $employee = $user->employee;

    // ✅ Kiểm tra quyền Trưởng phòng
    if (!$employee || !$employee->position || $employee->position->name !== 'Trưởng phòng') {
        abort(403, 'Bạn không có quyền đổi mật khẩu này. Chỉ Trưởng phòng mới được phép.');
    }

    // ✅ Kiểm tra mật khẩu hiện tại
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
    }

    // ✅ Đổi mật khẩu
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Trưởng phòng đổi mật khẩu thành công.');
}
}
