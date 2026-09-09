<?php

namespace Tests\Feature;

use App\Models\Kecamatan;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\StatistikDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminUserSeeder::class);
        $this->seed(StatistikDatabaseSeeder::class);
    }

    /**
     * Guest dilarang mengakses halaman admin tanpa login.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');

        $resInd = $this->get('/admin/indikator');
        $resInd->assertRedirect('/admin/login');
    }

    /**
     * Halaman login admin dapat dimuat.
     */
    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200)
            ->assertSee('Panel Admin Statistik')
            ->assertSee('admin@bangka.go.id');
    }

    /**
     * Admin berhasil login dengan kredensial yang valid.
     */
    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@bangka.go.id',
            'password' => 'adminbangka2025',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    /**
     * Login gagal jika kredensial salah.
     */
    public function test_login_fails_with_invalid_password(): void
    {
        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'admin@bangka.go.id',
            'password' => 'passwordsalah',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Admin dapat melihat dashboard setelah login.
     */
    public function test_admin_can_view_dashboard(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200)
            ->assertSee('Dashboard Manajemen Data')
            ->assertSee('Indikator Makro Utama');
    }

    /**
     * Admin dapat melihat daftar indikator dan membukanya untuk diedit.
     */
    public function test_admin_can_view_and_edit_indicator(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->get('/admin/indikator');
        $response->assertStatus(200)
            ->assertSee('Indeks Pembangunan Manusia (IPM)')
            ->assertSee('Persentase Penduduk Miskin');

        $editRes = $this->actingAs($admin)->get('/admin/indikator/ipm/edit');
        $editRes->assertStatus(200)
            ->assertSee('Indeks Pembangunan Manusia (IPM)')
            ->assertSee('Nilai Tren Historis');
    }

    /**
     * Admin dapat memperbarui indikator dan perubahan langsung tercermin pada database dan halaman publik.
     */
    public function test_admin_can_update_indicator_and_changes_appear_on_public_page(): void
    {
        $admin = User::first();

        $updateData = [
            'name' => 'Indeks Pembangunan Manusia (IPM) Bangka Hebat',
            'short_name' => 'IPM Bangka Baru',
            'unit' => 'Poin',
            'digits' => 2,
            'metadata_produsen' => 'BPS Kabupaten Bangka Terkini',
            'trends' => [
                '2025' => 78.88,
                '2024' => 77.50,
            ],
        ];

        $res = $this->actingAs($admin)->post('/admin/indikator/ipm/update', $updateData);
        $res->assertRedirect('/admin/indikator');

        // Pastikan tersimpan di DB
        $this->assertDatabaseHas('indicators', [
            'id' => 'ipm',
            'name' => 'Indeks Pembangunan Manusia (IPM) Bangka Hebat',
        ]);

        $this->assertDatabaseHas('indicator_trends', [
            'indicator_id' => 'ipm',
            'year' => 2025,
            'value' => 78.88,
        ]);

        // Pastikan langsung terlihat di halaman publik
        $publicRes = $this->get('/?tahun=2025');
        $publicRes->assertStatus(200)
            ->assertSee('78,88');
    }

    /**
     * Admin dapat memperbarui data kecamatan.
     */
    public function test_admin_can_update_kecamatan_data(): void
    {
        $admin = User::first();

        $updateData = [
            'name' => 'Sungailiat Kota Bahari',
            'capital' => 'Sungailiat Pusat',
            'area_km2' => 150.25,
            'density' => 680,
            'population' => 99999,
        ];

        $res = $this->actingAs($admin)->post('/admin/kecamatan/sungailiat/update', $updateData);
        $res->assertRedirect('/admin/kecamatan');

        $this->assertDatabaseHas('kecamatans', [
            'id' => 'sungailiat',
            'name' => 'Sungailiat Kota Bahari',
            'population' => 99999,
        ]);
    }

    /**
     * Admin dapat mengunduh berkas template CSV.
     */
    public function test_admin_can_download_csv_templates(): void
    {
        $admin = User::first();

        $resInd = $this->actingAs($admin)->get('/admin/template/indikator');
        $resInd->assertStatus(200);
        $this->assertStringContainsString('text/csv', $resInd->headers->get('content-type'));
        $this->assertStringContainsString('indikator_id', $resInd->getContent());

        $resKec = $this->actingAs($admin)->get('/admin/template/kecamatan');
        $resKec->assertStatus(200);
        $this->assertStringContainsString('kecamatan_id', $resKec->getContent());
    }

    /**
     * Admin dapat mengimpor data melalui berkas CSV.
     */
    public function test_admin_can_import_csv_data(): void
    {
        $admin = User::first();

        $csvContent = "indikator_id,wilayah,tahun,nilai\n".
                      "ipm,kabupaten,2026,79.55\n".
                      "kemiskinan,kabupaten,2026,3.99\n";

        $file = UploadedFile::fake()->createWithContent('import_test.csv', $csvContent);

        $response = $this->actingAs($admin)->post('/admin/import-csv', [
            'type' => 'indikator',
            'csv_file' => $file,
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('indicator_trends', [
            'indicator_id' => 'ipm',
            'year' => 2026,
            'value' => 79.55,
        ]);

        $this->assertDatabaseHas('indicator_trends', [
            'indicator_id' => 'kemiskinan',
            'year' => 2026,
            'value' => 3.99,
        ]);
    }

    /**
     * Admin dapat logout.
     */
    public function test_admin_can_logout(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->post('/admin/logout');
        $response->assertRedirect('/admin/login');
        $this->assertGuest();
    }
}
