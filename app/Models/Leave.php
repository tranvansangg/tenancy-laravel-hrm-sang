<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class Leave extends Model
{
    use HasFactory;
    protected $table = 'leaves';

    protected $fillable = [
           '$id',     'tenant_id',
 'employee_id','admin_note', 'leave_type', 'start_date', 'end_date', 'days', 'status', 'reason', 'is_paid', 'approved_by','document'
        
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function payrolls() { return $this->hasMany(Payroll::class); }
  public function approver()
    {
        return $this->belongsTo(Account::class, 'approved_by');
    }
}
