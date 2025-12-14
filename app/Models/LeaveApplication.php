<?php

namespace App\Models;

use App\Models\Employee as ModelsEmployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;

    protected $table = 'payroll_leave_applications';

    protected $fillable = ['emp_id','dates','status','type','subject','message','company_id'];

    protected $casts = ['dates'=>'json'];

    public function employee(){
        return $this->belongsTo(ModelsEmployee::class,'emp_id');
    }
}
