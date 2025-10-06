<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class Job extends BaseModel
{
    use HasFactory;

    protected $fillable = [
             '$id',  'tenant_id',
  'title',
        'description',
        'status',
        'company_id',
        'location',
        'type',
        'salary'
    ];

    public function applications() {
        return $this->hasMany(JobApplication::class);
    }
}
