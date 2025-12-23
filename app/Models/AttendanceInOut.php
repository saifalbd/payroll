<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceInOut extends Model
{
    protected $table = 'payroll_attendance_in_outs';
    public $timestamps = false;
    protected $fillable = [
        'attendance_id',
        'time_in',
        'time_out',
    ];
}
