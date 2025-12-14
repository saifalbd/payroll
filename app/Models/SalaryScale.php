<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryScale extends Model
{

    protected $table = 'payroll_salary_scales';

    protected $fillable = [
        'title','company_id'
    ];


    public function items(){
        return $this->hasMany(SalaryScaleItem::class,'scale_id');
    }
}
