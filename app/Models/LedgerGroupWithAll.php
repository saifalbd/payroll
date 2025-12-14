<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LedgerGroupWithAll extends Model
{
      protected $table = 'ledger_groups';
    protected $fillable = ['company_id', 'parent_id', 'title', 'is_default', 'group_code', 'behave'];
    protected $with = ['subGroups','ledgers'];
    protected $casts = [
        'id' => 'int',
        'group_code' => 'int',
        'is_default' => 'bool'
    ];

    // protected $with = ['subGroups','ledgers'];

    /**
     * parent
     *derect parent
     * @return BelongsTo
     */
   
    public function subGroups(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id')->latest('group_code');
    }

  
   
    /**
     * ledgers
     *
     * @return HasMany
     */
    public function ledgers(): HasMany
    {
        return $this->hasMany(Ledger::class, 'group_id');
    }

    public function scopeRoots(Builder $builder)
    {
        return $builder->where('parent_id', null);
    }

    

}
