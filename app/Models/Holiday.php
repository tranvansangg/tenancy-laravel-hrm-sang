<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;


class Holiday extends BaseModel
{
    use HasFactory;

    protected $table = 'holidays';

    protected $fillable = [ '$id',        'tenant_id',
'date', 'description'];

    public function requests()
    {
        return $this->hasMany(HolidayRequest::class);
    }

    public function attendances()
    {
        return $this->hasMany(HolidayAttendance::class);
    }
}
