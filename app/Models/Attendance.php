<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'payroll_attendances';
    protected $fillable = [
        'company_id',
        'employee_id',
        'date',
        'attendance_type',
        'is_late'
    ];

    public function attendanceType()
    {
        return $this->belongsTo(AttendanceType::class, 'attendance_type');
    }

    public function inOuts()
    {
        return $this->hasMany(AttendanceInOut::class, 'attendance_id');
    }
}
