<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalarySetupItem extends Model
{
   public $timestamps = false;

   protected $table = 'payroll_employee_salary_setup_items';
   protected $fillable = [
      'setup_id',
      'payhead_id',
      'calc_type',
      'value',
      'parcent_of_id',
      'formula',
      'basis'
   ];

   public function payhead()
   {
      return $this->belongsTo(Payhead::class, 'payhead_id');
   }


   public function parcentOf()
   {
      return $this->belongsTo(Payhead::class, 'parcent_of_id');
   }
}
