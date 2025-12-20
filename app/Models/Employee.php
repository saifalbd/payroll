<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Image;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable implements MustVerifyEmail
{
     use Notifiable;

    protected $table = 'payroll_employees';
    protected $hidden = ['password'];
    protected $appends = ['avatarUrl'];
    protected $fillable = [
        'company_id',
        "employee_id",
        "employee_name",
        "designation",
        "department_id",
        "joining_date",
        "contact_no",
        "email",
        "linkedin",
        "nid",
        "current_address",
        "permanent_address",
        "district",
        "police_station",
        "post_office",
        "village",
        "father",
        "mother",
        'avatar',
        "password"
    ];


    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }

    public function avatarUrl()
    {
        return $this->belongsTo(Image::class,'avatar_id');
    }

    public function getAvatarUrlAttribute()
    {
        return Storage::disk('public')->url($this->avatar);
    }

    public function salarySetup(){
        return $this->hasOne(EmployeeSalarySetup::class,'employee_id');
    }

    public function attendances(){
        return $this->hasMany(Attendance::class,'employee_id');
    }
}
