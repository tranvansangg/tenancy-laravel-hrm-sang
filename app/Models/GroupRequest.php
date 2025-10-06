<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class GroupRequest extends BaseModel
{
    protected $fillable = [      '$id',   'tenant_id',
'employee_id','group_id','type','status','approver_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class,'group_id');
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class,'approver_id');
    }
}
