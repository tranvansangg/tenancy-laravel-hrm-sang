<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;


class Department extends BaseModel 
{
    use SoftDeletes;

    protected $fillable = [        '$id', 'tenant_id',
'code','name','description','created_by','updated_by', 'status'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }
       public function creator()
    {
        return $this->belongsTo(Account::class, 'created_by');
    }
    public function updater()
{
    return $this->belongsTo(Account::class, 'updated_by');
}

}
