<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class BusinessTrip extends BaseModel
{

    protected $fillable = [
           '$id',     'tenant_id',
 'trip_code','employee_id','start_date','end_date','location','purpose','notes',
        'created_by','updated_by','estimated_cost','status','requested_by','reason',
        'admin_feedback','report','actual_cost','approved_at','rejected_at','completed_at',
        'created_at','updated_at','deleted_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
