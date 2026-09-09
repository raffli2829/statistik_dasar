@extends('admin.layouts.app')

@section('title', 'Import CSV & Sinkronisasi API')
@section('header_title', 'Import Data CSV & Sinkronisasi API')
@section('header_subtitle', 'Perbarui data secara massal melalui berkas CSV atau sinkronkan langsung dengan CKAN API')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
        <!-- Section 1: Sinkronisasi API CKAN -->
        <div>
            <div class="card" style="border-top: 4px solid #9333EA;">
                <div class="card-header">
                    <div class="card-title">
                        <i data-lucide="refresh-cw" style="color: #9333EA; width: 20px; height: 20px;"></i>
                        <span>Sinkronisasi CKAN API Satu Data Bangka</span>
                    </div>
                    <span class="badge badge-success">Terintegrasi Live</span>
                </div>

                <p style="font-size: 0.88rem; color: #475569; line-height: 1.6; margin-bottom: 20px;">
                    Sistem ini terhubung langsung secara dinamis ke <strong>CKAN Action API Satu Data Kabupaten Bangka</strong> di server Dinas Kominfo Bangka:
                    <br>
                    <code style="background: #F1F5F9; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; word-break: break-all;">https://manajemen-satudata.bangka.go.id/api/3/action/package_search</code>
                </p>

                <div style="background: #FAF5FF; border: 1px solid #E9D5FF; border-radius: 10px; padding: 16px; margin-bottom: 24px;">
                    <div style="font-size: 0.85rem; font-weight: 700; color: #6B21A8; margin-bottom: 8px;">Manfaat Sinkronisasi API:</div>
                    <ul style="font-size: 0.82rem; color: #7E22CE; padding-left: 18px; line-height: 1.6;">
                        <li>Memperbarui daftar berkas unduhan riil (CSV/XLSX) yang baru diunggah OPD.</li>
                        <li>Memperbarui jumlah total dataset portal secara *real-time*.</li>
                        <li>Membersihkan cache aplikasi lokal dan memuat snapshot terbaru.</li>
                    </ul>
                </div>

                <form action="{{ route('admin.sync') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="background: #9333EA; width: 100%; justify-content: center; padding: 12px;">
                        <i data-lucide="refresh-cw" style="width: 18px; height: 18px;"></i>
                        <span>Jalankan Sinkronisasi API Sekarang</span>
                    </button>
                </form>
            </div>

            <!-- Download Templates Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i data-lucide="download" style="color: #2563EB; width: 20px; height: 20px;"></i>
                        <span>Unduh Template Format CSV</span>
                    </div>
                </div>

                <p style="font-size: 0.85rem; color: #64748B; margin-bottom: 16px;">
                    Gunakan template resmi berikut sebelum mengunggah agar struktur kolom dan format data valid:
                </p>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="{{ route('admin.template.download', 'indikator') }}" class="btn btn-secondary" style="justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i data-lucide="file-text" style="width: 16px; height: 16px; color: var(--primary);"></i>
                            <span>Template CSV Indikator & Tren Tahunan</span>
                        </div>
                        <i data-lucide="download" style="width: 16px; height: 16px;"></i>
                    </a>

                    <a href="{{ route('admin.template.download', 'kecamatan') }}" class="btn btn-secondary" style="justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i data-lucide="map" style="width: 16px; height: 16px; color: #2563EB;"></i>
                            <span>Template CSV Data 8 Kecamatan</span>
                        </div>
                        <i data-lucide="download" style="width: 16px; height: 16px;"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Section 2: Upload CSV Massal -->
        <div>
            <div class="card" style="border-top: 4px solid var(--primary);">
                <div class="card-header">
                    <div class="card-title">
                        <i data-lucide="upload-cloud" style="color: var(--primary); width: 20px; height: 20px;"></i>
                        <span>Unggah Berkas CSV Massal</span>
                    </div>
                </div>

                <form action="{{ route('admin.import.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Jenis Data yang Diimpor</label>
                        <select name="type" class="form-select" required>
                            <option value="indikator">Data Indikator & Titik Nilai Tren (indikator_id, wilayah, tahun, nilai)</option>
                            <option value="kecamatan">Data Profil 8 Kecamatan (luas, kepadatan, demografi, faskes)</option>
                        </select>
                        <div class="form-hint">Pilih jenis data yang sesuai dengan berkas CSV yang akan diunggah.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pilih Berkas CSV (.csv)</label>
                        <div style="border: 2px dashed #CBD5E1; border-radius: 12px; padding: 30px 20px; text-align: center; background: #F8FAFC;">
                            <i data-lucide="file-spreadsheet" style="width: 40px; height: 40px; color: #94A3B8; margin-bottom: 10px;"></i>
                            <div style="font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Pilih berkas dari komputer Anda</div>
                            <div style="font-size: 0.78rem; color: #64748B; margin-bottom: 16px;">Maksimal ukuran file: 5 MB (Format UTF-8 didukung)</div>
                            <input type="file" name="csv_file" accept=".csv,text/csv,text/plain" required style="font-size: 0.85rem; color: #475569;">
                        </div>
                    </div>

                    <div style="margin-top: 24px;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">
                            <i data-lucide="check" style="width: 18px; height: 18px;"></i>
                            <span>Unggah dan Proses Data ke Database</span>
                        </button>
                    </div>
                </form>

                <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border-color); font-size: 0.8rem; color: #64748B; line-height: 1.6;">
                    <strong>💡 Tips Format CSV:</strong>
                    <ul style="padding-left: 18px; margin-top: 6px;">
                        <li>Gunakan tanda koma (<code>,</code>) sebagai pemisah kolom.</li>
                        <li>Format desimal menggunakan tanda titik (<code>.</code>), misalnya <code>75.02</code>.</li>
                        <li>Sistem otomatis memperbarui baris data yang memiliki ID dan tahun yang sama (*upsert*).</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
