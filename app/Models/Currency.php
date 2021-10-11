<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'code',
        'num_code',
        'name',
        'nominal',
    ];

    /**
     * @return HasMany
     */
    public function dayData(): HasMany
    {
        return $this->hasMany(CurrencyDayData::class);
    }
}
