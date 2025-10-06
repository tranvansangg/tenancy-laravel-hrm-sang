<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable; // 🔹 kế thừa Authenticatable

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Employee;
use App\Models\Group;

class Account extends   Authenticatable// 🔹 kế thừa Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'tenant_id',
        'avatar',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'role',
        'access_count',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    'account_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Quan hệ


    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'account_id', 'group_id');
    }
    public function employee()
{
    return $this->hasOne(Employee::class);
}

}
