<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;


class Discipline extends BaseModel

{
    protected $fillable = [
              '$id',  'tenant_id',
 'decision_code','employee_id','type','reason','decision_date','signed_by','attachment'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
