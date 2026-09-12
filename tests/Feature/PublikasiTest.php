<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublikasiTest extends TestCase
{
    /**
     * Uji URL publikasi utama dialihkan ke berita.
     */
    public function test_publikasi_index_redirects_to_berita(): void
    {
        $response = $this->get('/publikasi');
        $response->assertRedirect('/publikasi/berita');
    }

    /**
     * Uji halaman berita publikasi dapat diakses.
     */
    public function test_halaman_berita_dapat_diakses(): void
    {
        $response = $this->get('/publikasi/berita');
        $response->assertStatus(200);
        $response->assertSee('Berita Statistik Daerah');
        $response->assertSee('BERITA UTAMA TERKINI');
    }

    /**
     * Uji halaman artikel dapat diakses.
     */
    public function test_halaman_artikel_dapat_diakses(): void
    {
        $response = $this->get('/publikasi/artikel');
        $response->assertStatus(200);
        $response->assertSee('Artikel & Analisis Data', false);
        $response->assertSee('Tersimpan');
    }

    /**
     * Uji halaman infografis dapat diakses.
     */
    public function test_halaman_infografis_dapat_diakses(): void
    {
        $response = $this->get('/publikasi/infografis');
        $response->assertStatus(200);
        $response->assertSee('Galeri Infografis Statistik');
    }

    /**
     * Uji halaman statistik sektoral OPD dapat diakses.
     */
    public function test_halaman_statistik_sektoral_opd_dapat_diakses(): void
    {
        $response = $this->get('/publikasi/statistik-sektoral-opd');
        $response->assertStatus(200);
        $response->assertSee('Statistik Sektoral OPD');
        $response->assertSee('OPD Produsen Data Aktif');
    }

    /**
     * Uji halaman statistik sektoral Kabupaten dapat diakses.
     */
    public function test_halaman_statistik_sektoral_kabupaten_dapat_diakses(): void
    {
        $response = $this->get('/publikasi/statistik-sektoral-kabupaten');
        $response->assertStatus(200);
        $response->assertSee('Statistik Sektoral Kabupaten Bangka');
        $response->assertSee('Ekspor Semua Indikator');
    }
}
