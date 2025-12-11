<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryScaleItem extends Model
{

    protected $table = 'payroll_salary_scales_items';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'scale_id',
        'payhead_id',
        'calc_type',
        'value',
        'formula',
        'parcent_of_id',
        'basis'
    ];

    public function payhead(){
        return $this->belongsTo(Payhead::class,'payhead_id');
    }


    public function parcentOf(){
 return $this->belongsTo(Payhead::class,'parcent_of_id');
    }
}
