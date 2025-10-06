<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class OvertimeEmployee extends BaseModel
{
    protected $table = 'overtime_employee';
    protected $fillable = [
        '$id',        'tenant_id',
 'overtime_id', 'employee_id', 'status', 'decline_reason'
    ];

 public function employee()
{
    return $this->belongsTo(Employee::class);
}


    public function overtime()
    {
        return $this->belongsTo(Overtime::class, 'overtime_id');
    }
}
