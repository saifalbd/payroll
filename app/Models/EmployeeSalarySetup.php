<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalarySetup extends Model
{
    protected $table = 'payroll_employee_salary_setup';
    protected $fillable = [
        'employee_id',
        'eff_date','company_id'
    ];


    public function items(){
        return $this->hasMany(EmployeeSalarySetupItem::class,'setup_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
