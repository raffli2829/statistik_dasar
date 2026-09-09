<?php

namespace Database\Seeders;

use App\Models\Indicator;
use App\Models\IndicatorTrend;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class StatistikDatabaseSeeder extends Seeder
{
    /**
     * Seed all indicators, trends, and kecamatan data from config/statistik.php.
     */
    public function run(): void
    {
        // 1. Seed 4 Headline Indicators
        $headlines = config('statistik.headline_indicators', []);
        $order = 1;
        foreach ($headlines as $h) {
            $indicator = Indicator::updateOrCreate(
                ['id' => $h['id']],
                [
                    'name' => $h['name'],
                    'short_name' => $h['short_name'] ?? $h['name'],
                    'category' => 'headline',
                    'sector_id' => $h['sector'] ?? null,
                    'unit' => $h['unit'] ?? '%',
                    'digits' => ($h['unit'] === 'Poin' || $h['unit'] === '%') ? 2 : 0,
                    'lower_is_better' => $h['lower_is_better'] ?? false,
                    'order' => $order++,
                    'metadata_produsen' => $h['metadata']['produsen'] ?? null,
                    'metadata_definisi' => $h['metadata']['definisi'] ?? null,
                    'metadata_satuan' => $h['metadata']['satuan'] ?? null,
                    'metadata_metodologi' => $h['metadata']['metodologi'] ?? null,
                    'metadata_jadwal_rilis' => $h['metadata']['jadwal_rilis'] ?? null,
                    'metadata_sumber_url' => $h['metadata']['sumber_url'] ?? null,
                ]
            );

            if (isset($h['trend']) && is_array($h['trend'])) {
                foreach ($h['trend'] as $point) {
                    IndicatorTrend::updateOrCreate(
                        [
                            'indicator_id' => $indicator->id,
                            'wilayah' => 'kabupaten',
                            'year' => (int) $point['year'],
                        ],
                        [
                            'value' => (float) $point['value'],
                        ]
                    );
                }
            }
        }

        // 2. Seed 7 Sector Indicators
        $sectorIndicators = config('statistik.sector_indicators', []);
        $sectorOrder = 1;
        foreach ($sectorIndicators as $sectorId => $sec) {
            $col = $sec['column'] ?? [];
            $indicator = Indicator::updateOrCreate(
                ['id' => $sectorId],
                [
                    'name' => $sec['name'],
                    'short_name' => $sec['short_name'] ?? $sec['name'],
                    'category' => 'sector',
                    'sector_id' => $sectorId,
                    'unit' => $sec['unit'] ?? '',
                    'digits' => $sec['digits'] ?? (($sec['unit'] === '%' || $sec['unit'] === 'Poin' || $sec['unit'] === 'Tahun' || str_contains($sec['unit'], 'Juta')) ? 2 : 0),
                    'lower_is_better' => false,
                    'order' => $sectorOrder++,
                    'column_key' => $col['key'] ?? null,
                    'column_label' => $col['label'] ?? null,
                    'column_unit' => $col['unit'] ?? null,
                    'column_digits' => $col['digits'] ?? null,
                    'metadata_produsen' => $sec['metadata']['produsen'] ?? null,
                    'metadata_definisi' => $sec['metadata']['definisi'] ?? null,
                    'metadata_satuan' => $sec['metadata']['satuan'] ?? null,
                    'metadata_metodologi' => $sec['metadata']['metodologi'] ?? null,
                    'metadata_jadwal_rilis' => $sec['metadata']['jadwal_rilis'] ?? null,
                    'metadata_sumber_url' => $sec['metadata']['sumber_url'] ?? null,
                ]
            );

            if (isset($sec['trend']) && is_array($sec['trend'])) {
                foreach ($sec['trend'] as $point) {
                    IndicatorTrend::updateOrCreate(
                        [
                            'indicator_id' => $indicator->id,
                            'wilayah' => 'kabupaten',
                            'year' => (int) $point['year'],
                        ],
                        [
                            'value' => (float) $point['value'],
                        ]
                    );
                }
            }
        }

        // 3. Seed 8 Kecamatan Data
        $kecamatans = config('statistik.kecamatan', []);
        $kecOrder = 1;
        foreach ($kecamatans as $k) {
            Kecamatan::updateOrCreate(
                ['id' => $k['id']],
                [
                    'name' => $k['name'],
                    'capital' => $k['capital'] ?? $k['name'],
                    'area_km2' => (float) ($k['area_km2'] ?? 0),
                    'density' => (float) ($k['density'] ?? 0),
                    'order' => $kecOrder++,
                    'population' => (float) ($k['population'] ?? 0),
                    'pdrb_kapita' => (float) ($k['pdrb_kapita'] ?? 0),
                    'angkatan_kerja' => (float) ($k['angkatan_kerja'] ?? 0),
                    'puskesmas_faskes' => (float) ($k['puskesmas_faskes'] ?? 0),
                    'sekolah_total' => (float) ($k['sekolah_total'] ?? 0),
                    'lahan_tani' => (float) ($k['lahan_tani'] ?? 0),
                    'penerima_bansos' => (float) ($k['penerima_bansos'] ?? 0),
                ]
            );

            // Seed kecamatan sector trends
            if (isset($k['sector_trends']) && is_array($k['sector_trends'])) {
                foreach ($k['sector_trends'] as $secKey => $trendPoints) {
                    if (is_array($trendPoints)) {
                        foreach ($trendPoints as $point) {
                            IndicatorTrend::updateOrCreate(
                                [
                                    'indicator_id' => $secKey,
                                    'wilayah' => $k['id'],
                                    'year' => (int) $point['year'],
                                ],
                                [
                                    'value' => (float) $point['value'],
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
}
