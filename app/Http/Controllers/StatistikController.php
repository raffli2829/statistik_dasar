<?php

namespace App\Http\Controllers;

use App\Services\SatuDataService;
use App\Services\StatistikDataService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StatistikController extends Controller
{
    /**
     * Menampilkan halaman sub-modul Statistik Dasar Pemerintah Kabupaten Bangka.
     */
    public function index(Request $request, SatuDataService $satuDataService, StatistikDataService $statistikService)
    {
        $years = $statistikService->getYears();
        $defaultYear = $statistikService->getDefaultYear();
        $selectedYear = (int) $request->get('tahun', $defaultYear);
        if (! in_array($selectedYear, $years)) {
            $selectedYear = $defaultYear;
        }

        $selectedWilayah = $request->get('wilayah', 'kabupaten');
        $selectedSector = $request->get('sektor', 'kependudukan');

        $allKecamatan = config('statistik.kecamatan');
        $sectors = $statistikService->getSectors();
        $sectorIndicators = $statistikService->getSectorIndicatorsMap();

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

        // Tentukan 4 Headline Indicators: Kabupaten vs Kecamatan (dari Database via StatistikDataService)
        $headlineIndicators = $statistikService->getHeadlineIndicators($selectedYear, $selectedWilayah);

        // Tentukan data sektor terpilih: Kabupaten vs Kecamatan (dari Database via StatistikDataService)
        $currentSector = $statistikService->getSectorIndicator($selectedSector, $selectedYear, $selectedWilayah);

        // Hitung nilai kecamatan untuk tabel dari Database
        $kecamatanList = $statistikService->getKecamatanList($selectedSector, $selectedYear);
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
    public function getSectorData(Request $request, string $id, StatistikDataService $statistikService)
    {
        $wilayah = $request->get('wilayah', 'kabupaten');
        $tahun = (int) $request->get('tahun', $statistikService->getDefaultYear());

        $data = $statistikService->getSectorIndicator($id, $tahun, $wilayah);
        if (empty($data)) {
            return response()->json(['error' => 'Sektor tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    /**
     * API JSON untuk data kecamatan.
     */
    public function getKecamatanData(Request $request, StatistikDataService $statistikService)
    {
        $sektor = $request->get('sektor', 'kependudukan');
        $tahun = (int) $request->get('tahun', $statistikService->getDefaultYear());

        $list = $statistikService->getKecamatanList($sektor, $tahun);
        $data = $list->map(function ($k) {
            return [
                'id' => $k['id'],
                'name' => $k['name'],
                'capital' => $k['capital'],
                'value' => round($k['current_value'] ?? 0, 2),
                'area_km2' => $k['area_km2'],
                'density' => $k['density'],
            ];
        });

        return response()->json($data);
    }

    /**
     * Ekspor data kecamatan ke format CSV.
     */
    public function downloadCsv(string $sektor, int $tahun, StatistikDataService $statistikService)
    {
        $currentSector = $statistikService->getSectorIndicator($sektor, $tahun, 'kabupaten');
        $kecamatanList = $statistikService->getKecamatanList($sektor, $tahun);
        $col = $currentSector['column'];

        $filename = "satudata-bangka-{$sektor}-{$tahun}.csv";

        return new StreamedResponse(function () use ($kecamatanList, $currentSector, $col, $tahun) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['Peringkat', 'Kecamatan', 'Ibu Kota Kecamatan', "{$col['label']} ({$col['unit']})", 'Luas Wilayah (Km²)', 'Tahun', 'Wilayah', 'Produsen Data']);

            $rank = 1;
            foreach ($kecamatanList as $k) {
                $val = $k['current_value'] ?? 0;

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
    public function downloadJson(string $sektor, int $tahun, StatistikDataService $statistikService)
    {
        $currentSector = $statistikService->getSectorIndicator($sektor, $tahun, 'kabupaten');
        $kecamatanList = $statistikService->getKecamatanList($sektor, $tahun);
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
            'data_kecamatan' => $kecamatanList->map(function ($k, $idx) use ($col) {
                return [
                    'peringkat' => $idx + 1,
                    'nama_kecamatan' => $k['name'],
                    'ibu_kota' => $k['capital'],
                    'nilai' => $k['current_value'] ?? 0,
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
