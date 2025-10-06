<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class SalaryTemplate extends BaseModel
{
    protected $fillable = [       '$id',  'tenant_id',
'name', 'base_salary', 'allowance', 'bonus', 'deduction', 'insurance'];
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
