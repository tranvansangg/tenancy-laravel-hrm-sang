<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;




use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;



class EmployeeGroup extends Pivot
{

    protected $table = 'group_employee';

    public $timestamps = false;

    protected $fillable = [   '$id',      'tenant_id',
'group_id', 'employee_id', 'joined_at', 'exited_at', 'reason_exit', 'status_exit', 'created_at', 'updated_at', 'deleted_at'];



    

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}
