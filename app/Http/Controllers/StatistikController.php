<?php

namespace App\Http\Controllers;

use App\Services\SatuDataService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StatistikController extends Controller
{
    /**
     * Menampilkan halaman sub-modul Statistik Dasar Pemerintah Kabupaten Bangka.
     */
    public function index(Request $request, SatuDataService $satuDataService)
    {
        $years = config('statistik.years');
        $defaultYear = config('statistik.default_year');
        $selectedYear = (int) $request->get('tahun', $defaultYear);
        if (! in_array($selectedYear, $years)) {
            $selectedYear = $defaultYear;
        }

        $selectedWilayah = $request->get('wilayah', 'kabupaten');
        $selectedSector = $request->get('sektor', 'kependudukan');

        $allKecamatan = config('statistik.kecamatan');
        $sectors = config('statistik.sectors');
        $sectorIndicators = config('statistik.sector_indicators');

        // Ambil dataset riil live langsung dari CKAN API satudata.bangka.go.id sesuai tahun terpilih
        $featuredDatasets = $satuDataService->getDatasets(6, (string) $selectedYear);
        if (empty($featuredDatasets)) {
            $featuredDatasets = $satuDataService->getDatasets(6);
        }
        $portalStats = $satuDataService->getPortalStats();

        if (! isset($sectorIndicators[$selectedSector])) {
            $selectedSector = 'kependudukan';
        }

        // Cari kecamatan terpilih jika ada
        $activeKecamatan = null;
        if ($selectedWilayah !== 'kabupaten') {
            $found = collect($allKecamatan)->firstWhere('id', $selectedWilayah);
            if ($found) {
                $activeKecamatan = $found;
            } else {
                $selectedWilayah = 'kabupaten';
            }
        }

        // Tentukan 4 Headline Indicators: Kabupaten vs Kecamatan
        if ($activeKecamatan && isset($activeKecamatan['kpi_cards'])) {
            $headlineIndicators = $activeKecamatan['kpi_cards'];
        } else {
            $headlineIndicators = config('statistik.headline_indicators');
        }

        // Tentukan data sektor terpilih: Kabupaten vs Kecamatan
        $currentSector = $sectorIndicators[$selectedSector];
        if ($activeKecamatan && isset($activeKecamatan['sector_trends'][$selectedSector])) {
            $kecTrend = $activeKecamatan['sector_trends'][$selectedSector];
            // cari value tahun terpilih
            $trendPoint = collect($kecTrend)->firstWhere('year', $selectedYear);
            $val = $trendPoint ? $trendPoint['value'] : ($kecTrend[0]['value'] ?? 0);

            $currentSector['name'] = "{$currentSector['column']['label']} Kec. {$activeKecamatan['name']}";
            $currentSector['value'] = $val;
            $currentSector['trend'] = $kecTrend;
            $currentSector['unit'] = $currentSector['column']['unit'];
            $currentSector['digits'] = $currentSector['column']['digits'] ?? 0;
            if (isset($currentSector['metadata'])) {
                $currentSector['metadata']['satuan'] = $currentSector['column']['unit'];
            }
        } else {
            $currentSector['digits'] = $currentSector['digits'] ?? ($currentSector['unit'] === '%' || $currentSector['unit'] === 'Poin' || $currentSector['unit'] === 'Tahun' || str_contains($currentSector['unit'], 'Juta') ? 2 : 0);
        }

        // Hitung nilai kecamatan untuk tabel
        $kecamatanList = collect($allKecamatan)->map(function ($k) use ($selectedSector, $selectedYear, $sectorIndicators) {
            $colKey = $sectorIndicators[$selectedSector]['column']['key'];

            // Ambil dari sector_trends jika ada
            if (isset($k['sector_trends'][$selectedSector])) {
                $p = collect($k['sector_trends'][$selectedSector])->firstWhere('year', $selectedYear);
                $k['current_value'] = $p ? $p['value'] : ($k[$colKey] ?? 0);
            } else {
                $k['current_value'] = $k[$colKey] ?? 0;
            }

            return $k;
        });

        $maxVal = $kecamatanList->max('current_value') ?: 1;

        return view('statistik.index', [
            'years' => $years,
            'selectedYear' => $selectedYear,
            'selectedWilayah' => $selectedWilayah,
            'activeKecamatan' => $activeKecamatan,
            'selectedSector' => $selectedSector,
            'headlineIndicators' => $headlineIndicators,
            'sectors' => $sectors,
            'currentSector' => $currentSector,
            'sectorIndicators' => $sectorIndicators,
            'kecamatanList' => $kecamatanList->values(),
            'allKecamatan' => $allKecamatan,
            'maxVal' => $maxVal,
            'featuredDatasets' => $featuredDatasets,
            'portalStats' => $portalStats,
        ]);
    }

    /**
     * API JSON untuk data tren sektoral (mendukung filter kecamatan & tahun).
     */
    public function getSectorData(Request $request, string $id)
    {
        $sectorIndicators = config('statistik.sector_indicators');
        if (! isset($sectorIndicators[$id])) {
            return response()->json(['error' => 'Sektor tidak ditemukan'], 404);
        }

        $data = $sectorIndicators[$id];
        $wilayah = $request->get('wilayah', 'kabupaten');
        $tahun = (int) $request->get('tahun', config('statistik.default_year'));

        if ($wilayah !== 'kabupaten') {
            $allKecamatan = config('statistik.kecamatan');
            $kec = collect($allKecamatan)->firstWhere('id', $wilayah);
            if ($kec && isset($kec['sector_trends'][$id])) {
                $data['name'] = "{$data['column']['label']} Kec. {$kec['name']}";
                $data['trend'] = $kec['sector_trends'][$id];
                $point = collect($data['trend'])->firstWhere('year', $tahun);
                $data['value'] = $point ? $point['value'] : ($data['trend'][0]['value'] ?? 0);
                $data['kecamatan'] = $kec['name'];
                $data['unit'] = $data['column']['unit'];
                $data['digits'] = $data['column']['digits'] ?? 0;
                if (isset($data['metadata'])) {
                    $data['metadata']['satuan'] = $data['column']['unit'];
                }
            }
        } else {
            $data['digits'] = $data['digits'] ?? ($data['unit'] === '%' || $data['unit'] === 'Poin' || $data['unit'] === 'Tahun' || str_contains($data['unit'], 'Juta') ? 2 : 0);
        }

        return response()->json($data);
    }

    /**
     * API JSON untuk data kecamatan.
     */
    public function getKecamatanData(Request $request)
    {
        $allKecamatan = config('statistik.kecamatan');
        $sektor = $request->get('sektor', 'kependudukan');
        $tahun = (int) $request->get('tahun', config('statistik.default_year'));
        $sectorIndicators = config('statistik.sector_indicators');
        $colKey = $sectorIndicators[$sektor]['column']['key'] ?? 'population';

        $data = collect($allKecamatan)->map(function ($k) use ($sektor, $tahun, $colKey) {
            $val = $k[$colKey] ?? 0;
            if (isset($k['sector_trends'][$sektor])) {
                $p = collect($k['sector_trends'][$sektor])->firstWhere('year', $tahun);
                if ($p) {
                    $val = $p['value'];
                }
            }

            return [
                'id' => $k['id'],
                'name' => $k['name'],
                'capital' => $k['capital'],
                'value' => round($val, 2),
                'area_km2' => $k['area_km2'],
                'density' => $k['density'],
            ];
        });

        return response()->json($data);
    }

    /**
     * Ekspor data kecamatan ke format CSV.
     */
    public function downloadCsv(string $sektor, int $tahun)
    {
        $sectorIndicators = config('statistik.sector_indicators');
        $currentSector = $sectorIndicators[$sektor] ?? $sectorIndicators['kependudukan'];
        $allKecamatan = config('statistik.kecamatan');
        $col = $currentSector['column'];

        $filename = "satudata-bangka-{$sektor}-{$tahun}.csv";

        return new StreamedResponse(function () use ($allKecamatan, $currentSector, $col, $tahun, $sektor) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['Peringkat', 'Kecamatan', 'Ibu Kota Kecamatan', "{$col['label']} ({$col['unit']})", 'Luas Wilayah (Km²)', 'Tahun', 'Wilayah', 'Produsen Data']);

            $rank = 1;
            foreach ($allKecamatan as $k) {
                $val = $k[$col['key']] ?? 0;
                if (isset($k['sector_trends'][$sektor])) {
                    $p = collect($k['sector_trends'][$sektor])->firstWhere('year', $tahun);
                    if ($p) {
                        $val = $p['value'];
                    }
                }

                fputcsv($handle, [
                    $rank++,
                    $k['name'],
                    $k['capital'],
                    number_format($val, $col['digits'] ?? 0, ',', '.'),
                    number_format($k['area_km2'], 2, ',', '.'),
                    $tahun,
                    'Kabupaten Bangka',
                    $currentSector['metadata']['produsen'] ?? 'BPS Kabupaten Bangka',
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Ekspor data lengkap ke format JSON.
     */
    public function downloadJson(string $sektor, int $tahun)
    {
        $sectorIndicators = config('statistik.sector_indicators');
        $currentSector = $sectorIndicators[$sektor] ?? $sectorIndicators['kependudukan'];
        $allKecamatan = config('statistik.kecamatan');
        $col = $currentSector['column'];

        $payload = [
            'portal' => 'Satu Data Kabupaten Bangka',
            'halaman' => 'Statistik Dasar (https://satudata.bangka.go.id/statistik-dasar)',
            'sumber_resmi' => 'Badan Pusat Statistik (BPS) Kabupaten Bangka',
            'sektor' => $sektor,
            'indikator' => $currentSector['name'],
            'satuan' => $currentSector['unit'],
            'tahun' => $tahun,
            'metadata' => $currentSector['metadata'],
            'tanggal_unduh' => now()->toIso8601String(),
            'data_kecamatan' => collect($allKecamatan)->map(function ($k, $idx) use ($col, $sektor, $tahun) {
                $val = $k[$col['key']] ?? 0;
                if (isset($k['sector_trends'][$sektor])) {
                    $p = collect($k['sector_trends'][$sektor])->firstWhere('year', $tahun);
                    if ($p) {
                        $val = $p['value'];
                    }
                }

                return [
                    'peringkat' => $idx + 1,
                    'nama_kecamatan' => $k['name'],
                    'ibu_kota' => $k['capital'],
                    'nilai' => $val,
                    'satuan' => $col['unit'],
                    'luas_wilayah_km2' => $k['area_km2'],
                ];
            }),
        ];

        return response()->json($payload, 200, [
            'Content-Disposition' => "attachment; filename=\"satudata-bangka-{$sektor}-{$tahun}.json\"",
        ]);
    }
}
