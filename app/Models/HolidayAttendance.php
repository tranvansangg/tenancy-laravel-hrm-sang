<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\UsesTenantConnection;

class HolidayAttendance extends BaseModel
{
    use HasFactory;

    protected $fillable = [        '$id', 'tenant_id',
'employee_id', 'holiday_id', 'check_in', 'check_out', 'work_hours'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function holiday()
    {
        return $this->belongsTo(Holiday::class);
    }
}
