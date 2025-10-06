<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class Overtime extends BaseModel
{
    protected $table = 'overtimes';
    protected $fillable = [
            '$id',    'tenant_id',
 'department_id','creator_id','date','start_time','end_time','reason','approver_id','status'
    ];

    public function employees()
{
    return $this->hasMany(OvertimeEmployee::class);
}


    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'creator_id');
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approver_id');
    }
}
