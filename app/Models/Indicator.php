<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indicator extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'short_name',
        'category',
        'sector_id',
        'unit',
        'digits',
        'lower_is_better',
        'order',
        'column_key',
        'column_label',
        'column_unit',
        'column_digits',
        'metadata_produsen',
        'metadata_definisi',
        'metadata_satuan',
        'metadata_metodologi',
        'metadata_jadwal_rilis',
        'metadata_sumber_url',
    ];

    protected $casts = [
        'digits' => 'integer',
        'lower_is_better' => 'boolean',
        'order' => 'integer',
        'column_digits' => 'integer',
    ];

    /**
     * Relasi ke tren nilai per tahun.
     */
    public function trends(): HasMany
    {
        return $this->hasMany(IndicatorTrend::class, 'indicator_id');
    }

    /**
     * Mendapatkan tren nilai untuk wilayah tertentu (default kabupaten) diurutkan berdasarkan tahun.
     */
    public function getTrendsForWilayah(string $wilayah = 'kabupaten', string $direction = 'desc'): array
    {
        return $this->trends()
            ->where('wilayah', $wilayah)
            ->orderBy('year', $direction)
            ->get(['year', 'value'])
            ->toArray();
    }

    /**
     * Mendapatkan nilai indikator pada tahun tertentu untuk wilayah tertentu.
     */
    public function getValueForYear(int $year, string $wilayah = 'kabupaten'): ?float
    {
        $trend = $this->trends()
            ->where('wilayah', $wilayah)
            ->where('year', $year)
            ->first();

        if ($trend) {
            return (float) $trend->value;
        }

        // Ambil nilai tahun terbaru yang ada
        $latest = $this->trends()
            ->where('wilayah', $wilayah)
            ->orderBy('year', 'desc')
            ->first();

        return $latest ? (float) $latest->value : null;
    }

    /**
     * Menghitung perubahan YoY (Year over Year).
     */
    public function calculateYoyChange(int $year, string $wilayah = 'kabupaten'): float
    {
        $current = $this->getValueForYear($year, $wilayah);
        $previous = $this->getValueForYear($year - 1, $wilayah);

        if ($current !== null && $previous !== null && $previous != 0) {
            return round($current - $previous, 2);
        }

        return 0.0;
    }
}
