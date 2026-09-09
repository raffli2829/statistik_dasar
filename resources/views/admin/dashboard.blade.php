@extends('admin.layouts.app')

@section('title', 'Dashboard Ringkasan')
@section('header_title', 'Dashboard Manajemen Data')
@section('header_subtitle', 'Ringkasan data indikator makro, kecamatan, dan status sinkronisasi Satu Data Bangka')

@section('header_actions')
    <form action="{{ route('admin.sync') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-secondary" title="Tarik pembaruan dari CKAN API">
            <i data-lucide="refresh-cw" style="width: 16px; height: 16px;"></i>
            <span>Sinkronkan API Sekarang</span>
        </button>
    </form>
    <a href="{{ route('admin.import') }}" class="btn btn-primary">
        <i data-lucide="upload" style="width: 16px; height: 16px;"></i>
        <span>Import CSV Massal</span>
    </a>
@endsection

@section('content')
    <!-- Stat Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 28px;">
        <div class="card" style="margin-bottom: 0; padding: 20px; border-left: 4px solid #DC2626;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Total Indikator</div>
                    <div style="font-size: 1.8rem; font-weight: 800; color: #0F172A; margin: 4px 0;">{{ $indicatorCount }}</div>
                    <div style="font-size: 0.78rem; color: #64748B;">4 Headline + 7 Sektoral</div>
                </div>
                <div style="width: 44px; height: 44px; background: #FEE2E2; color: #DC2626; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="trending-up" style="width: 22px; height: 22px;"></i>
                </div>
            </div>
            <div style="margin-top: 14px; border-top: 1px solid #F1F5F9; padding-top: 10px;">
                <a href="{{ route('admin.indicators') }}" style="font-size: 0.8rem; font-weight: 600; color: #DC2626; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                    <span>Kelola Indikator</span>
                    <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                </a>
            </div>
        </div>

        <div class="card" style="margin-bottom: 0; padding: 20px; border-left: 4px solid #2563EB;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Wilayah Kecamatan</div>
                    <div style="font-size: 1.8rem; font-weight: 800; color: #0F172A; margin: 4px 0;">{{ $kecamatanCount }}</div>
                    <div style="font-size: 0.78rem; color: #64748B;">Seluruh Kecamatan Kab. Bangka</div>
                </div>
                <div style="width: 44px; height: 44px; background: #DBEAFE; color: #2563EB; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="map-pin" style="width: 22px; height: 22px;"></i>
                </div>
            </div>
            <div style="margin-top: 14px; border-top: 1px solid #F1F5F9; padding-top: 10px;">
                <a href="{{ route('admin.kecamatan') }}" style="font-size: 0.8rem; font-weight: 600; color: #2563EB; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                    <span>Kelola 8 Kecamatan</span>
                    <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                </a>
            </div>
        </div>

        <div class="card" style="margin-bottom: 0; padding: 20px; border-left: 4px solid #16A34A;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Titik Data Tren</div>
                    <div style="font-size: 1.8rem; font-weight: 800; color: #0F172A; margin: 4px 0;">{{ $trendCount }}</div>
                    <div style="font-size: 0.78rem; color: #64748B;">Nilai historis (2020 - 2025)</div>
                </div>
                <div style="width: 44px; height: 44px; background: #DCFCE7; color: #16A34A; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="bar-chart-2" style="width: 22px; height: 22px;"></i>
                </div>
            </div>
            <div style="margin-top: 14px; border-top: 1px solid #F1F5F9; padding-top: 10px;">
                <a href="{{ route('admin.import') }}" style="font-size: 0.8rem; font-weight: 600; color: #16A34A; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                    <span>Import Titik Nilai Baru</span>
                    <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                </a>
            </div>
        </div>

        <div class="card" style="margin-bottom: 0; padding: 20px; border-left: 4px solid #9333EA;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Dataset CKAN Terhubung</div>
                    <div style="font-size: 1.8rem; font-weight: 800; color: #0F172A; margin: 4px 0;">{{ $portalStats['total_datasets'] ?? 173 }}</div>
                    <div style="font-size: 0.78rem; color: #15803D; display: flex; align-items: center; gap: 4px; font-weight: 600;">
                        <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #16A34A;"></span>
                        Live API Aktif
                    </div>
                </div>
                <div style="width: 44px; height: 44px; background: #F3E8FF; color: #9333EA; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="database" style="width: 22px; height: 22px;"></i>
                </div>
            </div>
            <div style="margin-top: 14px; border-top: 1px solid #F1F5F9; padding-top: 10px;">
                <span style="font-size: 0.78rem; color: #64748B;">Portal: satudata.bangka.go.id</span>
            </div>
        </div>
    </div>

    <!-- 4 Headline KPI Overview -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i data-lucide="award" style="color: var(--primary); width: 20px; height: 20px;"></i>
                <span>Indikator Makro Utama (Headline KPI)</span>
            </div>
            <a href="{{ route('admin.indicators') }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.8rem;">
                <span>Edit Semua Indikator</span>
            </a>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Indikator</th>
                        <th>Kategori</th>
                        <th>Nilai Realisasi</th>
                        <th>Satuan</th>
                        <th>YoY Change</th>
                        <th>Produsen Data</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($headlineIndicators as $ind)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0F172A;">{{ $ind['name'] }}</div>
                                <div style="font-size: 0.78rem; color: #64748B;">{{ $ind['short_name'] }}</div>
                            </td>
                            <td>
                                <span class="badge badge-primary">Headline KPI</span>
                            </td>
                            <td>
                                <strong style="font-size: 1.05rem; font-family: 'JetBrains Mono', monospace; color: #0F172A;">
                                    {{ number_format($ind['value'], $ind['digits'] ?? 2, ',', '.') }}
                                </strong>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $ind['unit'] }}</span>
                            </td>
                            <td>
                                @if(($ind['yoy_change'] ?? 0) > 0)
                                    <span style="color: #16A34A; font-weight: 600;">+{{ $ind['yoy_change'] }}</span>
                                @elseif(($ind['yoy_change'] ?? 0) < 0)
                                    <span style="color: #DC2626; font-weight: 600;">{{ $ind['yoy_change'] }}</span>
                                @else
                                    <span style="color: #64748B;">0.00</span>
                                @endif
                            </td>
                            <td style="font-size: 0.82rem; color: #475569;">
                                {{ $ind['metadata']['produsen'] ?? 'BPS Kabupaten Bangka' }}
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.indicators.edit', $ind['id']) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.78rem;">
                                    <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i>
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Preview 8 Kecamatan -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i data-lucide="map" style="color: #2563EB; width: 20px; height: 20px;"></i>
                <span>Data 8 Kecamatan Kabupaten Bangka</span>
            </div>
            <a href="{{ route('admin.kecamatan') }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.8rem;">
                <span>Kelola Detail Kecamatan</span>
            </a>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kecamatan</th>
                        <th>Ibu Kota</th>
                        <th>Luas Wilayah</th>
                        <th>Jumlah Penduduk</th>
                        <th>Kepadatan</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kecamatanList as $k)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0F172A;">{{ $k['name'] }}</div>
                            </td>
                            <td style="color: #64748B;">{{ $k['capital'] }}</td>
                            <td>{{ number_format($k['area_km2'], 2, ',', '.') }} Km²</td>
                            <td>
                                <strong style="font-family: 'JetBrains Mono', monospace;">
                                    {{ number_format($k['current_value'] ?? $k['population'], 0, ',', '.') }}
                                </strong> Jiwa
                            </td>
                            <td>{{ number_format($k['density'], 0, ',', '.') }} Jiwa/Km²</td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.kecamatan.edit', $k['id']) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.78rem;">
                                    <i data-lucide="edit" style="width: 14px; height: 14px;"></i>
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
