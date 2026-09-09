<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'capital',
        'area_km2',
        'density',
        'order',
        'population',
        'pdrb_kapita',
        'angkatan_kerja',
        'puskesmas_faskes',
        'sekolah_total',
        'lahan_tani',
        'penerima_bansos',
    ];

    protected $casts = [
        'area_km2' => 'float',
        'density' => 'float',
        'order' => 'integer',
        'population' => 'float',
        'pdrb_kapita' => 'float',
        'angkatan_kerja' => 'float',
        'puskesmas_faskes' => 'float',
        'sekolah_total' => 'float',
        'lahan_tani' => 'float',
        'penerima_bansos' => 'float',
    ];
}
