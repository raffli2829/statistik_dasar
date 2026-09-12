@extends('layouts.app')

@section('title', 'Statistik Sektoral OPD - Satu Data Kabupaten Bangka')
@section('meta_description', 'Publikasi dan katalog dataset statistik sektoral resmi yang dihasilkan Organisasi Perangkat Daerah Kabupaten Bangka.')

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
                <span class="breadcrumb-current">Statistik Sektoral OPD</span>
            </nav>

            <div class="pub-hero-text">
                <div class="pub-hero-icon-wrap">
                    <i data-lucide="layers" class="icon-lg"></i>
                </div>
                <div>
                    <h1 class="pub-hero-title">Statistik Sektoral OPD</h1>
                    <p class="pub-hero-desc">Katalog publikasi data sektoral yang diproduksi dan dimutakhirkan oleh Organisasi Perangkat Daerah (OPD) Kabupaten Bangka.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sub-Navigasi 5 Halaman Publikasi -->
    @include('publikasi.partials.nav')

    <!-- Konten Utama Statistik Sektoral OPD -->
    <section class="pub-content">
        <div class="container">

            <!-- 1. KPI Metrik Satu Data OPD -->
            <div class="pub-kpi-grid">
                <div class="pub-kpi-card">
                    <div class="kpi-icon-wrap" style="background: rgba(59, 130, 246, 0.12); color: #3B82F6;">
                        <i data-lucide="building-2" class="icon-sm"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-value">{{ count($items) }} Instansi</span>
                        <span class="kpi-label">OPD Produsen Data Aktif</span>
                    </div>
                </div>

                <div class="pub-kpi-card">
                    <div class="kpi-icon-wrap" style="background: rgba(16, 185, 129, 0.12); color: #10B981;">
                        <i data-lucide="database" class="icon-sm"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-value">62+ Dataset</span>
                        <span class="kpi-label">Dataset Terbuka Tersedia</span>
                    </div>
                </div>

                <div class="pub-kpi-card">
                    <div class="kpi-icon-wrap" style="background: rgba(245, 158, 11, 0.12); color: #F59E0B;">
                        <i data-lucide="check-check" class="icon-sm"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-value">100% Terstandar</span>
                        <span class="kpi-label">Kesesuaian Metadata SDI</span>
                    </div>
                </div>

                <div class="pub-kpi-card">
                    <div class="kpi-icon-wrap" style="background: rgba(139, 92, 246, 0.12); color: #8B5CF6;">
                        <i data-lucide="refresh-cw" class="icon-sm"></i>
                    </div>
                    <div class="kpi-body">
                        <span class="kpi-value">Semester I 2024</span>
                        <span class="kpi-label">Periode Pemutakhiran</span>
                    </div>
                </div>
            </div>

            <!-- 2. Kontrol Filter & Pencarian OPD -->
            <div class="pub-controls-bar">
                <div class="pub-filter-pills" id="opd-filter-pills" role="tablist">
                    @foreach($klasterList as $klaster)
                    <button type="button" 
                            class="pub-pill-btn {{ $loop->first ? 'active' : '' }}" 
                            data-filter="{{ $klaster }}"
                            role="tab"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                        {{ $klaster }}
                    </button>
                    @endforeach
                </div>

                <div class="pub-search-group">
                    <div class="pub-search-box">
                        <i data-lucide="search" class="icon-xs search-icon"></i>
                        <input type="text" 
                               id="search-opd-input" 
                               placeholder="Cari nama dinas atau topik dataset..." 
                               class="pub-search-input"
                               autocomplete="off">
                        <button type="button" id="clear-opd-search" class="search-clear-btn" style="display: none;" title="Hapus pencarian">
                            <i data-lucide="x" class="icon-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Counter Info -->
            <div class="pub-result-meta">
                <span id="opd-count-text">Menampilkan {{ count($items) }} OPD produsen data</span>
            </div>

            <!-- 3. Grid Direktori OPD (2 Kolom) -->
            <div class="pub-grid pub-grid-2" id="opd-grid-container">
                @foreach($items as $item)
                <article class="pub-card pub-card-opd opd-item-card" 
                         data-cluster="{{ $item['klaster'] }}"
                         data-name="{{ strtolower($item['nama']) }}"
                         data-acronym="{{ strtolower($item['akronim']) }}"
                         data-desc="{{ strtolower($item['deskripsi']) }}"
                         data-id="{{ $item['id'] }}">
                    <div class="pub-card-body">
                        <!-- Header OPD -->
                        <div class="pub-opd-header">
                            <div class="pub-opd-icon" style="background: {{ $item['warna'] }}18; color: {{ $item['warna'] }};">
                                <i data-lucide="{{ $item['ikon'] }}" class="icon-md"></i>
                            </div>
                            <div class="pub-opd-info">
                                <div class="pub-opd-meta-row">
                                    <span class="pub-badge" style="background: {{ $item['warna'] }}18; color: {{ $item['warna'] }};">
                                        {{ $item['klaster'] }}
                                    </span>
                                    <span class="pub-badge-neutral">{{ $item['akronim'] }}</span>
                                </div>
                                <h2 class="pub-card-title">{{ $item['nama'] }}</h2>
                            </div>
                        </div>

                        <p class="pub-card-excerpt">{{ $item['deskripsi'] }}</p>

                        <!-- Address Info -->
                        <div class="pub-opd-meta-details">
                            <div class="opd-detail-item">
                                <i data-lucide="map-pin" class="icon-xs text-muted"></i>
                                <span>{{ $item['alamat'] }}</span>
                            </div>
                            <div class="opd-detail-item">
                                <i data-lucide="clock" class="icon-xs text-muted"></i>
                                <span>Pembaruan: {{ $item['terakhir_update'] }}</span>
                            </div>
                        </div>

                        <!-- Pratinjau Daftar Dataset -->
                        <div class="pub-opd-datasets-preview">
                            <div class="datasets-preview-header">
                                <span class="preview-title">
                                    <i data-lucide="file-spreadsheet" class="icon-xs text-primary"></i>
                                    Sampel Dataset Tersedia:
                                </span>
                                <span class="pub-dataset-count">
                                    <i data-lucide="database" class="icon-xs"></i>
                                    {{ $item['jumlah_dataset'] }} Total Dataset
                                </span>
                            </div>

                            <ul class="datasets-mini-list">
                                @foreach(array_slice($item['datasets'], 0, 2) as $ds)
                                <li class="dataset-mini-item">
                                    <span class="dataset-name">{{ $ds['judul'] }}</span>
                                    <div class="dataset-formats">
                                        @foreach($ds['format'] as $fmt)
                                        <span class="badge-fmt">{{ $fmt }}</span>
                                        @endforeach
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Card Footer Action -->
                        <div class="pub-card-footer">
                            <button type="button" 
                                    class="btn-primary-pub w-full btn-open-opd-catalog" 
                                    data-opd-id="{{ $item['id'] }}">
                                <i data-lucide="folder-open" class="icon-xs"></i>
                                <span>Buka Katalog Dataset ({{ count($item['datasets']) }}+ Data)</span>
                            </button>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Empty State bila pencarian nihil -->
            <div id="opd-empty-state" class="pub-empty-state" style="display: none;">
                <div class="empty-icon-wrap">
                    <i data-lucide="building-2" class="icon-lg"></i>
                </div>
                <h3>OPD tidak ditemukan</h3>
                <p>Coba gunakan kata kunci pencarian yang lain atau ubah pilihan filter bidang urusan.</p>
                <button type="button" id="btn-reset-opd-filter" class="btn-secondary-pub">
                    <i data-lucide="rotate-ccw" class="icon-xs"></i>
                    <span>Reset Filter</span>
                </button>
            </div>

        </div>
    </section>
