@extends('layouts.app')

@section('title', 'Infografis Statistik - Satu Data Kabupaten Bangka')
@section('meta_description', 'Visualisasi data grafik informatif dan ringkas mengenai indikator strategis pembangunan Kabupaten Bangka.')

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
                <span class="breadcrumb-current">Infografis</span>
            </nav>

            <div class="pub-hero-text">
                <div class="pub-hero-icon-wrap">
                    <i data-lucide="pie-chart" class="icon-lg"></i>
                </div>
                <div>
                    <h1 class="pub-hero-title">Galeri Infografis Statistik</h1>
                    <p class="pub-hero-desc">Visualisasi grafis informatif, ringkas, dan mudah dipahami untuk memahami indikator makro dan sektoral Kabupaten Bangka.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sub-Navigasi 5 Halaman Publikasi -->
    @include('publikasi.partials.nav')

    <!-- Konten Utama Infografis -->
    <section class="pub-content">
        <div class="container">

            <!-- Kontrol Filter & Pencarian -->
            <div class="pub-controls-bar">
                <div class="pub-filter-pills" id="infografis-filter-pills" role="tablist">
                    @foreach($kategoriList as $kat)
                    <button type="button" 
                            class="pub-pill-btn {{ $loop->first ? 'active' : '' }}" 
                            data-filter="{{ $kat }}"
                            role="tab"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $kat }}
                    </button>
                    @endforeach
                </div>

                <div class="pub-search-group">
                    <div class="pub-search-box">
                        <i data-lucide="search" class="icon-xs search-icon"></i>
                        <input type="text" 
                               id="search-infografis-input" 
                               placeholder="Cari tema infografis atau indikator..." 
                               class="pub-search-input"
                               autocomplete="off">
                        <button type="button" id="clear-infografis-search" class="search-clear-btn" style="display: none;" title="Hapus pencarian">
                            <i data-lucide="x" class="icon-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Counter Info -->
            <div class="pub-result-meta">
                <span id="infografis-count-text">Menampilkan {{ count($items) }} infografis</span>
            </div>

            <!-- Grid Infografis (2 Kolom Responsif) -->
            <div class="pub-grid pub-grid-2" id="infografis-grid-container">
                @foreach($items as $item)
                <article class="pub-card pub-card-infografis infografis-item-card" 
                         data-category="{{ $item['kategori'] }}"
                         data-title="{{ strtolower($item['judul']) }}"
                         data-desc="{{ strtolower($item['deskripsi']) }}"
                         data-id="{{ $item['id'] }}">
                    <!-- Visual Data Panel -->
                    <div class="pub-infografis-visual-panel" style="border-top: 4px solid {{ $item['warna'] }};">
                        <div class="visual-panel-bg" style="background: linear-gradient(135deg, {{ $item['warna'] }}10 0%, transparent 80%);"></div>
                        
                        <div class="visual-top-meta">
                            <span class="pub-badge" style="background: {{ $item['warna'] }}18; color: {{ $item['warna'] }};">
                                {{ $item['kategori'] }}
                            </span>
                            <span class="visual-date">
                                <i data-lucide="calendar" class="icon-xs"></i>
                                {{ $item['tanggal'] }}
                            </span>
                        </div>

                        <!-- Highlight Stat Angka Utama -->
                        <div class="visual-stat-showcase">
                            <div class="stat-number-box">
                                <span class="stat-big-number" style="color: {{ $item['warna'] }};">{{ $item['angka_utama'] }}</span>
                                <span class="stat-big-unit">{{ $item['satuan_utama'] }}</span>
                            </div>
                            <div class="stat-sub-badge">
                                <i data-lucide="{{ $item['ikon'] }}" class="icon-xs" style="color: {{ $item['warna'] }};"></i>
                                <span>{{ $item['sub_metrik'] }}</span>
                            </div>
                        </div>

                        <!-- Mini Data Points Preview -->
                        <div class="visual-mini-points">
                            @foreach(array_slice($item['data_highlights'], 0, 2) as $point)
                            <div class="mini-point-item">
                                <i data-lucide="{{ $point['icon'] }}" class="icon-xs text-muted"></i>
                                <span class="mini-point-label">{{ $point['label'] }}:</span>
                                <strong class="mini-point-val">{{ $point['value'] }}</strong>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="pub-card-body">
                        <h2 class="pub-card-title">{{ $item['judul'] }}</h2>
                        <p class="pub-card-excerpt">{{ $item['deskripsi'] }}</p>

                        <div class="pub-card-footer">
                            <span class="pub-source">
                                <i data-lucide="building-2" class="icon-xs"></i>
                                {{ $item['sumber'] }}
                            </span>

                            <div class="pub-card-actions-right">
                                <button type="button" 
                                        class="btn-text-action btn-preview-infografis" 
                                        data-infografis-id="{{ $item['id'] }}">
                                    <i data-lucide="maximize-2" class="icon-xs"></i>
                                    <span>Pratinjau</span>
                                </button>
                                <button type="button" 
                                        class="btn-icon-subtle btn-download-infografis" 
                                        title="Unduh Lembar Infografis"
                                        data-title="{{ $item['judul'] }}"
                                        data-id="{{ $item['id'] }}">
                                    <i data-lucide="download" class="icon-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Empty State bila hasil cari nihil -->
            <div id="infografis-empty-state" class="pub-empty-state" style="display: none;">
                <div class="empty-icon-wrap">
                    <i data-lucide="image-off" class="icon-lg"></i>
                </div>
                <h3>Infografis tidak ditemukan</h3>
                <p>Coba gunakan kata kunci pencarian yang lain atau ubah pilihan kategori tema.</p>
                <button type="button" id="btn-reset-infografis-filter" class="btn-secondary-pub">
                    <i data-lucide="rotate-ccw" class="icon-xs"></i>
                    <span>Reset Filter</span>
                </button>
            </div>

        </div>
    </section>
