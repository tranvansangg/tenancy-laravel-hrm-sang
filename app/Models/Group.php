<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;


class Group extends BaseModel

{
    protected $table = 'groups';
    
protected $fillable = [       '$id',  'tenant_id',
'name', 'type', 'leader_id', 'description', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];






public function groups()
{
    return $this->belongsToMany(Group::class, 'group_employee', 'employee_id', 'group_id')
        ->withPivot('joined_at', 'exited_at', 'tenant_id')
        ->where('group_employee.tenant_id')
        ->where('groups.tenant_id');
}

    // Quan hệ với employees
 

    // Quan hệ leader
// ...existing code...
   public function employees()
    {
        return $this->belongsToMany(Employee::class, 'group_employee', 'group_id', 'employee_id')
            ->withPivot('tenant_id', 'joined_at', 'exited_at', 'reason_exit', 'status_exit', 'created_at', 'updated_at');
    }

    public function leader()
    {
        return $this->belongsTo(Employee::class, 'leader_id');
    }


}
