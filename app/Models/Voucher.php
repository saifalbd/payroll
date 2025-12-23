<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    protected $table = 'payroll_vouchers';
    protected $fillable = ['employee_id', 'date', 'amount'];


    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function items()
    {
        return $this->hasMany(VoucherItem::class, 'voucher_id');
    }
}
