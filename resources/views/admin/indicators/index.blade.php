@extends('admin.layouts.app')

@section('title', 'Kelola Indikator Makro & Sektoral')
@section('header_title', 'Kelola Indikator Statistik')
@section('header_subtitle', 'Ubah nilai realisasi, target tahunan, satuan, desimal, dan metadata Satu Data Indonesia')

@section('header_actions')
    <a href="{{ route('admin.import') }}" class="btn btn-secondary">
        <i data-lucide="upload" style="width: 16px; height: 16px;"></i>
        <span>Import Nilai CSV</span>
    </a>
@endsection

@section('content')
    <!-- Headline Indicators Table -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i data-lucide="award" style="color: var(--primary); width: 20px; height: 20px;"></i>
                <span>Indikator Makro Utama (Headline KPI)</span>
            </div>
            <span class="badge badge-primary">4 Indikator</span>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Indikator</th>
                        <th>Satuan</th>
                        <th>Nilai {{ $defaultYear }}</th>
                        <th>YoY Change</th>
                        <th>Karakteristik</th>
                        <th>Produsen Data</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($headlines as $ind)
                        @php
                            $val = $ind->getValueForYear($defaultYear, 'kabupaten');
                            $yoy = $ind->calculateYoyChange($defaultYear, 'kabupaten');
                        @endphp
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0F172A;">{{ $ind->name }}</div>
                                <div style="font-size: 0.78rem; color: #64748B;">ID: <code>{{ $ind->id }}</code> ({{ $ind->short_name }})</div>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $ind->unit }}</span>
                            </td>
                            <td>
                                <strong style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">
                                    {{ $val !== null ? number_format($val, $ind->digits, ',', '.') : '-' }}
                                </strong>
                            </td>
                            <td>
                                @if($yoy > 0)
                                    <span style="color: #16A34A; font-weight: 600;">+{{ $yoy }}</span>
                                @elseif($yoy < 0)
                                    <span style="color: #DC2626; font-weight: 600;">{{ $yoy }}</span>
                                @else
                                    <span style="color: #64748B;">0.00</span>
                                @endif
                            </td>
                            <td>
                                @if($ind->lower_is_better)
                                    <span class="badge badge-secondary" style="color: #C2410C;">Makin Rendah Makin Baik</span>
                                @else
                                    <span class="badge badge-success">Makin Tinggi Makin Baik</span>
                                @endif
                            </td>
                            <td style="font-size: 0.82rem; color: #475569;">
                                {{ $ind->metadata_produsen ?? 'BPS Kabupaten Bangka' }}
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.indicators.edit', $ind->id) }}" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.8rem;">
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

    <!-- Sector Indicators Table -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i data-lucide="layers" style="color: #E11D48; width: 20px; height: 20px;"></i>
                <span>7 Indikator Sektor Urusan Daerah</span>
            </div>
            <span class="badge badge-secondary">7 Sektor</span>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Sektor Urusan</th>
                        <th>Nama Indikator</th>
                        <th>Satuan Kabupaten</th>
                        <th>Satuan Kecamatan</th>
                        <th>Nilai {{ $defaultYear }}</th>
                        <th>Produsen Data</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sectors as $sec)
                        @php
                            $val = $sec->getValueForYear($defaultYear, 'kabupaten');
                        @endphp
                        <tr>
                            <td>
                                <span class="badge badge-secondary" style="text-transform: capitalize; font-weight: 700;">
                                    {{ $sec->sector_id }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0F172A;">{{ $sec->name }}</div>
                                <div style="font-size: 0.78rem; color: #64748B;">{{ $sec->short_name }}</div>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $sec->unit }}</span>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $sec->column_unit ?: $sec->unit }}</span>
                            </td>
                            <td>
                                <strong style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">
                                    {{ $val !== null ? number_format($val, $sec->digits, ',', '.') : '-' }}
                                </strong>
                            </td>
                            <td style="font-size: 0.82rem; color: #475569;">
                                {{ $sec->metadata_produsen ?? 'BPS / OPD Terkait' }}
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.indicators.edit', $sec->id) }}" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.8rem;">
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
