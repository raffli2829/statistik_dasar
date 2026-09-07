@extends('layouts.app')

@section('title', 'Statistik Dasar - Satu Data Kabupaten Bangka')

@section('content')
<div class="statistik-page">
    <!-- 1. HERO SECTION & FILTER GLOBAL -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-wrapper">
                <!-- Breadcrumb -->
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <a href="https://satudata.bangka.go.id" class="breadcrumb-link" target="_blank" rel="noreferrer">Beranda</a>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-item">Sektoral</span>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-current">Statistik Dasar</span>
                </nav>

                <div class="hero-text-block">
                    <h1 class="hero-title">
                        Statistik Dasar
                        <span class="hero-highlight">Pemerintah Kabupaten Bangka</span>
                    </h1>

                    <p class="hero-description">
                        Penyajian indikator makro pembangunan, data statistik sektoral, dan perbandingan kewilayahan 8 kecamatan di Kabupaten Bangka terverifikasi resmi oleh Badan Pusat Statistik (BPS) &amp; Walidata Daerah.
                    </p>
                </div>

                <!-- Filter Controls -->
                <div class="filter-toolbar">
                    <!-- Filter Tahun (5 Tahun Terakhir: 2024 - 2020) -->
                    <div class="filter-pill dropdown-pill" id="pill-year">
                        <i data-lucide="calendar" class="icon-sm text-primary"></i>
                        <span class="filter-label">Tahun:</span>
                        <div class="theme-dropdown" id="dropdown-year">
                            <button type="button" class="theme-dropdown-trigger font-mono" id="trigger-year" aria-haspopup="listbox" aria-expanded="false" title="Pilih Tahun Data">
                                <span class="dropdown-trigger-label" id="label-year">{{ $selectedYear }}</span>
                                <i data-lucide="chevron-down" class="icon-xs dropdown-chevron"></i>
                            </button>
                            <div class="theme-dropdown-menu" id="menu-year" role="listbox">
                                @foreach($years as $y)
                                    <div class="theme-dropdown-item font-mono {{ $selectedYear == $y ? 'is-active' : '' }}" 
                                         role="option" 
                                         data-value="{{ $y }}"
                                         aria-selected="{{ $selectedYear == $y ? 'true' : 'false' }}">
                                        <span>{{ $y }}</span>
                                        <i data-lucide="check" class="icon-xs item-check-icon {{ $selectedYear == $y ? '' : 'hidden' }}"></i>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <select id="select-year" class="filter-select-hidden" aria-hidden="true" tabindex="-1">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Wilayah (Kabupaten vs 8 Kecamatan) -->
                    <div class="filter-pill dropdown-pill" id="pill-wilayah">
                        <i data-lucide="map-pin" class="icon-sm text-primary"></i>
                        <span class="filter-label">Wilayah:</span>
                        <div class="theme-dropdown" id="dropdown-wilayah">
                            <button type="button" class="theme-dropdown-trigger" id="trigger-wilayah" aria-haspopup="listbox" aria-expanded="false" title="Pilih Wilayah Cakupan">
                                <span class="dropdown-trigger-label" id="label-wilayah">{{ $selectedWilayah == 'kabupaten' ? 'Kabupaten Bangka (Semua)' : 'Kec. ' . ($activeKecamatan['name'] ?? '') }}</span>
                                <i data-lucide="chevron-down" class="icon-xs dropdown-chevron"></i>
                            </button>
                            <div class="theme-dropdown-menu menu-wide" id="menu-wilayah" role="listbox">
                                <div class="theme-dropdown-item {{ $selectedWilayah == 'kabupaten' ? 'is-active' : '' }}" 
                                     role="option" 
                                     data-value="kabupaten"
                                     aria-selected="{{ $selectedWilayah == 'kabupaten' ? 'true' : 'false' }}">
                                    <span>Kabupaten Bangka (Semua)</span>
                                    <i data-lucide="check" class="icon-xs item-check-icon {{ $selectedWilayah == 'kabupaten' ? '' : 'hidden' }}"></i>
                                </div>
                                @foreach($allKecamatan as $k)
                                    <div class="theme-dropdown-item {{ $selectedWilayah == $k['id'] ? 'is-active' : '' }}" 
                                         role="option" 
                                         data-value="{{ $k['id'] }}"
                                         aria-selected="{{ $selectedWilayah == $k['id'] ? 'true' : 'false' }}">
                                        <span>Kec. {{ $k['name'] }}</span>
                                        <i data-lucide="check" class="icon-xs item-check-icon {{ $selectedWilayah == $k['id'] ? '' : 'hidden' }}"></i>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <select id="select-wilayah" class="filter-select-hidden" aria-hidden="true" tabindex="-1">
                            <option value="kabupaten" {{ $selectedWilayah == 'kabupaten' ? 'selected' : '' }}>Kabupaten Bangka (Semua)</option>
                            @foreach($allKecamatan as $k)
                                <option value="{{ $k['id'] }}" {{ $selectedWilayah == $k['id'] ? 'selected' : '' }}>Kec. {{ $k['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Theme Toggle -->
                    <button type="button" id="btn-theme" class="btn-icon btn-pill" title="Ubah Mode Gelap / Terang">
                        <i data-lucide="moon" class="icon-sm" id="theme-icon"></i>
                    </button>
                </div>

                <!-- Info Banner Kecamatan Terpilih (Jika Kecamatan Dipilih) -->
                <div id="active-wilayah-banner" class="active-wilayah-banner {{ $activeKecamatan ? '' : 'hidden' }}">
                    <div class="active-wilayah-info">
                        <i data-lucide="map-pin" class="icon-sm text-primary"></i>
                        <span>Menampilkan Data Khusus: <strong id="active-wilayah-name">{{ $activeKecamatan['name'] ?? '' }}</strong> (Ibu Kota: <span id="active-wilayah-capital">{{ $activeKecamatan['capital'] ?? '' }}</span>, Luas: <span id="active-wilayah-area">{{ number_format($activeKecamatan['area_km2'] ?? 0, 2, ',', '.') }}</span> Km²)</span>
                    </div>
                    <button type="button" class="btn-reset-wilayah" onclick="resetToKabupaten()">
                        <i data-lucide="rotate-ccw" class="icon-xs"></i>
                        <span>Lihat Seluruh Kabupaten</span>
                    </button>
                </div>

                <!-- 4 Headline KPI Cards (Dinamis: Agregat Kabupaten atau Spesifik Kecamatan Terpilih) -->
                <div class="kpi-grid" id="kpi-grid-container">
                    @foreach($headlineIndicators as $ind)
                        @php
                            $isGood = isset($ind['lower_is_better']) && $ind['lower_is_better'] ? ($ind['yoy_change'] < 0) : ($ind['yoy_change'] >= 0);
                        @endphp
                        <div class="kpi-card" data-indicator-id="{{ $ind['id'] }}">
                            <div class="kpi-header">
                                <div class="kpi-title-wrap">
                                    <div class="kpi-icon-wrap">
                                        @if(str_contains($ind['id'], 'ipm') || str_contains($ind['id'], 'area'))
                                            <i data-lucide="graduation-cap" class="icon-md"></i>
                                        @elseif(str_contains($ind['id'], 'kemiskinan') || str_contains($ind['id'], 'density'))
                                            <i data-lucide="trending-down" class="icon-md"></i>
                                        @elseif(str_contains($ind['id'], 'pertumbuhan') || str_contains($ind['id'], 'pdrb'))
                                            <i data-lucide="trending-up" class="icon-md"></i>
                                        @else
                                            <i data-lucide="users" class="icon-md"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="kpi-name" id="kpi-name-{{ $ind['id'] }}">{{ $ind['short_name'] ?? $ind['name'] }}</h3>
                                        <p class="kpi-sub" id="kpi-sub-{{ $ind['id'] }}">{{ $ind['metadata']['satuan'] ?? $ind['unit'] }}</p>
                                    </div>
                                </div>

                                <button type="button" class="btn-info" onclick="openMetadataModal('{{ $ind['id'] }}')" title="Lihat Metadata SDI">
                                    <i data-lucide="info" class="icon-sm"></i>
                                </button>
                            </div>

                            <div class="kpi-body">
                                <div class="kpi-value-row">
                                    <span class="kpi-number font-mono" id="kpi-val-{{ $ind['id'] }}">
                                        {{ number_format($ind['value'], (isset($ind['unit']) && ($ind['unit'] == 'Poin' || $ind['unit'] == '%' || str_contains($ind['unit'], 'Juta')) ? 2 : 0), ',', '.') }}
                                    </span>
                                    <span class="kpi-unit" id="kpi-unit-{{ $ind['id'] }}">{{ $ind['unit'] }}</span>
                                </div>

                                <div class="kpi-meta-row">
                                    <span class="trend-badge {{ $isGood ? 'trend-positive' : 'trend-negative' }}" id="kpi-badge-{{ $ind['id'] }}">
                                        <i data-lucide="{{ $ind['yoy_change'] < 0 ? 'arrow-down-right' : 'arrow-up-right' }}" class="icon-xs"></i>
                                        {{ $ind['yoy_change'] > 0 ? '+' : '' }}{{ number_format($ind['yoy_change'], 2, ',', '.') }}% YoY
                                    </span>
                                    <span class="kpi-year-label font-mono">Tahun {{ $selectedYear }}</span>
                                </div>

                                <!-- Sparkline Canvas -->
                                <div class="kpi-sparkline-wrap">
                                    <canvas id="spark-{{ $ind['id'] }}" class="kpi-sparkline" width="220" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- 2. RUANG KERJA STATISTIK SEKTORAL -->
    <section class="sektoral-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">
                        <i data-lucide="trending-up" class="icon-lg text-primary"></i>
                        Eksplorasi Statistik Sektoral
                    </h2>
                    <p class="section-desc">
                        Tren perkembangan 5 tahun terakhir (2020–2024) menurut bidang urusan pemerintahan resmi BPS Kabupaten Bangka.
                    </p>
                </div>

                <!-- Mode Switcher (Area / Line / Bar) -->
                <div class="chart-mode-group">
                    <button type="button" class="chart-mode-btn active" data-mode="area" title="Mode Grafik Area">
                        <i data-lucide="layers" class="icon-sm"></i>
                        <span>Area</span>
                    </button>
                    <button type="button" class="chart-mode-btn" data-mode="line" title="Mode Grafik Garis">
                        <i data-lucide="activity" class="icon-sm"></i>
                        <span>Garis</span>
                    </button>
                    <button type="button" class="chart-mode-btn" data-mode="bar" title="Mode Grafik Batang">
                        <i data-lucide="bar-chart-3" class="icon-sm"></i>
                        <span>Batang</span>
                    </button>
                </div>
            </div>

            <!-- Sektor Navigation Tabs -->
            <div class="sektoral-tabs">
                @foreach($sectors as $s)
                    <button type="button" class="sektor-tab-btn {{ $selectedSector == $s['id'] ? 'active' : '' }}" data-sector="{{ $s['id'] }}">
                        <i data-lucide="{{ $s['icon'] }}" class="icon-sm"></i>
                        <span>{{ $s['label'] }}</span>
                    </button>
                @endforeach
            </div>

            <!-- Sektoral Chart Card -->
            <div class="chart-card">
                <div class="chart-card-header">
                    <div class="chart-header-info">
                        <div class="chart-icon-box">
                            <i data-lucide="{{ $sectors[array_search($selectedSector, array_column($sectors, 'id'))]['icon'] ?? 'users' }}" class="icon-md text-primary" id="current-sector-icon"></i>
                        </div>
                        <div>
                            <h3 class="chart-title" id="chart-indicator-name">{{ $currentSector['name'] }}</h3>
                            <p class="chart-subtitle">
                                Produsen: <span id="chart-producer" class="font-medium text-foreground">{{ $currentSector['metadata']['produsen'] }}</span> &middot;
                                Satuan: <span id="chart-unit" class="font-semibold text-primary">{{ $currentSector['unit'] }}</span> &middot;
                                Wilayah: <span id="chart-wilayah-name" class="font-semibold text-foreground">{{ $activeKecamatan ? 'Kec. ' . $activeKecamatan['name'] : 'Kabupaten Bangka' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="chart-header-actions">
                        <span class="pill-highlight font-mono" id="chart-current-stat">
                            Thn {{ $selectedYear }}: {{ number_format($currentSector['value'], $currentSector['column']['digits'] ?? 2, ',', '.') }} {{ $currentSector['unit'] }}
                        </span>
                        <button type="button" class="btn-outline btn-sm" onclick="openMetadataModal('{{ $selectedSector }}')">
                            <i data-lucide="info" class="icon-xs"></i>
                            <span>Metadata SDI</span>
                        </button>
                    </div>
                </div>

                <!-- Chart Canvas Container -->
                <div class="chart-canvas-container">
                    <canvas id="sektoralMainChart"></canvas>
                </div>

                <!-- Analysis Summary Banner -->
                <div class="analysis-box">
                    <i data-lucide="sparkles" class="icon-sm text-primary"></i>
                    <p class="analysis-text" id="chart-analysis-text">
                        <strong>Analisis Tren:</strong> Indikator <strong>{{ $currentSector['name'] }}</strong> {{ $activeKecamatan ? 'di Kecamatan ' . $activeKecamatan['name'] : 'di Kabupaten Bangka' }} tercatat sebesar <strong>{{ number_format($currentSector['value'], $currentSector['column']['digits'] ?? 2, ',', '.') }} {{ $currentSector['unit'] }}</strong> pada tahun {{ $selectedYear }} dengan rujukan resmi {{ $currentSector['metadata']['produsen'] }}.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. MATRIKS PERBANDINGAN 8 KECAMATAN -->
    <section class="kecamatan-section">
        <div class="container">
            <div class="table-card">
                <div class="table-card-header">
                    <div>
                        <h3 class="table-title">
                            <i data-lucide="map-pin" class="icon-md text-primary"></i>
                            Distribusi 8 Kecamatan se-Kabupaten Bangka
                        </h3>
                        <p class="table-subtitle">
                            Capaian indikator <strong id="table-indicator-label" class="text-foreground">{{ $currentSector['column']['label'] }}</strong> per kecamatan pada tahun <span id="table-year-label">{{ $selectedYear }}</span>.
                        </p>
                    </div>

                    <div class="table-actions">
                        <!-- Search input -->
                        <div class="search-wrap">
                            <i data-lucide="search" class="icon-xs search-icon"></i>
                            <input type="text" id="input-kecamatan-search" class="search-input" placeholder="Cari kecamatan / ibu kota...">
                        </div>

                        <!-- Export Buttons -->
                        <a href="{{ route('download.csv', ['sektor' => $selectedSector, 'tahun' => $selectedYear]) }}" id="btn-export-csv" class="btn-outline btn-sm">
                            <i data-lucide="file-spreadsheet" class="icon-xs text-rose-600"></i>
                            <span>CSV</span>
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table" id="table-kecamatan">
                        <thead>
                            <tr>
                                <th class="th-center th-rank">Peringkat</th>
                                <th class="th-sortable" data-sort="name">
                                    <div class="th-content">
                                        <span>Kecamatan</span>
                                        <i data-lucide="arrow-up-down" class="icon-xs"></i>
                                    </div>
                                </th>
                                <th class="th-center">Ibu Kota Kec.</th>
                                <th class="th-sortable th-right" data-sort="value">
                                    <div class="th-content th-content-right">
                                        <span id="th-metric-header">{{ $currentSector['column']['label'] }} ({{ $currentSector['column']['unit'] }})</span>
                                        <i data-lucide="arrow-up-down" class="icon-xs"></i>
                                    </div>
                                </th>
                                <th class="th-bar">Distribusi Proporsi Spasial</th>
                                <th class="th-center th-area">Luas (Km²)</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-kecamatan">
                            @foreach($kecamatanList as $idx => $k)
                                @php
                                    $proportion = min(100, ($k['current_value'] / $maxVal) * 100);
                                    $isSelected = ($selectedWilayah == $k['id']);
                                @endphp
                                <tr data-kecamatan-id="{{ $k['id'] }}" data-name="{{ strtolower($k['name']) }}" data-capital="{{ strtolower($k['capital']) }}" data-value="{{ $k['current_value'] }}" class="{{ $isSelected ? 'row-selected-highlight' : '' }}">
                                    <td class="td-center font-mono td-rank-val">{{ $idx + 1 }}</td>
                                    <td class="td-name">
                                        <div class="kecamatan-identity">
                                            <span class="kecamatan-badge {{ $isSelected ? 'badge-active' : '' }}">{{ strtoupper(substr($k['name'], 0, 2)) }}</span>
                                            <div class="kecamatan-name-stack">
                                                <span class="font-semibold text-foreground">Kecamatan {{ $k['name'] }}</span>
                                                @if($isSelected)
                                                    <span class="badge-fokus-wilayah">Wilayah Terpilih</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td-center text-muted-foreground">{{ $k['capital'] }}</td>
                                    <td class="td-right font-mono font-bold td-value">
                                        {{ number_format($k['current_value'], $currentSector['column']['digits'] ?? 0, ',', '.') }}
                                        <span class="td-unit">{{ $currentSector['column']['unit'] }}</span>
                                    </td>
                                    <td class="td-bar">
                                        <div class="proportion-bar-wrap">
                                            <div class="proportion-bar-track">
                                                <div class="proportion-bar-fill {{ $isSelected ? 'fill-active' : '' }}" style="width: {{ $proportion }}%"></div>
                                            </div>
                                            <span class="proportion-pct font-mono">{{ round($proportion) }}%</span>
                                        </div>
                                    </td>
                                    <td class="td-center font-mono text-muted-foreground">{{ number_format($k['area_km2'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. DATASET TERKAIT DI KATALOG SATU DATA BANGKA -->
    <section class="dataset-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">
                        <i data-lucide="database" class="icon-lg text-primary"></i>
                        Dataset Rujukan Resmi Terkait
                    </h2>
                    <p class="section-desc">
                        Katalog data terverifikasi yang dipublikasikan pada Open Data Portal Kabupaten Bangka.
                    </p>
                </div>

                <a href="https://satudata.bangka.go.id/dataset" target="_blank" rel="noreferrer" class="btn-outline btn-sm">
                    <span>Lihat Semua Dataset</span>
                    <i data-lucide="file-text" class="icon-xs"></i>
                </a>
            </div>

            <div class="dataset-grid">
                @foreach($featuredDatasets as $ds)
                    <div class="dataset-card">
                        <div class="dataset-header">
                            <h4 class="dataset-title">
                                <a href="{{ $ds['url'] }}" target="_blank" rel="noreferrer">{{ $ds['title'] }}</a>
                            </h4>
                            <span class="badge-tag">1 file</span>
                        </div>

                        <div class="dataset-body">
                            <p class="dataset-desc">
                                Dataset statistik sektoral terverifikasi untuk perencanaan, evaluasi, dan perumusan kebijakan pembangunan daerah.
                            </p>
                            <div class="dataset-tags">
                                <span class="tag-pill">{{ strtoupper($ds['category']) }}</span>
                                <span class="tag-pill">STATISTIK BPS</span>
                            </div>
                        </div>

                        <div class="dataset-footer">
                            <div class="dataset-meta-item">
                                <i data-lucide="building-2" class="icon-xs text-primary"></i>
                                <span class="truncate">{{ $ds['opd'] }}</span>
                            </div>
                            <div class="dataset-meta-item">
                                <i data-lucide="calendar" class="icon-xs text-primary"></i>
                                <span>Diperbarui {{ $ds['updated_at'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<!-- 5. MODAL / DRAWER METADATA OPERASIONAL SDI -->
<div id="modal-metadata" class="metadata-modal" aria-hidden="true">
    <div class="modal-overlay" onclick="closeMetadataModal()"></div>
    <div class="modal-drawer">
        <div class="modal-header">
            <div class="modal-badge">
                <i data-lucide="info" class="icon-xs"></i>
                <span>Metadata Resmi SDI &amp; BPS</span>
            </div>
            <button type="button" class="btn-close-modal" onclick="closeMetadataModal()" aria-label="Tutup Metadata">
                <i data-lucide="x" class="icon-md"></i>
            </button>
        </div>

        <div class="modal-body">
            <h3 class="modal-indicator-title" id="modal-title">Indikator Statistik</h3>
            <p class="modal-indicator-stat font-mono" id="modal-stat">Nilai Realisasi: -</p>

            <div class="modal-details-stack">
                <div class="detail-box">
                    <span class="detail-box-label">Produsen Data</span>
                    <p class="detail-box-value" id="modal-producer">-</p>
                </div>

                <div class="detail-box">
                    <span class="detail-box-label">Definisi Operasional</span>
                    <p class="detail-box-value" id="modal-definition">-</p>
                </div>

                <div class="detail-grid-2">
                    <div class="detail-box">
                        <span class="detail-box-label">Satuan Ukur</span>
                        <p class="detail-box-value" id="modal-unit">-</p>
                    </div>
                    <div class="detail-box">
                        <span class="detail-box-label">Jadwal Rilis</span>
                        <p class="detail-box-value" id="modal-schedule">-</p>
                    </div>
                </div>

                <div class="detail-box">
                    <span class="detail-box-label">Metodologi Pengumpulan Data</span>
                    <p class="detail-box-value" id="modal-methodology">-</p>
                </div>

                <div class="detail-box">
                    <span class="detail-box-label">Data Historis 5 Tahun Terakhir (2024–2020)</span>
                    <div class="history-grid" id="modal-history-grid">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <a href="https://bangkakab.bps.go.id" target="_blank" rel="noreferrer" class="btn-primary btn-block">
                    <span>Lihat di Portal BPS Kabupaten Bangka</span>
                    <i data-lucide="external-link" class="icon-xs"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Embedded Server State Data for JavaScript -->
<script>
    window.STATISTIK_CONFIG = {
        years: @json($years),
        selectedYear: {{ $selectedYear }},
        selectedWilayah: "{{ $selectedWilayah }}",
        selectedSector: "{{ $selectedSector }}",
        headlineIndicators: @json($headlineIndicators),
        kabupatenHeadlines: @json(config('statistik.headline_indicators')),
        sectorIndicators: @json($sectorIndicators),
        allKecamatan: @json($allKecamatan),
        routes: {
            apiSektor: "{{ url('/api/sektor') }}",
            apiKecamatan: "{{ url('/api/kecamatan') }}",
            downloadCsv: "{{ url('/download/csv') }}",
            downloadJson: "{{ url('/download/json') }}"
        }
    };
</script>
@endsection
