<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherItem extends Model
{
    protected $table = 'payroll_voucher_items';
    protected $fillable = ['voucher_id','payhead_id','amount'];

    public function payhead()
    {
        return $this->belongsTo(Payhead::class,'payhead_id');
    }
}
