<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;


class MaternityLeave extends BaseModel
{
    protected $fillable = [
             '$id',  'tenant_id',
  'employee_id','start_date','end_date','status','approved_by','notes'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver()
    {
        return $this->belongsTo(Account::class, 'approved_by');
    }
}
