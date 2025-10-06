<?php
namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <-- BƯỚC 1: Thêm dòng này
class AccountController extends Controller
{
    // Hiển thị form chỉnh sửa thông tin
    public function edit()
    {
        $user = Auth::user();
        return view('employee.account.edit', compact('user'));
    }
    // Cập nhật thông tin
public function update(Request $request)
{
    $authUser = Auth::user();              // users table
    $employee = $authUser->employee;       // employees table

    $request->validate([
        'first_name' => 'nullable|string|max:255',
        'phone'      => 'nullable|string|max:20|unique:employees,phone,' . $employee->id,
        'email'      => 'required|email|unique:users,email,' . $authUser->id,
        'avatar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Cập nhật bảng employees
    $employee->full_name = $request->first_name;
    $employee->phone = $request->phone;
    $employee->save();

    // Cập nhật bảng users
    $authUser->email = $request->email;

    if ($request->hasFile('avatar')) {
        if ($authUser->avatar && \Storage::exists('public/' . $authUser->avatar)) {
            \Storage::delete('public/' . $authUser->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $authUser->avatar = $path;
    }

    $authUser->save();

    return back()->with('success', 'Cập nhật thông tin thành công!');
}



    public function changePasswordForm()
    {
        return view('employee.account.change-password');
    }
    // Xử lý đổi mật khẩu
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check( $request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }
        $user->password = Hash::make( $request->new_password);
        $user->save();
        return back()->with('success', 'Employee đổi mật khẩu thành công.');
    }
}
