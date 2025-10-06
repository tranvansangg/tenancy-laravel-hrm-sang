<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class AuditLog extends BaseModel 
{

    protected $fillable = [      '$id',   'tenant_id',
'user_id','action','details'];

    public function user()
    {
        return $this->belongsTo(Account::class);
    }
}
