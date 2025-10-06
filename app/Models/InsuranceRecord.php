<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class InsuranceRecord extends BaseModel
{
    use HasFactory;


    protected $table = 'insurance_records';

    protected $fillable = [
            '$id',    'tenant_id',
 'employee_id',
        'social_insurance_number',
        'health_insurance_number',
        'unemployment_insurance_number',
        'participation_date',
        'status',
        'notes',
    ];

    /**
     * Quan hệ: Một bản ghi BHXH thuộc về một nhân viên
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
