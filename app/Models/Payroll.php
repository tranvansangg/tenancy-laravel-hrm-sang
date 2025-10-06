<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class Payroll extends BaseModel
{
    use HasFactory;

    protected $table = 'payrolls';

    protected $fillable = [
          '$id',    'tenant_id',
   'employee_id', 'month', 'year', 'work_days', 'base_salary',
        'allowance', 'bonus', 'deduction', 'insurance', 'net_salary'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
    
}
