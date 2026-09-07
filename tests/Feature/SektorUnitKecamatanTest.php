<?php

namespace Tests\Feature;

use Tests\TestCase;

class SektorUnitKecamatanTest extends TestCase
{
    /**
     * Pastikan indikator sektor pada level kabupaten menggunakan satuan dan desimal agregat.
     */
    public function test_kabupaten_sector_indicators_have_proper_units_and_digits(): void
    {
        $resKerja = $this->getJson('/api/sektor/ketenagakerjaan?wilayah=kabupaten');
        $resKerja->assertStatus(200)
            ->assertJson([
                'unit' => '%',
                'digits' => 2,
            ]);

        $resSehat = $this->getJson('/api/sektor/kesehatan?wilayah=kabupaten');
        $resSehat->assertStatus(200)
            ->assertJson([
                'unit' => 'Tahun',
                'digits' => 2,
            ]);

        $resDidik = $this->getJson('/api/sektor/pendidikan?wilayah=kabupaten');
        $resDidik->assertStatus(200)
            ->assertJson([
                'unit' => 'Tahun',
                'digits' => 2,
            ]);

        $resTani = $this->getJson('/api/sektor/pertanian?wilayah=kabupaten');
        $resTani->assertStatus(200)
            ->assertJson([
                'unit' => 'Hektar',
            ]);

        $resSosial = $this->getJson('/api/sektor/sosial?wilayah=kabupaten');
        $resSosial->assertStatus(200)
            ->assertJson([
                'unit' => 'Keluarga',
                'digits' => 0,
            ]);
    }

    /**
     * Pastikan indikator sektor menyesuaikan satuan (unit) dan desimal (digits) secara dinamis ketika filter kecamatan aktif.
     */
    public function test_kecamatan_sector_indicators_dynamically_adjust_units_and_digits(): void
    {
        // Ketenagakerjaan: % di kabupaten -> Jiwa di kecamatan (digits 0)
        $resKerja = $this->getJson('/api/sektor/ketenagakerjaan?wilayah=sungailiat');
        $resKerja->assertStatus(200)
            ->assertJson([
                'name' => 'Angkatan Kerja Aktif Kec. Sungailiat',
                'unit' => 'Jiwa',
                'digits' => 0,
                'metadata' => [
                    'satuan' => 'Jiwa',
                ],
            ]);

        // Kesehatan: Tahun di kabupaten -> Unit di kecamatan (digits 0)
        $resSehat = $this->getJson('/api/sektor/kesehatan?wilayah=sungailiat');
        $resSehat->assertStatus(200)
            ->assertJson([
                'name' => 'Fasilitas Kesehatan Aktif Kec. Sungailiat',
                'unit' => 'Unit',
                'digits' => 0,
                'metadata' => [
                    'satuan' => 'Unit',
                ],
            ]);

        // Pendidikan: Tahun di kabupaten -> Unit di kecamatan (digits 0)
        $resDidik = $this->getJson('/api/sektor/pendidikan?wilayah=sungailiat');
        $resDidik->assertStatus(200)
            ->assertJson([
                'name' => 'Sekolah (SD/SMP/SMA) Kec. Sungailiat',
                'unit' => 'Unit',
                'digits' => 0,
                'metadata' => [
                    'satuan' => 'Unit',
                ],
            ]);

        // Pertanian: Luas Lahan Sawah Hektar di kecamatan (digits 0)
        $resTani = $this->getJson('/api/sektor/pertanian?wilayah=sungailiat');
        $resTani->assertStatus(200)
            ->assertJson([
                'name' => 'Luas Lahan Sawah Kec. Sungailiat',
                'unit' => 'Hektar',
                'digits' => 0,
            ]);

        // Sosial: Keluarga Fakir Miskin di kecamatan (digits 0)
        $resSosial = $this->getJson('/api/sektor/sosial?wilayah=sungailiat');
        $resSosial->assertStatus(200)
            ->assertJson([
                'name' => 'Keluarga Fakir Miskin Kec. Sungailiat',
                'unit' => 'Keluarga',
                'digits' => 0,
            ]);
    }

    /**
     * Pastikan view blade merender satuan dan format angka yang tepat tanpa format desimal salah (,00).
     */
    public function test_web_page_renders_adjusted_units_for_selected_kecamatan(): void
    {
        // 1. Ketenagakerjaan di Sungailiat: 48.200 Jiwa (bukan 48.200,00 %)
        $res = $this->get('/?wilayah=sungailiat&sektor=ketenagakerjaan&tahun=2024');
        $res->assertStatus(200)
            ->assertSee('Satuan: <span id="chart-unit" class="font-semibold text-primary">Jiwa</span>', false)
            ->assertSee('Thn 2024: 48.200 Jiwa', false)
            ->assertDontSee('48.200,00 %', false);

        // 2. Kesehatan di Sungailiat: 18 Unit (bukan 18,00 Tahun)
        $res = $this->get('/?wilayah=sungailiat&sektor=kesehatan&tahun=2024');
        $res->assertStatus(200)
            ->assertSee('Satuan: <span id="chart-unit" class="font-semibold text-primary">Unit</span>', false)
            ->assertSee('Thn 2024: 18 Unit', false)
            ->assertDontSee('18,00 Tahun', false);

        // 3. Pendidikan di Sungailiat: 64 Unit (bukan 64,00 Tahun)
        $res = $this->get('/?wilayah=sungailiat&sektor=pendidikan&tahun=2024');
        $res->assertStatus(200)
            ->assertSee('Satuan: <span id="chart-unit" class="font-semibold text-primary">Unit</span>', false)
            ->assertSee('Thn 2024: 64 Unit', false)
            ->assertDontSee('64,00 Tahun', false);

        // 4. Pertanian di Sungailiat: 12 Hektar (bukan 12,00 Hektar)
        $res = $this->get('/?wilayah=sungailiat&sektor=pertanian&tahun=2024');
        $res->assertStatus(200)
            ->assertSee('Satuan: <span id="chart-unit" class="font-semibold text-primary">Hektar</span>', false)
            ->assertSee('Thn 2024: 12 Hektar', false);

        // 5. Sosial di Sungailiat: 15.243 Keluarga (bukan 15.243,00 Keluarga)
        $res = $this->get('/?wilayah=sungailiat&sektor=sosial&tahun=2024');
        $res->assertStatus(200)
            ->assertSee('Satuan: <span id="chart-unit" class="font-semibold text-primary">Keluarga</span>', false)
            ->assertSee('Thn 2024: 15.243 Keluarga', false)
            ->assertDontSee('15.243,00', false);
    }
}