</div>

<!-- Modal Pratinjau / Lightbox Infografis Lengkap -->
<div class="pub-modal-backdrop" id="infografis-modal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="pub-modal-container pub-modal-large">
        <div class="pub-modal-header">
            <div class="pub-modal-meta">
                <span class="pub-badge" id="modal-info-category">Kategori</span>
                <span class="pub-date" id="modal-info-date">Tanggal</span>
                <span class="pub-badge-neutral">Format HD PNG/PDF</span>
            </div>
            <button type="button" class="pub-modal-close" id="btn-close-info-modal" aria-label="Tutup modal">
                <i data-lucide="x" class="icon-sm"></i>
            </button>
        </div>

        <div class="pub-modal-body">
            <h2 class="pub-modal-title" id="modal-info-title">Judul Infografis</h2>
            <p class="pub-modal-desc-subtle" id="modal-info-desc"></p>

            <!-- Large Visual Infographic Sheet -->
            <div class="infografis-sheet" id="modal-info-sheet">
                <div class="sheet-hero-stat">
                    <div class="sheet-stat-header">
                        <span class="sheet-category-tag" id="modal-info-sheet-cat">INFOGRAFIS PEMBANGUNAN</span>
                        <span class="sheet-badge-verified">
                            <i data-lucide="check-circle" class="icon-xs"></i>
                            Terverifikasi Satu Data
                        </span>
                    </div>
                    <div class="sheet-big-metric">
                        <div class="metric-number-display" id="modal-info-sheet-number">324.512</div>
                        <div class="metric-unit-display" id="modal-info-sheet-unit">Jiwa Penduduk</div>
                    </div>
                    <div class="sheet-submetric-pill" id="modal-info-sheet-sub">Rasio Jenis Kelamin: 104,8</div>
                </div>

                <div class="sheet-breakdown-section">
                    <h3 class="sheet-section-title">
                        <i data-lucide="layers" class="icon-xs text-primary"></i>
                        Rincian Variabel & Indikator Kunci
                    </h3>
                    <div class="sheet-grid-points" id="modal-info-highlights-grid">
                        <!-- Item rincian via JS -->
                    </div>
                </div>

                <div class="sheet-footer-bar">
                    <div class="sheet-source-info">
                        <i data-lucide="building-2" class="icon-xs"></i>
                        <span id="modal-info-source">Sumber: BPS Kabupaten Bangka</span>
                    </div>
                    <span class="sheet-watermark">Portal Satu Data Kab. Bangka</span>
                </div>
            </div>
        </div>

        <div class="pub-modal-footer">
            <div class="modal-footer-left">
                <button type="button" class="btn-primary-pub" id="btn-modal-download-png">
                    <i data-lucide="download" class="icon-xs"></i>
                    <span>Unduh Gambar (PNG)</span>
                </button>
                <button type="button" class="btn-secondary-pub" id="btn-modal-download-pdf">
                    <i data-lucide="file-down" class="icon-xs"></i>
                    <span>Unduh Dokumen (PDF)</span>
                </button>
            </div>

            <div class="modal-footer-right">
                <button type="button" class="btn-secondary-pub" id="btn-modal-share-info">
                    <i data-lucide="share-2" class="icon-xs"></i>
                    <span>Salin Tautan</span>
                </button>
                <button type="button" class="btn-secondary-pub" id="btn-modal-close-info">
                    <span>Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Raw data JSON untuk interaktivitas modal cepat -->
<script id="infografis-data-json" type="application/json">
    {!! json_encode($items) !!}
</script>
@endsection
