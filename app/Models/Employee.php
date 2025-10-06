<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;            
use App\Models\EducationLevel;
use App\Models\Specialty;
use App\Models\Degree;
use App\Models\EmployeeType;
use App\Models\Payroll;
use App\Models\BusinessTrip;
use App\Models\Reward;
use App\Models\Discipline;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Insurance;
use App\Models\SalaryTemplate;
use App\Models\InsuranceRecord;
use App\Models\Overtime;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Bonus;
use App\Models\OvertimeEmployee;
use App\Models\Group;
use App\Models\OvertimeRequest;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;


class Employee extends BaseModel
{
    use SoftDeletes;


    protected $table = 'employees';

    protected $fillable = [
             '$id',  'tenant_id',
  'employee_code', 'account_id', 'user_id','avatar','full_name','nickname','gender','birth_date',
        'birth_place','cccd','cccd_issue_date','cccd_issue_place','nationality','religion','ethnicity',
        'employee_type_id','degree_id','status','address_permanent','address_resident','temporary_address',
        'department_id','position_id','education_level_id','specialty_id','manager_id','email',
        'start_work_date','leave_carry_over','bhxh_join_date','bhxh_participation_status','phone','note'
        
    ];

 
// User.php
public function employee() {
    return $this->hasOne(Employee::class);
}
  

    public function exitStatus()
    {
        return $this->hasOne(ExitStatus::class, 'employee_group_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class);
    }



    public function businessTrips()
    {
        return $this->hasMany(BusinessTrip::class);
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function disciplines()
    {
        return $this->hasMany(Discipline::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function manager()
{
    return $this->belongsTo(Employee::class, 'manager_id');
}

public function subordinates()
{
    return $this->hasMany(Employee::class, 'manager_id');
}
public function payrolls() { return $this->hasMany(Payroll::class); }
public function insurance() { return $this->hasOne(InsuranceRecord::class); }


public function allowances() {
    return $this->hasMany(Allowance::class);
}

public function deductions() {
    return $this->hasMany(Deduction::class);
}

public function bonuses() {
    return $this->hasMany(Bonus::class);
}

public function leaves() {
    return $this->hasMany(Leave::class);
}

public function salary_template() {
    return $this->belongsTo(SalaryTemplate::class, 'salary_template_id');
}
// Employee.php
public function user() {
    return $this->belongsTo(Account::class,  'account_id', 'id');
}
   public function overtimes()
    {
        return $this->belongsToMany(OvertimeEmployee::class, 'overtime_employee')
                    ->withPivot('status','decline_reason')
                    ->withTimestamps();
    }
    // OT mà nhân viên tạo (nếu là trưởng phòng)
    public function createdOvertimes()
    {
        return $this->hasMany(OvertimeEmployee::class, 'creator_id');
    }

    // OT mà nhân viên duyệt (admin)
    public function approvedOvertimes()
    {
        return $this->hasMany(OvertimeEmployee::class, 'approver_id');
    }
// Employee.php

// Employee.php
  public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_employee', 'employee_id', 'group_id')
            ->withPivot('tenant_id', 'joined_at', 'exited_at', 'reason_exit', 'status_exit', 'created_at', 'updated_at');
    }

// Group.php
public function employees()
{
    return $this->belongsToMany(Employee::class, 'group_employee', 'group_id', 'employee_id')
        ->withPivot('joined_at', 'exited_at', 'status_exit');
}

public function leader()
{
    return $this->belongsTo(Employee::class, 'leader_id');
}


   public function isLeader() {
    return Group::where('leader_id',$this->id)->exists();
}
public function insuranceRecords()
{
    return $this->hasMany(InsuranceRecord::class, 'employee_id');
}
public function holidayRequests()
{
    return $this->hasMany(\App\Models\HolidayRequest::class, 'employee_id');
}



}
