<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class BaseModel extends Model
{
    protected static function booted()
    {
        static::addGlobalScope('tenant', function ($query) {
            if (Session::has('tenant_id')) {
                $query->where('tenant_id', Session::get('tenant_id'));
            }
        });

        static::creating(function ($model) {
            if (Session::has('tenant_id')) {
                $model->tenant_id = Session::get('tenant_id');
            }
        });
    }
}
