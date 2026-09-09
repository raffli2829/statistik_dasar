<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicatorTrend extends Model
{
    use HasFactory;

    protected $fillable = [
        'indicator_id',
        'wilayah',
        'year',
        'value',
    ];

    protected $casts = [
        'year' => 'integer',
        'value' => 'float',
    ];

    /**
     * Relasi ke indikator induk.
     */
    public function indicator(): BelongsTo
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }
}
