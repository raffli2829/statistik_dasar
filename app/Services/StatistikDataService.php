<?php

namespace App\Services;

use App\Models\Indicator;
use App\Models\IndicatorTrend;
use App\Models\Kecamatan;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StatistikDataService
{
    /**
     * Cache key prefix.
     */
    protected const CACHE_KEY = 'statistik_dasar_data_';

    /**
     * Memeriksa apakah tabel database sudah ada dan memiliki data.
     */
    public function hasDatabaseTables(): bool
    {
        try {
            return Schema::hasTable('indicators')
                && Schema::hasTable('indicator_trends')
                && Schema::hasTable('kecamatans')
                && Indicator::query()->exists();
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Mengambil tahun yang tersedia.
     */
    public function getYears(): array
    {
        if (! $this->hasDatabaseTables()) {
            return config('statistik.years', [2025, 2024, 2023, 2022, 2021, 2020]);
        }

        $dbYears = IndicatorTrend::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return ! empty($dbYears) ? $dbYears : config('statistik.years', [2025, 2024, 2023, 2022, 2021, 2020]);
    }

    /**
     * Mengambil tahun default (terbaru).
     */
    public function getDefaultYear(): int
    {
        $years = $this->getYears();

        return $years[0] ?? config('statistik.default_year', 2025);
    }

    /**
     * Mengambil daftar 7 sektor.
     */
    public function getSectors(): array
    {
        return config('statistik.sectors', [
            ['id' => 'kependudukan', 'label' => 'Kependudukan', 'icon' => 'users', 'color' => '#DC2626'],
            ['id' => 'perekonomian', 'label' => 'Perekonomian', 'icon' => 'trending-up', 'color' => '#E11D48'],
            ['id' => 'ketenagakerjaan', 'label' => 'Ketenagakerjaan', 'icon' => 'briefcase', 'color' => '#BE123C'],
            ['id' => 'kesehatan', 'label' => 'Kesehatan', 'icon' => 'heart-pulse', 'color' => '#991B1B'],
            ['id' => 'pendidikan', 'label' => 'Pendidikan', 'icon' => 'graduation-cap', 'color' => '#B91C1C'],
            ['id' => 'pertanian', 'label' => 'Pertanian & Pangan', 'icon' => 'wheat', 'color' => '#C2410C'],
            ['id' => 'sosial', 'label' => 'Sosial & Kesejahteraan', 'icon' => 'shield-check', 'color' => '#7C2D12'],
        ]);
    }

    /**
     * Mengambil 4 Headline Indicators (level Kabupaten atau level Kecamatan).
     */
    public function getHeadlineIndicators(int $selectedYear = 2025, ?string $wilayah = 'kabupaten'): array
    {
        if (! $this->hasDatabaseTables()) {
            if ($wilayah && $wilayah !== 'kabupaten') {
                $allKec = config('statistik.kecamatan', []);
                $kec = collect($allKec)->firstWhere('id', $wilayah);
                if ($kec && isset($kec['kpi_cards'])) {
                    return $kec['kpi_cards'];
                }
            }

            return config('statistik.headline_indicators', []);
        }

        $cacheKey = self::CACHE_KEY."headlines_{$selectedYear}_{$wilayah}";

        return Cache::remember($cacheKey, 300, function () use ($selectedYear, $wilayah) {
            // Jika wilayah kecamatan spesifik
            if ($wilayah && $wilayah !== 'kabupaten') {
                $kec = Kecamatan::find($wilayah);
                if ($kec) {
                    return $this->getKecamatanHeadlineCards($kec, $selectedYear);
                }
            }

            // Kabupaten Headline Indicators
            $indicators = Indicator::with(['trends' => function ($q) {
                $q->where('wilayah', 'kabupaten')->orderBy('year', 'desc');
            }])
                ->where('category', 'headline')
                ->orderBy('order')
                ->get();

            if ($indicators->isEmpty()) {
                // Fallback ke config
                return config('statistik.headline_indicators', []);
            }

            return $indicators->map(function ($ind) use ($selectedYear) {
                $trend = $ind->trends->map(fn ($t) => ['year' => (int) $t->year, 'value' => (float) $t->value])->values()->toArray();
                $curPoint = collect($trend)->firstWhere('year', $selectedYear);
                $curVal = $curPoint ? $curPoint['value'] : ($trend[0]['value'] ?? 0);

                // YoY Change
                $prevPoint = collect($trend)->firstWhere('year', $selectedYear - 1);
                $yoyChange = $prevPoint ? round($curVal - $prevPoint['value'], 2) : 0.0;

                return [
                    'id' => $ind->id,
                    'name' => $ind->name,
                    'short_name' => $ind->short_name,
                    'sector' => $ind->sector_id,
                    'value' => $curVal,
                    'unit' => $ind->unit,
                    'digits' => $ind->digits,
                    'yoy_change' => $yoyChange,
                    'lower_is_better' => (bool) $ind->lower_is_better,
                    'trend' => $trend,
                    'metadata' => [
                        'produsen' => $ind->metadata_produsen,
                        'definisi' => $ind->metadata_definisi,
                        'satuan' => $ind->metadata_satuan ?: $ind->unit,
                        'metodologi' => $ind->metadata_metodologi,
                        'jadwal_rilis' => $ind->metadata_jadwal_rilis,
                        'sumber_url' => $ind->metadata_sumber_url,
                    ],
                ];
            })->toArray();
        });
    }

    /**
     * Mengambil 4 KPI cards khusus untuk level Kecamatan.
     */
    protected function getKecamatanHeadlineCards(Kecamatan $kec, int $selectedYear): array
    {
        // 1. Penduduk
        $popTrends = IndicatorTrend::where('indicator_id', 'kependudukan')
            ->where('wilayah', $kec->id)
            ->orderBy('year', 'desc')
            ->get();
        $popTrendArr = $popTrends->map(fn ($t) => ['year' => (int) $t->year, 'value' => (float) $t->value])->values()->toArray();
        $popCur = collect($popTrendArr)->firstWhere('year', $selectedYear)['value'] ?? ($popTrendArr[0]['value'] ?? $kec->population);
        $popPrev = collect($popTrendArr)->firstWhere('year', $selectedYear - 1)['value'] ?? $popCur;
        $popYoy = $popPrev > 0 ? round((($popCur - $popPrev) / $popPrev) * 100, 2) : 0.0;

        // 2. Kepadatan
        $densityVal = $kec->area_km2 > 0 ? round($popCur / $kec->area_km2) : $kec->density;
        $densityTrend = array_map(function ($p) use ($kec) {
            return [
                'year' => $p['year'],
                'value' => $kec->area_km2 > 0 ? round($p['value'] / $kec->area_km2) : $kec->density,
            ];
        }, $popTrendArr);

        // 3. Luas Wilayah
        $areaTrend = array_map(function ($p) use ($kec) {
            return ['year' => $p['year'], 'value' => (float) $kec->area_km2];
        }, $popTrendArr);

        // 4. PDRB per Kapita
        $pdrbTrends = IndicatorTrend::where('indicator_id', 'perekonomian')
            ->where('wilayah', $kec->id)
            ->orderBy('year', 'desc')
            ->get();
        $pdrbTrendArr = $pdrbTrends->map(fn ($t) => ['year' => (int) $t->year, 'value' => (float) $t->value])->values()->toArray();
        $pdrbCur = collect($pdrbTrendArr)->firstWhere('year', $selectedYear)['value'] ?? ($pdrbTrendArr[0]['value'] ?? $kec->pdrb_kapita);
        $pdrbPrev = collect($pdrbTrendArr)->firstWhere('year', $selectedYear - 1)['value'] ?? $pdrbCur;
        $pdrbYoy = $pdrbPrev > 0 ? round((($pdrbCur - $pdrbPrev) / $pdrbPrev) * 100, 2) : 0.0;

        return [
            [
                'id' => "pop_{$kec->id}",
                'name' => "Jumlah Penduduk {$kec->name}",
                'short_name' => "Penduduk {$kec->name}",
                'value' => $popCur,
                'unit' => 'Jiwa',
                'digits' => 0,
                'yoy_change' => $popYoy,
                'trend' => $popTrendArr,
            ],
            [
                'id' => "density_{$kec->id}",
                'name' => 'Kepadatan Penduduk',
                'short_name' => 'Kepadatan Wilayah',
                'value' => $densityVal,
                'unit' => 'Jiwa/Km²',
                'digits' => 0,
                'yoy_change' => $popYoy,
                'trend' => $densityTrend,
            ],
            [
                'id' => "area_{$kec->id}",
                'name' => 'Luas Wilayah Kecamatan',
                'short_name' => 'Luas Wilayah',
                'value' => (float) $kec->area_km2,
                'unit' => 'Km²',
                'digits' => 2,
                'yoy_change' => 0.0,
                'trend' => $areaTrend,
            ],
            [
                'id' => "pdrb_{$kec->id}",
                'name' => 'Estimasi PDRB per Kapita',
                'short_name' => 'PDRB per Kapita',
                'value' => $pdrbCur,
                'unit' => 'Juta Rp',
                'digits' => 2,
                'yoy_change' => $pdrbYoy,
                'trend' => $pdrbTrendArr,
            ],
        ];
    }

    /**
     * Mengambil data indikator sektoral (dengan dukungan filter kecamatan dan tahun).
     */
    public function getSectorIndicator(string $sectorId, int $selectedYear = 2025, string $wilayah = 'kabupaten'): array
    {
        if (! $this->hasDatabaseTables()) {
            $configIndicators = config('statistik.sector_indicators', []);
            if (! isset($configIndicators[$sectorId])) {
                $sectorId = 'kependudukan';
            }
            $res = $configIndicators[$sectorId];
            if ($wilayah !== 'kabupaten') {
                $allKec = config('statistik.kecamatan', []);
                $foundKec = collect($allKec)->firstWhere('id', $wilayah);
                if ($foundKec && isset($foundKec['sector_trends'][$sectorId])) {
                    $kecTrend = $foundKec['sector_trends'][$sectorId];
                    $p = collect($kecTrend)->firstWhere('year', $selectedYear);
                    $res['name'] = "{$res['column']['label']} Kec. {$foundKec['name']}";
                    $res['value'] = $p ? $p['value'] : ($kecTrend[0]['value'] ?? 0);
                    $res['trend'] = $kecTrend;
                    $res['unit'] = $res['column']['unit'];
                    $res['digits'] = $res['column']['digits'] ?? 0;
                    if (isset($res['metadata'])) {
                        $res['metadata']['satuan'] = $res['column']['unit'];
                    }
                }
            }

            return $res;
        }

        $indicator = Indicator::with(['trends' => function ($q) use ($wilayah) {
            $q->where('wilayah', $wilayah)->orderBy('year', 'desc');
        }])->where('id', $sectorId)->first();

        // Fallback ke config jika database belum siap
        if (! $indicator) {
            $configIndicators = config('statistik.sector_indicators', []);
            if (! isset($configIndicators[$sectorId])) {
                $sectorId = 'kependudukan';
            }
            $res = $configIndicators[$sectorId];
            if ($wilayah !== 'kabupaten') {
                $allKec = config('statistik.kecamatan', []);
                $foundKec = collect($allKec)->firstWhere('id', $wilayah);
                if ($foundKec && isset($foundKec['sector_trends'][$sectorId])) {
                    $kecTrend = $foundKec['sector_trends'][$sectorId];
                    $p = collect($kecTrend)->firstWhere('year', $selectedYear);
                    $res['name'] = "{$res['column']['label']} Kec. {$foundKec['name']}";
                    $res['value'] = $p ? $p['value'] : ($kecTrend[0]['value'] ?? 0);
                    $res['trend'] = $kecTrend;
                    $res['unit'] = $res['column']['unit'];
                    $res['digits'] = $res['column']['digits'] ?? 0;
                    if (isset($res['metadata'])) {
                        $res['metadata']['satuan'] = $res['column']['unit'];
                    }
                }
            }

            return $res;
        }

        $trends = $indicator->trends->map(fn ($t) => ['year' => (int) $t->year, 'value' => (float) $t->value])->values()->toArray();

        // Jika trend wilayah kosong (misal kecamatan belum ada trend di db), fallback ke trend kabupaten atau baseline
        if (empty($trends)) {
            $trends = IndicatorTrend::where('indicator_id', $sectorId)
                ->where('wilayah', 'kabupaten')
                ->orderBy('year', 'desc')
                ->get()
                ->map(fn ($t) => ['year' => (int) $t->year, 'value' => (float) $t->value])
                ->values()
                ->toArray();
        }

        $point = collect($trends)->firstWhere('year', $selectedYear);
        $val = $point ? $point['value'] : ($trends[0]['value'] ?? 0);

        // Prev point for yoy
        $prevPoint = collect($trends)->firstWhere('year', $selectedYear - 1);
        $yoy = $prevPoint && $prevPoint['value'] != 0 ? round((($val - $prevPoint['value']) / abs($prevPoint['value'])) * 100, 2) : 0.0;

        $name = $indicator->name;
        $unit = $indicator->unit;
        $digits = $indicator->digits;
        $satuanMetadata = $indicator->metadata_satuan ?: $indicator->unit;

        // Jika wilayah adalah kecamatan, sesuaikan nama, unit, dan desimal agar sesuai data kecamatan
        if ($wilayah !== 'kabupaten') {
            $kec = Kecamatan::find($wilayah);
            if ($kec) {
                $name = "{$indicator->column_label} Kec. {$kec->name}";
                $unit = $indicator->column_unit ?: $indicator->unit;
                $digits = $indicator->column_digits !== null ? $indicator->column_digits : 0;
                $satuanMetadata = $unit;
            }
        }

        return [
            'id' => $indicator->id,
            'name' => $name,
            'short_name' => $indicator->short_name,
            'unit' => $unit,
            'digits' => $digits,
            'value' => $val,
            'yoy_change' => $yoy,
            'trend' => $trends,
            'metadata' => [
                'produsen' => $indicator->metadata_produsen,
                'definisi' => $indicator->metadata_definisi,
                'satuan' => $satuanMetadata,
                'metodologi' => $indicator->metadata_metodologi,
                'jadwal_rilis' => $indicator->metadata_jadwal_rilis,
                'sumber_url' => $indicator->metadata_sumber_url,
            ],
            'column' => [
                'key' => $indicator->column_key,
                'label' => $indicator->column_label,
                'unit' => $indicator->column_unit,
                'digits' => $indicator->column_digits,
            ],
        ];
    }

    /**
     * Mengambil daftar seluruh indikator sektoral terindeks (untuk controller index).
     */
    public function getSectorIndicatorsMap(): array
    {
        $sectors = $this->getSectors();
        $map = [];

        foreach ($sectors as $s) {
            $map[$s['id']] = $this->getSectorIndicator($s['id']);
        }

        return $map;
    }

    /**
     * Mengambil daftar 8 kecamatan dengan nilai terkini sesuai sektor dan tahun terpilih.
     */
    public function getKecamatanList(string $sectorId = 'kependudukan', int $selectedYear = 2025): Collection
    {
        if (! $this->hasDatabaseTables()) {
            $allConfig = config('statistik.kecamatan', []);
            $sectorIndicators = config('statistik.sector_indicators', []);
            $colKey = $sectorIndicators[$sectorId]['column']['key'] ?? 'population';

            return collect($allConfig)->map(function ($k) use ($sectorId, $selectedYear, $colKey) {
                if (isset($k['sector_trends'][$sectorId])) {
                    $p = collect($k['sector_trends'][$sectorId])->firstWhere('year', $selectedYear);
                    $k['current_value'] = $p ? $p['value'] : ($k[$colKey] ?? 0);
                } else {
                    $k['current_value'] = $k[$colKey] ?? 0;
                }

                return $k;
            });
        }

        $kecamatans = Kecamatan::orderBy('order')->get();

        if ($kecamatans->isEmpty()) {
            // Fallback ke config
            $allConfig = config('statistik.kecamatan', []);
            $sectorIndicators = config('statistik.sector_indicators', []);
            $colKey = $sectorIndicators[$sectorId]['column']['key'] ?? 'population';

            return collect($allConfig)->map(function ($k) use ($sectorId, $selectedYear, $colKey) {
                if (isset($k['sector_trends'][$sectorId])) {
                    $p = collect($k['sector_trends'][$sectorId])->firstWhere('year', $selectedYear);
                    $k['current_value'] = $p ? $p['value'] : ($k[$colKey] ?? 0);
                } else {
                    $k['current_value'] = $k[$colKey] ?? 0;
                }

                return $k;
            });
        }

        $indicator = Indicator::find($sectorId);
        $colKey = $indicator ? $indicator->column_key : 'population';

        // Ambil tren kecamatan untuk sektor & tahun ini
        $trends = IndicatorTrend::where('indicator_id', $sectorId)
            ->where('year', $selectedYear)
            ->where('wilayah', '!=', 'kabupaten')
            ->pluck('value', 'wilayah')
            ->toArray();

        return $kecamatans->map(function ($k) use ($colKey, $trends) {
            $val = $trends[$k->id] ?? ($k->{$colKey} ?? 0);

            $arr = $k->toArray();
            $arr['current_value'] = (float) $val;

            return $arr;
        });
    }

    /**
     * Menghapus seluruh cache statistik saat ada perubahan data.
     */
    public function clearCache(): void
    {
        Cache::flush();
    }

    /**
     * Update data indikator & tren tahunannya.
     */
    public function updateIndicator(string $id, array $data, array $yearlyTrends = []): bool
    {
        return DB::transaction(function () use ($id, $data, $yearlyTrends) {
            $indicator = Indicator::findOrFail($id);
            $indicator->update($data);

            if (! empty($yearlyTrends)) {
                foreach ($yearlyTrends as $year => $value) {
                    IndicatorTrend::updateOrCreate(
                        [
                            'indicator_id' => $id,
                            'wilayah' => 'kabupaten',
                            'year' => (int) $year,
                        ],
                        [
                            'value' => (float) $value,
                        ]
                    );
                }
            }

            $this->clearCache();

            return true;
        });
    }

    /**
     * Update data kecamatan dan nilai tren sektoral per tahunnya.
     */
    public function updateKecamatan(string $id, array $data, array $sectorTrends = []): bool
    {
        return DB::transaction(function () use ($id, $data, $sectorTrends) {
            $kecamatan = Kecamatan::findOrFail($id);
            $kecamatan->update($data);

            // Update sector trends if provided: [sectorId => [year => value]]
            if (! empty($sectorTrends)) {
                foreach ($sectorTrends as $secId => $yearValues) {
                    if (is_array($yearValues)) {
                        foreach ($yearValues as $yr => $val) {
                            IndicatorTrend::updateOrCreate(
                                [
                                    'indicator_id' => $secId,
                                    'wilayah' => $id,
                                    'year' => (int) $yr,
                                ],
                                [
                                    'value' => (float) $val,
                                ]
                            );
                        }
                    }
                }
            }

            $this->clearCache();

            return true;
        });
    }

    /**
     * Memproses import file CSV untuk indikator atau kecamatan.
     */
    public function importCsv(string $type, UploadedFile $file): array
    {
        $handle = fopen($file->getRealPath(), 'r');
        if (! $handle) {
            return ['success' => false, 'message' => 'Gagal membuka berkas CSV.'];
        }

        // Handle UTF-8 BOM if present
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle, 1000, ',');
        if (! $header) {
            fclose($handle);

            return ['success' => false, 'message' => 'Berkas CSV kosong atau format header tidak valid.'];
        }

        $header = array_map(fn ($h) => trim(strtolower($h)), $header);
        $importedCount = 0;

        DB::beginTransaction();
        try {
            if ($type === 'indikator') {
                // Expected format: indikator_id, wilayah, tahun, nilai
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    if (empty($row) || count($row) < 4) {
                        continue;
                    }
                    $indId = trim($row[0]);
                    $wil = trim($row[1]) ?: 'kabupaten';
                    $year = (int) trim($row[2]);
                    $val = (float) str_replace(',', '.', trim($row[3]));

                    if (! empty($indId) && $year >= 2000) {
                        IndicatorTrend::updateOrCreate(
                            [
                                'indicator_id' => $indId,
                                'wilayah' => $wil,
                                'year' => $year,
                            ],
                            [
                                'value' => $val,
                            ]
                        );
                        $importedCount++;
                    }
                }
            } elseif ($type === 'kecamatan') {
                // Expected format: kecamatan_id, nama, ibu_kota, luas_km2, kepadatan, penduduk, pdrb_kapita, angkatan_kerja, faskes, sekolah, lahan_sawah, fakir_miskin
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    if (empty($row) || count($row) < 6) {
                        continue;
                    }
                    $kecId = trim($row[0]);
                    if (empty($kecId)) {
                        continue;
                    }

                    $data = [
                        'name' => trim($row[1] ?? ''),
                        'capital' => trim($row[2] ?? ''),
                        'area_km2' => (float) str_replace(',', '.', trim($row[3] ?? '0')),
                        'density' => (float) str_replace(',', '.', trim($row[4] ?? '0')),
                        'population' => (float) str_replace(',', '.', trim($row[5] ?? '0')),
                        'pdrb_kapita' => (float) str_replace(',', '.', trim($row[6] ?? '0')),
                        'angkatan_kerja' => (float) str_replace(',', '.', trim($row[7] ?? '0')),
                        'puskesmas_faskes' => (float) str_replace(',', '.', trim($row[8] ?? '0')),
                        'sekolah_total' => (float) str_replace(',', '.', trim($row[9] ?? '0')),
                        'lahan_tani' => (float) str_replace(',', '.', trim($row[10] ?? '0')),
                        'penerima_bansos' => (float) str_replace(',', '.', trim($row[11] ?? '0')),
                    ];

                    Kecamatan::updateOrCreate(['id' => $kecId], array_filter($data, fn ($v) => $v !== ''));
                    $importedCount++;
                }
            }

            DB::commit();
            fclose($handle);
            $this->clearCache();

            return [
                'success' => true,
                'message' => "Berhasil mengimpor {$importedCount} baris data ke database.",
                'count' => $importedCount,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses CSV: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Menghasilkan teks template CSV untuk diunduh admin.
     */
    public function generateTemplateCsv(string $type): string
    {
        $output = fopen('php://temp', 'r+');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

        if ($type === 'indikator') {
            fputcsv($output, ['indikator_id', 'wilayah', 'tahun', 'nilai']);
            fputcsv($output, ['ipm', 'kabupaten', '2025', '75.02']);
            fputcsv($output, ['kemiskinan', 'kabupaten', '2025', '4.32']);
            fputcsv($output, ['pertumbuhan-ekonomi', 'kabupaten', '2025', '4.42']);
            fputcsv($output, ['tpt', 'kabupaten', '2025', '4.65']);
            fputcsv($output, ['kependudukan', 'sungailiat', '2025', '98420']);
            fputcsv($output, ['kependudukan', 'belinyu', '2025', '50870']);
        } elseif ($type === 'kecamatan') {
            fputcsv($output, ['kecamatan_id', 'nama', 'ibu_kota', 'luas_km2', 'kepadatan', 'penduduk', 'pdrb_kapita', 'angkatan_kerja', 'puskesmas_faskes', 'sekolah_total', 'lahan_tani', 'penerima_bansos']);
            fputcsv($output, ['sungailiat', 'Sungailiat', 'Sungailiat (Ibu Kota)', '147.74', '666', '98420', '80.2', '49100', '19', '65', '0', '15243']);
            fputcsv($output, ['belinyu', 'Belinyu', 'Belinyu', '545.96', '93', '50870', '65.4', '25400', '11', '42', '45', '8912']);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }
}
