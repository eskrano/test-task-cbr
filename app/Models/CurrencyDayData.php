<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyDayData extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'currency_id',
        'sync_date',
    ];

    protected $dates = [
        'sync_date'
    ];

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