</div>

<!-- Modal Katalog Dataset OPD Interaktif -->
<div class="pub-modal-backdrop" id="opd-modal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="pub-modal-container pub-modal-large">
        <div class="pub-modal-header">
            <div class="pub-modal-meta">
                <span class="pub-badge" id="modal-opd-klaster">Klaster</span>
                <span class="pub-badge-neutral" id="modal-opd-acronym">Akronim</span>
                <span class="pub-date" id="modal-opd-updated">Pembaruan</span>
            </div>
            <button type="button" class="pub-modal-close" id="btn-close-opd-modal" aria-label="Tutup modal">
                <i data-lucide="x" class="icon-sm"></i>
            </button>
        </div>

        <div class="pub-modal-body">
            <div class="opd-modal-profile">
                <div class="opd-modal-icon-wrap" id="modal-opd-icon-box">
                    <i data-lucide="building-2" class="icon-lg"></i>
                </div>
                <div>
                    <h2 class="pub-modal-title" id="modal-opd-name">Nama Dinas</h2>
                    <p class="pub-modal-desc-subtle" id="modal-opd-desc"></p>
                </div>
            </div>

            <!-- Sub Filter Pencarian Dataset di dalam OPD -->
            <div class="modal-dataset-search-bar">
                <div class="pub-search-box w-full">
                    <i data-lucide="search" class="icon-xs search-icon"></i>
                    <input type="text" 
                           id="modal-dataset-search-input" 
                           placeholder="Saring dataset di dinas ini..." 
                           class="pub-search-input"
                           autocomplete="off">
                </div>
            </div>

            <!-- Tabel / Daftar Dataset Lengkap OPD -->
            <div class="modal-dataset-list" id="modal-dataset-items-container">
                <!-- Diisi dinamis via JS -->
            </div>
        </div>

        <div class="pub-modal-footer">
            <div class="modal-footer-left">
                <button type="button" class="btn-secondary-pub" id="btn-copy-opd-metadata">
                    <i data-lucide="copy" class="icon-xs"></i>
                    <span>Salin Info Metadata OPD</span>
                </button>
            </div>
            <div class="modal-footer-right">
                <button type="button" class="btn-primary-pub" id="btn-close-opd-modal-action">
                    <span>Tutup Katalog</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Raw data JSON untuk interaktivitas modal cepat -->
<script id="opd-data-json" type="application/json">
    {!! json_encode($items) !!}
</script>
@endsection
