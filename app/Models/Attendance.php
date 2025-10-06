<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;
use App\Models\Employee;

class Attendance extends BaseModel 
{

    protected $fillable = [
        '$id','tenant_id',
        'employee_id','date','check_in','check_out','hours','status','note'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
