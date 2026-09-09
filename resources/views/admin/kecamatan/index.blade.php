@extends('admin.layouts.app')

@section('title', 'Kelola Data 8 Kecamatan')
@section('header_title', 'Kelola Data 8 Kecamatan')
@section('header_subtitle', 'Kelola profil spasial, demografi, dan nilai indikator sektoral per kecamatan')

@section('header_actions')
    <a href="{{ route('admin.import') }}" class="btn btn-secondary">
        <i data-lucide="upload" style="width: 16px; height: 16px;"></i>
        <span>Import Data Kecamatan CSV</span>
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i data-lucide="map" style="color: #2563EB; width: 20px; height: 20px;"></i>
                <span>Daftar Kecamatan di Kabupaten Bangka</span>
            </div>
            <span class="badge badge-primary">8 Kecamatan</span>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kecamatan</th>
                        <th>Ibu Kota</th>
                        <th>Luas (Km²)</th>
                        <th>Kepadatan (Jiwa/Km²)</th>
                        <th>Penduduk</th>
                        <th>PDRB per Kapita</th>
                        <th>Angkatan Kerja</th>
                        <th>Faskes</th>
                        <th>Sekolah</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kecamatans as $idx => $k)
                        <tr>
                            <td style="font-weight: 700; color: #64748B;">{{ $idx + 1 }}</td>
                            <td>
                                <strong style="color: #0F172A; font-size: 0.95rem;">{{ $k->name }}</strong>
                                <div style="font-size: 0.75rem; color: #64748B;">ID: <code>{{ $k->id }}</code></div>
                            </td>
                            <td style="color: #475569;">{{ $k->capital }}</td>
                            <td>{{ number_format($k->area_km2, 2, ',', '.') }}</td>
                            <td>{{ number_format($k->density, 0, ',', '.') }}</td>
                            <td>
                                <strong style="font-family: 'JetBrains Mono', monospace;">
                                    {{ number_format($k->population, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td>{{ number_format($k->pdrb_kapita, 2, ',', '.') }} Jt</td>
                            <td>{{ number_format($k->angkatan_kerja, 0, ',', '.') }}</td>
                            <td>{{ number_format($k->puskesmas_faskes, 0, ',', '.') }}</td>
                            <td>{{ number_format($k->sekolah_total, 0, ',', '.') }}</td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.kecamatan.edit', $k->id) }}" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.8rem;">
                                    <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i>
                                    <span>Edit Data</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
