@extends('admin.layouts.app')

@section('title', 'Edit Indikator - ' . $indicator->name)
@section('header_title', 'Edit Indikator: ' . $indicator->short_name)
@section('header_subtitle', 'Perbarui nilai tren tahunan dan metadata Satu Data Indonesia')

@section('header_actions')
    <a href="{{ route('admin.indicators') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
        <span>Kembali ke Daftar</span>
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.indicators.update', $indicator->id) }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <!-- Kolom Kiri: Metadata & Info Umum -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i data-lucide="info" style="color: var(--primary); width: 18px; height: 18px;"></i>
                            <span>Atribut & Parameter Indikator</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap Indikator</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $indicator->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="short_name" class="form-label">Nama Singkat (Label Card)</label>
                        <input type="text" id="short_name" name="short_name" class="form-input" value="{{ old('short_name', $indicator->short_name) }}" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="unit" class="form-label">Satuan Ukur</label>
                            <input type="text" id="unit" name="unit" class="form-input" value="{{ old('unit', $indicator->unit) }}" required placeholder="%, Jiwa, Poin, Tahun, dll">
                        </div>
                        <div class="form-group">
                            <label for="digits" class="form-label">Desimal (Angka di Belakang Koma)</label>
                            <input type="number" id="digits" name="digits" class="form-input" min="0" max="4" value="{{ old('digits', $indicator->digits) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="lower_is_better" value="1" {{ old('lower_is_better', $indicator->lower_is_better) ? 'checked' : '' }} style="accent-color: var(--primary);">
                            <span style="font-size: 0.85rem; font-weight: 600; color: #334155;">Makin Rendah Makin Baik (Contoh: Kemiskinan, Pengangguran)</span>
                        </label>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i data-lucide="book-open" style="color: #2563EB; width: 18px; height: 18px;"></i>
                            <span>Metadata Satu Data Indonesia (SDI)</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="metadata_produsen" class="form-label">Produsen Data Resmi</label>
                        <input type="text" id="metadata_produsen" name="metadata_produsen" class="form-input" value="{{ old('metadata_produsen', $indicator->metadata_produsen) }}" placeholder="BPS Kabupaten Bangka / Dinas Terkait">
                    </div>

                    <div class="form-group">
                        <label for="metadata_definisi" class="form-label">Definisi Operasional</label>
                        <textarea id="metadata_definisi" name="metadata_definisi" class="form-textarea" rows="3">{{ old('metadata_definisi', $indicator->metadata_definisi) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="metadata_metodologi" class="form-label">Metodologi Pengumpulan Data</label>
                        <textarea id="metadata_metodologi" name="metadata_metodologi" class="form-textarea" rows="2">{{ old('metadata_metodologi', $indicator->metadata_metodologi) }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="metadata_jadwal_rilis" class="form-label">Jadwal Rilis Data</label>
                            <input type="text" id="metadata_jadwal_rilis" name="metadata_jadwal_rilis" class="form-input" value="{{ old('metadata_jadwal_rilis', $indicator->metadata_jadwal_rilis) }}" placeholder="Tahunan / Semesteran">
                        </div>
                        <div class="form-group">
                            <label for="metadata_sumber_url" class="form-label">Tautan Sumber Resmi</label>
                            <input type="url" id="metadata_sumber_url" name="metadata_sumber_url" class="form-input" value="{{ old('metadata_sumber_url', $indicator->metadata_sumber_url) }}" placeholder="https://bangkakab.bps.go.id">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Tren Nilai Per Tahun (2020 - 2025) -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i data-lucide="bar-chart" style="color: #16A34A; width: 18px; height: 18px;"></i>
                            <span>Nilai Tren Historis (Level Kabupaten)</span>
                        </div>
                        <span class="badge badge-success">Data Dinamis Database</span>
                    </div>

                    <p style="font-size: 0.82rem; color: #64748B; margin-bottom: 20px;">
                        Masukkan nilai realisasi resmi untuk masing-masing tahun. Nilai ini akan langsung memperbarui grafik Chart.js, KPI card, dan perhitungan pertumbuhan YoY di halaman publik.
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        @foreach($years as $yr)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #F8FAFC; border: 1px solid var(--border-color); border-radius: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #E2E8F0; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; color: #334155;">
                                        {{ $yr }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; font-size: 0.88rem; color: #0F172A;">Tahun {{ $yr }}</div>
                                        <div style="font-size: 0.75rem; color: #64748B;">Realisasi Kabupaten Bangka</div>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; width: 160px;">
                                    <input type="number" step="any" name="trends[{{ $yr }}]" class="form-input" value="{{ old('trends.'.$yr, $yearValues[$yr] ?? '') }}" placeholder="0.00" style="text-align: right; font-family: 'JetBrains Mono', monospace; font-weight: 600;">
                                    <span style="font-size: 0.8rem; color: #64748B; font-weight: 600;">{{ $indicator->unit }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px;">
                        <a href="{{ route('admin.indicators') }}" class="btn btn-secondary">
                            <span>Batal</span>
                        </a>
                        <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">
                            <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                            <span>Simpan Perubahan Indikator</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
