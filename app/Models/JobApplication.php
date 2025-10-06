<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class JobApplication extends BaseModel
{
    use HasFactory;

    protected $fillable = [
             '$id',    'tenant_id',
'job_id',
        'applicant_name',
        'email',
        'phone',
        'cv_file',
        'cover_letter',
    
        'created_at',
        'updated_at'
        
        
    ];

    public function job() {
        return $this->belongsTo(Job::class);
    }

}
