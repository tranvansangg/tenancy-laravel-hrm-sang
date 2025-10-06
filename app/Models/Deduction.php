<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class Deduction extends BaseModel 
{
    use HasFactory;
    protected $table = 'deductions';
    protected $fillable = [
           '$id',   'tenant_id',
   'employee_id', 'type', 'amount', 'month'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function payrolls() { return $this->hasMany(Payroll::class); }

}
