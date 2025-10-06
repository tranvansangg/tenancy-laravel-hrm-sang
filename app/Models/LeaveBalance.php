<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;


class LeaveBalance extends BaseModel
{
    
    protected $fillable = [
              '$id', 'tenant_id',
  'employee_id', 'year', 'total_leave_days', 'used_days', 'remaining_days'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
}
