<?php

namespace App\Models;

use App\Models\Ledger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payhead extends Model
{
    use HasFactory;

    protected $table = 'payroll_payheads';

    protected $fillable = [
        'company_id',
        'title',
        'type',
        'ledger_id',
        
    ];




    public function ledger(){
          return $this->belongsTo(Ledger::class,'ledger_id'); 
    }
}
