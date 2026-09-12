@extends('layouts.app')

@section('title', 'Statistik Sektoral Kabupaten Bangka - Satu Data Kabupaten Bangka')
@section('meta_description', 'Kompilasi dan publikasi data statistik sektoral lintas OPD tingkat Kabupaten Bangka terintegrasi.')

@section('content')
<div class="publikasi-page">
    <!-- Hero Header -->
    <section class="pub-hero">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('statistik.index') }}" class="breadcrumb-link">Statistik Dasar</a>
                <span class="breadcrumb-sep">/</span>
                <span class="breadcrumb-link text-muted">Publikasi</span>
                <span class="breadcrumb-sep">/</span>
                <span class="breadcrumb-current">Statistik Sektoral Kabupaten</span>
            </nav>

            <div class="pub-hero-text">
                <div class="pub-hero-icon-wrap">
                    <i data-lucide="bar-chart-3" class="icon-lg"></i>
                </div>
                <div>
                    <h1 class="pub-hero-title">Statistik Sektoral Kabupaten Bangka</h1>
                    <p class="pub-hero-desc">Kompilasi indikator statistik sektoral lintas perangkat daerah untuk mendukung evaluasi dan perencanaan pembangunan daerah.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sub-Navigasi 5 Halaman Publikasi -->
    @include('publikasi.partials.nav')

    <!-- Konten Utama Statistik Sektoral Kabupaten -->
    <section class="pub-content">
        <div class="container">

            <!-- 1. Ringkasan Metrik Kabupaten -->
            <div class="pub-kpi-grid">
                <div class="pub-kpi-card">
                    <div class="kpi-icon-wrap" style="background: rgba(59, 130, 246, 0.12); color: #3B82F6;">
                        <i data-lucide="pie-chart" class="icon-sm"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-value">{{ count($items) }} Sektor Utama</span>
                        <span class="kpi-label">Bidang Pembangunan Daerah</span>
                    </div>
                </div>

                <div class="pub-kpi-card">
                    <div class="kpi-icon-wrap" style="background: rgba(16, 185, 129, 0.12); color: #10B981;">
                        <i data-lucide="activity" class="icon-sm"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-value">66 Indikator</span>
                        <span class="kpi-label">Indikator Kinerja Makro Sektoral</span>
                    </div>
                </div>

                <div class="pub-kpi-card">
                    <div class="kpi-icon-wrap" style="background: rgba(245, 158, 11, 0.12); color: #F59E0B;">
                        <i data-lucide="shield-check" class="icon-sm"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-value">100% Terverifikasi</span>
                        <span class="kpi-label">Pembinaan Statistik BPS</span>
                    </div>
                </div>

                <div class="pub-kpi-card">
                    <div class="kpi-icon-wrap" style="background: rgba(139, 92, 246, 0.12); color: #8B5CF6;">
                        <i data-lucide="compass" class="icon-sm"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-value">RPJMD 2024-2026</span>
                        <span class="kpi-label">Rujukan Perencanaan Daerah</span>
                    </div>
                </div>
            </div>

            <!-- 2. Pencarian Indikator Global Lintas Sektor -->
            <div class="pub-controls-bar">
                <div class="pub-search-box w-full" style="max-width: 100%;">
                    <i data-lucide="search" class="icon-xs search-icon"></i>
                    <input type="text" 
                           id="search-indicator-input" 
                           placeholder="Cari indikator spesifik lintas sektor (contoh: IPM, Kemiskinan, PDRB, Jalan, Stunting, SPBE)..." 
                           class="pub-search-input"
                           autocomplete="off">
                    <button type="button" id="clear-indicator-search" class="search-clear-btn" style="display: none;" title="Hapus pencarian">
                        <i data-lucide="x" class="icon-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Header Aksi & Counter -->
            <div class="pub-section-header-bar">
                <div class="pub-result-meta">
                    <span id="indicator-count-text">Menampilkan 4 sektor pembangunan dengan seluruh indikator</span>
                </div>
                <div class="pub-action-buttons">
                    <button type="button" class="btn-secondary-pub" id="btn-expand-all-sectors">
                        <i data-lucide="chevrons-up-down" class="icon-xs"></i>
                        <span id="expand-collapse-label">Buka / Tutup Semua</span>
                    </button>
                    <button type="button" class="btn-primary-pub" id="btn-export-all-indicators">
                        <i data-lucide="download" class="icon-xs"></i>
                        <span>Ekspor Semua Indikator (CSV)</span>
                    </button>
                </div>
            </div>

            <!-- 3. Daftar Sektor Pembangunan & Tabel Indikator -->
            <div class="pub-sectors-accordion" id="sectors-accordion-container">
                @foreach($items as $sector)
                <div class="pub-sector-panel sector-item-panel" 
                     id="panel-{{ $sector['id'] }}"
                     data-sector-id="{{ $sector['id'] }}"
                     data-sector-name="{{ strtolower($sector['nama']) }}">
                    <!-- Header Panel Sektor -->
                    <div class="sector-panel-header" 
                         role="button" 
                         tabindex="0" 
                         aria-expanded="true"
                         aria-controls="content-{{ $sector['id'] }}">
                        <div class="sector-header-left">
                            <div class="sector-icon-wrap" style="background: {{ $sector['warna'] }}18; color: {{ $sector['warna'] }};">
                                <i data-lucide="{{ $sector['ikon'] }}" class="icon-md"></i>
                            </div>
                            <div>
                                <div class="sector-title-row">
                                    <h2 class="sector-title">{{ $sector['nama'] }}</h2>
                                    <span class="pub-indicator-count">
                                        <i data-lucide="layers" class="icon-xs"></i>
                                        {{ count($sector['indikator']) }} Indikator Kunci
                                    </span>
                                </div>
                                <p class="sector-desc">{{ $sector['deskripsi'] }}</p>
                            </div>
                        </div>

                        <div class="sector-header-right">
                            <button type="button" 
                                    class="btn-icon-subtle btn-export-sector-csv" 
                                    title="Ekspor sektor ini ke CSV"
                                    data-sector-id="{{ $sector['id'] }}"
                                    data-sector-name="{{ $sector['nama'] }}">
                                <i data-lucide="download" class="icon-xs"></i>
                            </button>
                            <span class="sector-toggle-icon">
                                <i data-lucide="chevron-down" class="icon-sm"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Isi Panel: Tabel Indikator Responsif -->
                    <div class="sector-panel-body" id="content-{{ $sector['id'] }}">
                        <div class="pub-table-responsive">
                            <table class="pub-indicator-table">
                                <thead>
                                    <tr>
                                        <th style="min-width: 220px;">Indikator Pembangunan</th>
                                        <th style="text-align: right; width: 110px;">Capaian Terkini</th>
                                        <th style="width: 80px;">Satuan</th>
                                        <th style="text-align: right; width: 100px;">Target</th>
                                        <th style="width: 130px;">Tren Pertumbuhan</th>
                                        <th style="width: 140px;">Periode Data</th>
                                        <th style="min-width: 180px;">Produsen Data (OPD)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sector['indikator'] as $ind)
                                    <tr class="indicator-row" 
                                        data-name="{{ strtolower($ind['nama']) }}"
                                        data-opd="{{ strtolower($ind['opd']) }}"
                                        data-sector="{{ strtolower($sector['nama']) }}">
                                        <td class="indicator-cell-name">
                                            <strong>{{ $ind['nama'] }}</strong>
                                        </td>
                                        <td class="indicator-cell-val" style="text-align: right;">
                                            <span class="val-bold">{{ $ind['nilai'] }}</span>
                                        </td>
                                        <td class="indicator-cell-unit">
                                            <span class="unit-badge">{{ $ind['satuan'] }}</span>
                                        </td>
                                        <td class="indicator-cell-target" style="text-align: right;">
                                            {{ $ind['target'] }}
                                        </td>
                                        <td class="indicator-cell-trend">
                                            <span class="trend-badge trend-{{ $ind['tren_status'] }}">
                                                <i data-lucide="{{ str_starts_with($ind['tren'], '-') ? 'trending-down' : 'trending-up' }}" class="icon-xs"></i>
                                                {{ $ind['tren'] }}
                                            </span>
                                        </td>
                                        <td class="indicator-cell-period">
                                            <span class="period-text">{{ $ind['periode'] }}</span>
                                        </td>
                                        <td class="indicator-cell-opd">
                                            <span class="opd-text">{{ $ind['opd'] }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Empty State bila hasil cari indikator nihil -->
            <div id="indicator-empty-state" class="pub-empty-state" style="display: none;">
                <div class="empty-icon-wrap">
                    <i data-lucide="search-x" class="icon-lg"></i>
                </div>
                <h3>Indikator tidak ditemukan</h3>
                <p>Coba gunakan kata kunci pencarian yang lain.</p>
                <button type="button" id="btn-reset-indicator-filter" class="btn-secondary-pub">
                    <i data-lucide="rotate-ccw" class="icon-xs"></i>
                    <span>Reset Pencarian</span>
                </button>
            </div>

        </div>
    </section>
</div>

<!-- Raw data JSON untuk ekspor CSV / interaktivitas cepat -->
<script id="kabupaten-data-json" type="application/json">
    {!! json_encode($items) !!}
</script>
@endsection
