<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Employee,
    Department,
    Position,
    EmployeeType,
    Degree,
    Specialty,
    EducationLevel
};
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with([
            'department', 'position', 'employeeType', 'degree', 'specialty', 'educationLevel'
        ])->paginate(10);

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create', [
            'departments'      => Department::all(),
            'positions'        => Position::all(),
            'employee_types'   => EmployeeType::all(),
            'degrees'          => Degree::all(),
            'specialties'      => Specialty::all(),
            'education_levels' => EducationLevel::all(),
        ]);
    }

public function store(Request $request)
{
    try {
        $request->validate([
            'employee_code' => [
                'required',
                Rule::unique('employees', 'employee_code')
                    ->where(fn($q) => $q->where('tenant_id', tenant('id'))),
            ],
            'full_name' => 'required',
            'email' => [
                'required', 'email',
                Rule::unique('employees', 'email')
                    ->where(fn($q) => $q->where('tenant_id', tenant('id'))),
            ],
            'cccd' => [
                'required', 'regex:/^\d{12}$/',
                Rule::unique('employees', 'cccd')
                    ->where(fn($q) => $q->where('tenant_id', tenant('id'))),
            ],
            'phone' => [
                'required', 'string', 'max:20',
                Rule::unique('employees', 'phone')
                    ->where(fn($q) => $q->where('tenant_id', tenant('id'))),
            ],
            'department_id'      => 'required',
            'position_id'        => 'required',
            'employee_type_id'   => 'required',
            'education_level_id' => 'required',
            'start_work_date'    => 'required|date',
        ], [
            'employee_code.required' => 'Mã nhân viên không được để trống.',
            'employee_code.unique'   => 'Mã nhân viên đã tồn tại trong công ty này.',
            'email.unique'           => 'Email đã tồn tại trong công ty này.',
            'cccd.unique'            => 'CCCD đã tồn tại trong công ty này.',
            'phone.unique'           => 'Số điện thoại đã tồn tại trong công ty này.',
        ]);

        DB::beginTransaction();

        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $data['tenant_id'] = tenant('id');

        Employee::create($data);

        DB::commit();
        return redirect()->route('admin.employees.index')
            ->with('success', 'Thêm nhân viên thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();

        // Nếu MySQL báo trùng unique (mã lỗi 23000)
        if ($e->getCode() == 23000) {
            $message = $e->getMessage();

            if (str_contains($message, 'employees_tenant_id_employee_code_unique')) {
                $errorField = 'Mã nhân viên đã tồn tại trong công ty này.';
            } elseif (str_contains($message, 'employees_tenant_id_email_unique')) {
                $errorField = 'Email đã tồn tại trong công ty này.';
            } elseif (str_contains($message, 'employees_tenant_id_cccd_unique')) {
                $errorField = 'CCCD đã tồn tại trong công ty này.';
            } elseif (str_contains($message, 'employees_tenant_id_phone_unique')) {
                $errorField = 'Số điện thoại đã tồn tại trong công ty này.';
            } else {
                $errorField = 'Dữ liệu đã tồn tại trong công ty này.';
            }

            return back()->withErrors(['error' => $errorField])->withInput();
        }

        return back()->withErrors(['error' => 'Lỗi thêm nhân viên: ' . $e->getMessage()])->withInput();
    }
}

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', [
            'employee'         => $employee,
            'departments'      => Department::all(),
            'positions'        => Position::all(),
            'employee_types'   => EmployeeType::all(),
            'degrees'          => Degree::all(),
            'specialties'      => Specialty::all(),
            'education_levels' => EducationLevel::all(),
        ]);
    }

      public function update(Request $request, Employee $employee)
{
    try {
        $request->validate([
            'employee_code' => [
                'required',
                Rule::unique('employees', 'employee_code')
                    ->ignore($employee->id)
                    ->where(fn($q) => $q->where('tenant_id', tenant('id'))),
            ],
            'full_name' => 'required',
            'email' => [
                'required', 'email',
                Rule::unique('employees', 'email')
                    ->ignore($employee->id)
                    ->where(fn($q) => $q->where('tenant_id', tenant('id'))),
            ],
            'cccd' => [
                'required', 'regex:/^\d{12}$/',
                Rule::unique('employees', 'cccd')
                    ->ignore($employee->id)
                    ->where(fn($q) => $q->where('tenant_id', tenant('id'))),
            ],
            'phone' => [
                'required', 'string', 'max:20',
                Rule::unique('employees', 'phone')
                    ->ignore($employee->id)
                    ->where(fn($q) => $q->where('tenant_id', tenant('id'))),
            ],
            'cccd_issue_date' => 'required|date',
            'start_work_date' => 'required|date',
        ], [
            // 🟡 Thông báo lỗi thân thiện hơn
            'employee_code.unique' => 'Mã nhân viên đã tồn tại trong công ty này.',
            'email.unique'          => 'Email này đã được sử dụng trong công ty.',
            'cccd.unique'           => 'Số CCCD này đã tồn tại trong công ty.',
            'phone.unique'          => 'Số điện thoại này đã tồn tại trong công ty.',
            'cccd.regex'            => 'Số CCCD phải gồm đúng 12 chữ số.',
        ]);

        DB::beginTransaction();

        $data = $request->all();

        // Cập nhật avatar nếu có upload
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            unset($data['avatar']);
        }

        $employee->update($data);

        DB::commit();
        return redirect()->route('admin.employees.index')
            ->with('success', 'Cập nhật nhân viên thành công!');
    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollBack();

        // 🟠 Xử lý lỗi trùng khóa Unique nếu bị DB bắt
        if ($e->getCode() == 23000) {
            return back()
                ->withErrors(['error' => 'Thông tin trùng lặp: Email, SĐT, CCCD hoặc mã nhân viên đã tồn tại.'])
                ->withInput();
        }

        // 🟥 Các lỗi khác
        return back()
            ->withErrors(['error' => 'Cập nhật thất bại: ' . $e->getMessage()])
            ->withInput();
    }
}
    public function destroy(Employee $employee)
    {
        DB::beginTransaction();
        try {
            $employee->forceDelete();
            DB::commit();
            return redirect()->route('admin.employees.index')->with('success', 'Xóa nhân viên thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Xóa thất bại: ' . $e->getMessage()]);
        }
    }
}
