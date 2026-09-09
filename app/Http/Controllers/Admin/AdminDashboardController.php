<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Indicator;
use App\Models\IndicatorTrend;
use App\Models\Kecamatan;
use App\Services\SatuDataService;
use App\Services\StatistikDataService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Halaman beranda dashboard admin.
     */
    public function dashboard(StatistikDataService $service, SatuDataService $satuDataService)
    {
        $indicatorCount = Indicator::count();
        $kecamatanCount = Kecamatan::count();
        $trendCount = IndicatorTrend::count();
        $portalStats = $satuDataService->getPortalStats();
        $headlineIndicators = $service->getHeadlineIndicators($service->getDefaultYear());
        $kecamatanList = $service->getKecamatanList('kependudukan', $service->getDefaultYear());

        return view('admin.dashboard', compact(
            'indicatorCount',
            'kecamatanCount',
            'trendCount',
            'portalStats',
            'headlineIndicators',
            'kecamatanList'
        ));
    }

    /**
     * Menampilkan daftar seluruh indikator.
     */
    public function indicators(StatistikDataService $service)
    {
        $headlines = Indicator::with('trends')
            ->where('category', 'headline')
            ->orderBy('order')
            ->get();

        $sectors = Indicator::with('trends')
            ->where('category', 'sector')
            ->orderBy('order')
            ->get();

        $years = $service->getYears();
        $defaultYear = $service->getDefaultYear();

        return view('admin.indicators.index', compact('headlines', 'sectors', 'years', 'defaultYear'));
    }

    /**
     * Form edit indikator dan tren tahunannya.
     */
    public function editIndicator(string $id, StatistikDataService $service)
    {
        $indicator = Indicator::with('trends')->findOrFail($id);
        $years = $service->getYears();

        // Ambil nilai per tahun untuk wilayah kabupaten
        $yearValues = [];
        foreach ($years as $yr) {
            $yearValues[$yr] = $indicator->getValueForYear($yr, 'kabupaten');
        }

        return view('admin.indicators.edit', compact('indicator', 'years', 'yearValues'));
    }

    /**
     * Simpan pembaruan indikator dan tren tahunannya.
     */
    public function updateIndicator(Request $request, string $id, StatistikDataService $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:100'],
            'unit' => ['required', 'string', 'max:50'],
            'digits' => ['required', 'integer', 'min:0', 'max:4'],
            'lower_is_better' => ['nullable', 'boolean'],
            'metadata_produsen' => ['nullable', 'string', 'max:255'],
            'metadata_definisi' => ['nullable', 'string'],
            'metadata_satuan' => ['nullable', 'string', 'max:100'],
            'metadata_metodologi' => ['nullable', 'string'],
            'metadata_jadwal_rilis' => ['nullable', 'string', 'max:100'],
            'metadata_sumber_url' => ['nullable', 'string', 'max:255'],
            'trends' => ['nullable', 'array'],
            'trends.*' => ['nullable', 'numeric'],
        ]);

        $indicatorData = [
            'name' => $validated['name'],
            'short_name' => $validated['short_name'],
            'unit' => $validated['unit'],
            'digits' => $validated['digits'],
            'lower_is_better' => $request->boolean('lower_is_better'),
            'metadata_produsen' => $validated['metadata_produsen'] ?? null,
            'metadata_definisi' => $validated['metadata_definisi'] ?? null,
            'metadata_satuan' => $validated['metadata_satuan'] ?? null,
            'metadata_metodologi' => $validated['metadata_metodologi'] ?? null,
            'metadata_jadwal_rilis' => $validated['metadata_jadwal_rilis'] ?? null,
            'metadata_sumber_url' => $validated['metadata_sumber_url'] ?? null,
        ];

        $yearlyTrends = $request->input('trends', []);

        $service->updateIndicator($id, $indicatorData, $yearlyTrends);

        return redirect()->route('admin.indicators')
            ->with('success', "Indikator '{$validated['name']}' berhasil diperbarui.");
    }

    /**
     * Menampilkan daftar 8 kecamatan.
     */
    public function kecamatan(StatistikDataService $service)
    {
        $kecamatans = Kecamatan::orderBy('order')->get();
        $defaultYear = $service->getDefaultYear();

        return view('admin.kecamatan.index', compact('kecamatans', 'defaultYear'));
    }

    /**
     * Form edit data kecamatan.
     */
    public function editKecamatan(string $id, StatistikDataService $service)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $years = $service->getYears();
        $sectors = $service->getSectors();

        // Ambil nilai per sektor dan per tahun untuk kecamatan ini
        $sectorTrends = [];
        foreach ($sectors as $sec) {
            $sectorTrends[$sec['id']] = [];
            foreach ($years as $yr) {
                $point = IndicatorTrend::where('indicator_id', $sec['id'])
                    ->where('wilayah', $id)
                    ->where('year', $yr)
                    ->first();
                $sectorTrends[$sec['id']][$yr] = $point ? $point->value : null;
            }
        }

        return view('admin.kecamatan.edit', compact('kecamatan', 'years', 'sectors', 'sectorTrends'));
    }

    /**
     * Simpan pembaruan data kecamatan.
     */
    public function updateKecamatan(Request $request, string $id, StatistikDataService $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'capital' => ['required', 'string', 'max:100'],
            'area_km2' => ['required', 'numeric', 'min:0'],
            'density' => ['required', 'numeric', 'min:0'],
            'population' => ['required', 'numeric', 'min:0'],
            'pdrb_kapita' => ['nullable', 'numeric', 'min:0'],
            'angkatan_kerja' => ['nullable', 'numeric', 'min:0'],
            'puskesmas_faskes' => ['nullable', 'numeric', 'min:0'],
            'sekolah_total' => ['nullable', 'numeric', 'min:0'],
            'lahan_tani' => ['nullable', 'numeric', 'min:0'],
            'penerima_bansos' => ['nullable', 'numeric', 'min:0'],
            'sector_trends' => ['nullable', 'array'],
        ]);

        $kecData = [
            'name' => $validated['name'],
            'capital' => $validated['capital'],
            'area_km2' => $validated['area_km2'],
            'density' => $validated['density'],
            'population' => $validated['population'],
            'pdrb_kapita' => $validated['pdrb_kapita'] ?? 0,
            'angkatan_kerja' => $validated['angkatan_kerja'] ?? 0,
            'puskesmas_faskes' => $validated['puskesmas_faskes'] ?? 0,
            'sekolah_total' => $validated['sekolah_total'] ?? 0,
            'lahan_tani' => $validated['lahan_tani'] ?? 0,
            'penerima_bansos' => $validated['penerima_bansos'] ?? 0,
        ];

        $sectorTrends = $request->input('sector_trends', []);

        $service->updateKecamatan($id, $kecData, $sectorTrends);

        return redirect()->route('admin.kecamatan')
            ->with('success', "Data Kecamatan '{$validated['name']}' berhasil diperbarui.");
    }

    /**
     * Halaman manajemen import CSV dan sinkronisasi API.
     */
    public function importExport()
    {
        return view('admin.import.index');
    }

    /**
     * Memproses upload berkas CSV.
     */
    public function processImport(Request $request, StatistikDataService $service)
    {
        $request->validate([
            'type' => ['required', 'in:indikator,kecamatan'],
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ]);

        $result = $service->importCsv($request->input('type'), $request->file('csv_file'));

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->withErrors(['csv_file' => $result['message']]);
    }

    /**
     * Unduh template berkas CSV.
     */
    public function downloadTemplate(string $type, StatistikDataService $service)
    {
        if (! in_array($type, ['indikator', 'kecamatan'])) {
            abort(404);
        }

        $csv = $service->generateTemplateCsv($type);
        $filename = "template_import_{$type}_bangka.csv";

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Memicu sinkronisasi langsung ke CKAN API Satu Data Bangka.
     */
    public function syncApi(SatuDataService $satuDataService, StatistikDataService $service)
    {
        $service->clearCache();

        // Refresh API cache
        $stats = $satuDataService->getPortalStats();
        $datasets = $satuDataService->getDatasets(6);

        return back()->with('success', "Sinkronisasi CKAN API Satu Data Bangka berhasil. Total {$stats['total_datasets']} dataset terhubung aktif.");
    }
}
