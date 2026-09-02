<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StatistikController extends Controller
{
    /**
     * Menampilkan halaman sub-modul Statistik Dasar Pemerintah Kabupaten Bangka.
     */
    public function index(Request $request)
    {
        $years = config('statistik.years');
        $defaultYear = config('statistik.default_year');
        $selectedYear = (int) $request->get('tahun', $defaultYear);
        if (!in_array($selectedYear, $years)) {
            $selectedYear = $defaultYear;
        }

        $selectedWilayah = $request->get('wilayah', 'kabupaten');
        $selectedSector = $request->get('sektor', 'kependudukan');

        $headlineIndicators = config('statistik.headline_indicators');
        $sectors = config('statistik.sectors');
        $sectorIndicators = config('statistik.sector_indicators');
        $allKecamatan = config('statistik.kecamatan');
        $featuredDatasets = config('statistik.featured_datasets');

        if (!isset($sectorIndicators[$selectedSector])) {
            $selectedSector = 'kependudukan';
        }

        $currentSector = $sectorIndicators[$selectedSector];

        // Hitung faktor skala tahun untuk simulasi seri tahunan kecamatan
        $yearIndex = array_search($selectedYear, $years);
        if ($yearIndex === false) {
            $yearIndex = count($years) - 1;
        }
        $yearFactor = 1 - (count($years) - 1 - $yearIndex) * 0.02;

        // Filter kecamatan
        $kecamatanList = collect($allKecamatan)->map(function ($k) use ($currentSector, $yearFactor) {
            $colKey = $currentSector['column']['key'];
            $baseVal = $k[$colKey] ?? 0;
            $k['current_value'] = $baseVal * $yearFactor;
            return $k;
        });

        if ($selectedWilayah !== 'kabupaten') {
            $kecamatanList = $kecamatanList->filter(function ($k) use ($selectedWilayah) {
                return $k['id'] === $selectedWilayah;
            });
        }

        $maxVal = $kecamatanList->max('current_value') ?: 1;

        return view('statistik.index', [
            'years' => $years,
            'selectedYear' => $selectedYear,
            'selectedWilayah' => $selectedWilayah,
            'selectedSector' => $selectedSector,
            'headlineIndicators' => $headlineIndicators,
            'sectors' => $sectors,
            'currentSector' => $currentSector,
            'sectorIndicators' => $sectorIndicators,
            'kecamatanList' => $kecamatanList->values(),
            'allKecamatan' => $allKecamatan,
            'maxVal' => $maxVal,
            'featuredDatasets' => $featuredDatasets,
        ]);
    }

    /**
     * API JSON untuk data tren sektoral (digunakan Chart.js).
     */
    public function getSectorData(string $id)
    {
        $sectorIndicators = config('statistik.sector_indicators');
        if (!isset($sectorIndicators[$id])) {
            return response()->json(['error' => 'Sektor tidak ditemukan'], 404);
        }

        return response()->json($sectorIndicators[$id]);
    }

    /**
     * API JSON untuk data kecamatan.
     */
    public function getKecamatanData(Request $request)
    {
        $allKecamatan = config('statistik.kecamatan');
        $sektor = $request->get('sektor', 'kependudukan');
        $tahun = (int) $request->get('tahun', config('statistik.default_year'));
        $years = config('statistik.years');

        $yearIndex = array_search($tahun, $years);
        if ($yearIndex === false) {
            $yearIndex = count($years) - 1;
        }
        $yearFactor = 1 - (count($years) - 1 - $yearIndex) * 0.02;

        $sectorIndicators = config('statistik.sector_indicators');
        $colKey = $sectorIndicators[$sektor]['column']['key'] ?? 'population';

        $data = collect($allKecamatan)->map(function ($k) use ($colKey, $yearFactor) {
            $baseVal = $k[$colKey] ?? 0;
            return [
                'id' => $k['id'],
                'name' => $k['name'],
                'capital' => $k['capital'],
                'value' => round($baseVal * $yearFactor, 2),
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

        return new StreamedResponse(function () use ($allKecamatan, $currentSector, $col, $tahun) {
            $handle = fopen('php://output', 'w');
            // Add BOM for Excel UTF-8 compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['Peringkat', 'Kecamatan', 'Ibu Kota Kecamatan', "{$col['label']} ({$col['unit']})", 'Luas Wilayah (Km²)', 'Tahun', 'Wilayah', 'Produsen Data']);

            $rank = 1;
            foreach ($allKecamatan as $k) {
                $val = $k[$col['key']] ?? 0;
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
            'data_kecamatan' => collect($allKecamatan)->map(function ($k, $idx) use ($col) {
                return [
                    'peringkat' => $idx + 1,
                    'nama_kecamatan' => $k['name'],
                    'ibu_kota' => $k['capital'],
                    'nilai' => $k[$col['key']] ?? 0,
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
