<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.account.edit', compact('user'));
    }

public function update(Request $request)
{
    $user = Auth::user();

    $validatedData = $request->validate([
        'first_name' => 'nullable|string|max:50',
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')
                ->ignore($user->id)
                ->where(function ($query) {
                    return $query->where('tenant_id', tenant('id'));
                }),
        ],
        'phone' => [
            'nullable',
            'string',
            'max:20',
            Rule::unique('users', 'phone')
                ->ignore($user->id)
                ->where(function ($query) {
                    return $query->where('tenant_id', tenant('id'));
                }),
        ],
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Nếu có upload avatar
    if ($request->hasFile('avatar')) {
        if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
            \Storage::disk('public')->delete($user->avatar);
        }
        $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    $user->update($validatedData);

    return back()->with('success', 'Admin đã cập nhật thông tin thành công.');
}




    public function changePasswordForm()
    {
        return view('admin.account.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Admin đổi mật khẩu thành công.');
    }
}
