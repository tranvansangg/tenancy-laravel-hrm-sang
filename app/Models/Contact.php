<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class Contact extends BaseModel 
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
            '$id',   'tenant_id',
  'name','email','phone','message','reply','created_at','updated_at'
    ];
}
