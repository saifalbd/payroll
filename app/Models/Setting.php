<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'payroll_settings';
    protected $fillable = ['company_id', 'value', 'prop'];
    protected $casts = ['value' => 'json'];
    public $timestamps = false;

    const DAY_LIMIT = 'dayLimit';



    public static function getModel($company_id, $prop)
    {
        $has = static::query()->where('company_id', $company_id)->where('prop', $prop)->first();
        if ($has) {
            return $has->value;
        } else {
            return null;
        }
    }
}
