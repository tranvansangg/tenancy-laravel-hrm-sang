<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;


class HolidayRequest extends BaseModel
{
    use HasFactory;

    protected $fillable = [
           '$id',   'tenant_id',
   'employee_id',
        'department_id',
        'holiday_id',
        'reason',
        'status',
        'manager_id',
        'admin_id',
        'working_hours',
    ];

    // 🔗 Quan hệ: HolidayRequest thuộc về một nhân viên
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // 🔗 Quan hệ: HolidayRequest thuộc về một phòng ban
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // 🔗 Quan hệ: HolidayRequest thuộc về một ngày lễ
    public function holiday()
    {
        return $this->belongsTo(Holiday::class);
    }

    // 🔗 Quan hệ: HolidayRequest được duyệt bởi trưởng phòng
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    // 🔗 Quan hệ: HolidayRequest được duyệt bởi admin
    public function admin()
    {
        return $this->belongsTo(Employee::class, 'admin_id');
    }
}
