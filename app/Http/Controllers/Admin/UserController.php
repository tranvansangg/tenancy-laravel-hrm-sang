<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Models\Employee;
use App\Models\Account;
use App\Mail\AccountCreatedMail;

class UserController extends Controller
{
    // Hiển thị danh sách user theo tenant
    public function index()
    {
        $tenantId = session('tenant_id'); // Tenant hiện tại

        $users = Account::with('employee')
                        ->where('tenant_id', $tenantId)
                        ->latest()
                        ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // Form tạo user mới
    public function create()
    {
        $tenantId = session('tenant_id');

        // Lấy employee chưa có account trong tenant
        $employees = Employee::whereNull('account_id')
                             ->where('tenant_id', $tenantId)
                             ->get();

        return view('admin.users.create', compact('employees'));
    }

    // Lưu user mới
    public function store(Request $request)
    {
        $tenantId = session('tenant_id');

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'role' => 'required|in:admin,employee',
            'is_active' => 'required|in:0,1',
        ]);

        $employee = Employee::where('id', $request->employee_id)
                            ->where('tenant_id', $tenantId)
                            ->firstOrFail();

        // Kiểm tra email và phone chỉ trong tenant
        if (Account::where('email', $employee->email)->where('tenant_id', $tenantId)->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email đã tồn tại trong tenant này!']);
        }

        if ($employee->phone && Account::where('phone', $employee->phone)->where('tenant_id', $tenantId)->exists()) {
            return redirect()->back()->withErrors(['phone' => 'Số điện thoại đã tồn tại trong tenant này!']);
        }

        $plainPassword = Str::random(8);

        $user = Account::create([
            'employee_id' => $employee->id,
            'first_name' => $employee->full_name,
            'last_name' => $employee->nickname,
            'email' => $employee->email,
            'password' => Hash::make($plainPassword),
            'role' => $request->role,
            'is_active' => $request->is_active,
            'phone' => $employee->phone,
            'avatar' => $employee->avatar,
            'tenant_id' => $tenantId,
        ]);

        // Cập nhật employee -> account
        $employee->account_id = $user->id;
        $employee->save();

        // Gửi mail thông báo (nếu cần)
        try {
            Mail::to($user->email)->send(new AccountCreatedMail($user, $plainPassword));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                             ->with('warning', 'Tạo tài khoản thành công, nhưng không gửi được email.');
        }

        return redirect()->route('admin.users.index')
                         ->with('success', 'Tạo tài khoản thành công! Email đã được gửi.');
    }

    // Form chỉnh sửa user
    public function edit(Account $user)
    {
        $tenantId = session('tenant_id');

        if ($user->tenant_id != $tenantId) {
            abort(403, 'Không có quyền truy cập user này.');
        }

        return view('admin.users.edit', compact('user'));
    }

    // Cập nhật user
    public function update(Request $request, Account $user)
    {
        $tenantId = session('tenant_id');

        if ($user->tenant_id != $tenantId) {
            abort(403, 'Không có quyền cập nhật user này.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id)->where(fn($q) => $q->where('tenant_id', $tenantId))
            ],
            'phone' => [
                'nullable',
                Rule::unique('users', 'phone')->ignore($user->id)->where(fn($q) => $q->where('tenant_id', $tenantId))
            ],
            'role' => 'required|in:admin,employee',
            'is_active' => 'required|in:0,1',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['first_name', 'last_name', 'email', 'phone', 'role', 'is_active']);

        // Xử lý upload avatar
        if($request->hasFile('avatar')){
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    // Xóa user
    public function destroy(Account $user)
    {
        $tenantId = session('tenant_id');

        if ($user->tenant_id != $tenantId) {
            abort(403, 'Không có quyền xóa user này.');
        }

        $user->forceDelete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Xóa tài khoản thành công!');
    }
}
