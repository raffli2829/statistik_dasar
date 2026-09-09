@extends('admin.layouts.app')

@section('title', 'Edit Kecamatan - ' . $kecamatan->name)
@section('header_title', 'Edit Kecamatan: ' . $kecamatan->name)
@section('header_subtitle', 'Perbarui atribut spasial, demografi, dan nilai indikator sektoral per tahun')

@section('header_actions')
    <a href="{{ route('admin.kecamatan') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
        <span>Kembali ke Daftar</span>
    </a>
@endsection

@section('content')
    <form action="{{ route('admin.kecamatan.update', $kecamatan->id) }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <!-- Kolom Kiri: Profil Wilayah & Metrik Agregat -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i data-lucide="map-pin" style="color: #2563EB; width: 18px; height: 18px;"></i>
                            <span>Profil Dasar Kecamatan</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Nama Kecamatan</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $kecamatan->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="capital" class="form-label">Ibu Kota Kecamatan</label>
                        <input type="text" id="capital" name="capital" class="form-input" value="{{ old('capital', $kecamatan->capital) }}" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="area_km2" class="form-label">Luas Wilayah (Km²)</label>
                            <input type="number" step="any" id="area_km2" name="area_km2" class="form-input" value="{{ old('area_km2', $kecamatan->area_km2) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="density" class="form-label">Kepadatan (Jiwa/Km²)</label>
                            <input type="number" step="any" id="density" name="density" class="form-input" value="{{ old('density', $kecamatan->density) }}" required>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i data-lucide="activity" style="color: var(--primary); width: 18px; height: 18px;"></i>
                            <span>Nilai Agregat Sektoral Terkini</span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="population" class="form-label">Jumlah Penduduk (Jiwa)</label>
                            <input type="number" step="any" id="population" name="population" class="form-input" value="{{ old('population', $kecamatan->population) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="pdrb_kapita" class="form-label">PDRB per Kapita (Juta Rp)</label>
                            <input type="number" step="any" id="pdrb_kapita" name="pdrb_kapita" class="form-input" value="{{ old('pdrb_kapita', $kecamatan->pdrb_kapita) }}">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="angkatan_kerja" class="form-label">Angkatan Kerja Aktif (Jiwa)</label>
                            <input type="number" step="any" id="angkatan_kerja" name="angkatan_kerja" class="form-input" value="{{ old('angkatan_kerja', $kecamatan->angkatan_kerja) }}">
                        </div>
                        <div class="form-group">
                            <label for="puskesmas_faskes" class="form-label">Fasilitas Kesehatan (Unit)</label>
                            <input type="number" step="any" id="puskesmas_faskes" name="puskesmas_faskes" class="form-input" value="{{ old('puskesmas_faskes', $kecamatan->puskesmas_faskes) }}">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="sekolah_total" class="form-label">Sekolah SD/SMP/SMA (Unit)</label>
                            <input type="number" step="any" id="sekolah_total" name="sekolah_total" class="form-input" value="{{ old('sekolah_total', $kecamatan->sekolah_total) }}">
                        </div>
                        <div class="form-group">
                            <label for="lahan_tani" class="form-label">Lahan Sawah Baku (Hektar)</label>
                            <input type="number" step="any" id="lahan_tani" name="lahan_tani" class="form-input" value="{{ old('lahan_tani', $kecamatan->lahan_tani) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="penerima_bansos" class="form-label">Keluarga Fakir Miskin (Keluarga)</label>
                        <input type="number" step="any" id="penerima_bansos" name="penerima_bansos" class="form-input" value="{{ old('penerima_bansos', $kecamatan->penerima_bansos) }}">
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Nilai Tren Sektoral per Tahun untuk Kecamatan Ini -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i data-lucide="trending-up" style="color: #16A34A; width: 18px; height: 18px;"></i>
                            <span>Tren Historis per Sektor (Kec. {{ $kecamatan->name }})</span>
                        </div>
                    </div>

                    <p style="font-size: 0.82rem; color: #64748B; margin-bottom: 20px;">
                        Nilai ini digunakan saat pengunjung memilih filter kecamatan di halaman publik.
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        @foreach($sectors as $sec)
                            <div style="border: 1px solid var(--border-color); border-radius: 10px; padding: 16px; background: #F8FAFC;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                    <strong style="font-size: 0.9rem; color: #0F172A;">{{ $sec['label'] }}</strong>
                                    <span class="badge badge-secondary" style="font-size: 0.72rem;">Sektor {{ $sec['id'] }}</span>
                                </div>

                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px;">
                                    @foreach($years as $yr)
                                        <div>
                                            <label style="font-size: 0.75rem; color: #64748B; font-weight: 600; display: block; margin-bottom: 2px;">{{ $yr }}</label>
                                            <input type="number" step="any" name="sector_trends[{{ $sec['id'] }}][{{ $yr }}]" class="form-input" value="{{ old("sector_trends.{$sec['id']}.{$yr}", $sectorTrends[$sec['id']][$yr] ?? '') }}" placeholder="0" style="padding: 6px 10px; font-size: 0.82rem; font-family: 'JetBrains Mono', monospace;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px;">
                        <a href="{{ route('admin.kecamatan') }}" class="btn btn-secondary">
                            <span>Batal</span>
                        </a>
                        <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">
                            <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                            <span>Simpan Data Kecamatan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
