<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class Position extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [     '$id',    'tenant_id',
'code','name','daily_salary','description','created_by','updated_by', 'status'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

}
