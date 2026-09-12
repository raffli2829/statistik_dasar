@extends('layouts.app')

@section('title', 'Artikel & Analisis Statistik - Satu Data Kabupaten Bangka')
@section('meta_description', 'Kajian mendalam dan analisis berbasis data statistik makro dan sektoral Kabupaten Bangka.')

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
                    <span class="breadcrumb-current">Artikel</span>
                </nav>

                <div class="pub-hero-text">
                    <div class="pub-hero-icon-wrap">
                        <i data-lucide="file-text" class="icon-lg"></i>
                    </div>
                    <div>
                        <h1 class="pub-hero-title">Artikel & Analisis Data</h1>
                        <p class="pub-hero-desc">Kajian mendalam, analisis struktural, dan perspektif berbasis data
                            statistik pembangunan di Kabupaten Bangka.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sub-Navigasi 5 Halaman Publikasi -->
        @include('publikasi.partials.nav')

        <!-- Konten Utama Artikel -->
        <section class="pub-content">
            <div class="container">

                <!-- Kontrol Filter, Bookmark, & Pencarian -->p
                <div class="pub-controls-bar">
                    <!-- Topic Filter Pills & Bookmark Filter -->
                    <div class="pub-filter-pills" id="article-filter-pills" role="tablist">
                        @foreach($kategoriList as $kat)
                            <button type="button" class="pub-pill-btn {{ $loop->first ? 'active' : '' }}"
                                data-filter="{{ $kat }}" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $kat }}
                            </button>
                        @endforeach

                        <!-- Tombol Khusus Artikel Tersimpan (Bookmark) -->
                        <button type="button" class="pub-pill-btn pub-pill-bookmark" id="filter-bookmarked-btn"
                            data-filter="saved" role="tab" aria-selected="false">
                            <i data-lucide="bookmark" class="icon-xs"></i>
                            <span>Tersimpan</span>
                            <span class="badge-saved-count" id="saved-articles-count">0</span>
                        </button>
                    </div>

                    <!-- Live Search Box -->
                    <div class="pub-search-group">
                        <div class="pub-search-box">
                            <i data-lucide="search" class="icon-xs search-icon"></i>
                            <input type="text" id="search-article-input" placeholder="Cari judul, topik, atau penulis..."
                                class="pub-search-input" autocomplete="off">
                            <button type="button" id="clear-article-search" class="search-clear-btn" style="display: none;"
                                title="Hapus pencarian">
                                <i data-lucide="x" class="icon-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Counter Info -->
                <div class="pub-result-meta">
                    <span id="article-count-text">Menampilkan {{ count($items) }} artikel kajian</span>
                </div>

                <!-- Grid Artikel (3 Kolom Desktop) -->
                <div class="pub-grid pub-grid-3" id="article-grid-container">
                    @foreach($items as $item)
                        <article class="pub-card article-item-card" data-category="{{ $item['kategori'] }}"
                            data-title="{{ strtolower($item['judul']) }}" data-author="{{ strtolower($item['penulis']) }}"
                            data-id="{{ $item['id'] }}">
                            <div class="pub-card-body">
                                <div class="pub-card-meta-top">
                                    <div class="pub-card-meta">
                                        <span class="pub-badge pub-badge-blue">{{ $item['kategori'] }}</span>
                                        <span class="pub-readtime">
                                            <i data-lucide="clock" class="icon-xs"></i>
                                            {{ $item['waktu_baca'] }}
                                        </span>
                                    </div>

                                    <!-- Tombol Bookmark Cepat -->
                                    <button type="button" class="btn-icon-bookmark btn-toggle-bookmark"
                                        data-id="{{ $item['id'] }}" title="Simpan artikel ke daftar bacaan"
                                        aria-label="Simpan artikel">
                                        <i data-lucide="bookmark" class="icon-xs"></i>
                                    </button>
                                </div>

                                <h2 class="pub-card-title">{{ $item['judul'] }}</h2>
                                <p class="pub-card-excerpt">{{ $item['ringkasan'] }}</p>

                                <!-- Poin Kunci Highlight -->
                                <div class="pub-card-highlight-box">
                                    <span class="highlight-label">
                                        <i data-lucide="sparkles" class="icon-xs"></i>
                                        Temuan Utama:
                                    </span>
                                    <p class="highlight-text">{{ $item['poin_kunci'][0] }}</p>
                                </div>

                                <div class="pub-card-footer">
                                    <div class="pub-author-wrap">
                                        <div class="pub-author-avatar">
                                            <i data-lucide="user" class="icon-xs"></i>
                                        </div>
                                        <div class="pub-author-info">
                                            <span class="pub-author-name">{{ $item['penulis'] }}</span>
                                            <span class="pub-author-date">{{ $item['tanggal'] }}</span>
                                        </div>
                                    </div>

                                    <button type="button" class="btn-text-action btn-read-article"
                                        data-article-id="{{ $item['id'] }}">
                                        <span>Baca Analisis</span>
                                        <i data-lucide="arrow-right" class="icon-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Empty State bila hasil cari / filter nihil -->
                <div id="article-empty-state" class="pub-empty-state" style="display: none;">
                    <div class="empty-icon-wrap">
                        <i data-lucide="file-search" class="icon-lg"></i>
                    </div>
                    <h3>Tidak ada artikel yang sesuai</h3>
                    <p>Coba gunakan kata kunci pencarian yang lain atau ubah pilihan kategori.</p>
                    <button type="button" id="btn-reset-article-filter" class="btn-secondary-pub">
                        <i data-lucide="rotate-ccw" class="icon-xs"></i>
                        <span>Reset Filter</span>
                    </button>
                </div>

            </div>
        </section>
    </div>

    <!-- Modal Baca Analisis Artikel Lengkap -->
    <div class="pub-modal-backdrop" id="article-modal" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="pub-modal-container pub-modal-large">
            <div class="pub-modal-header">
                <div class="pub-modal-meta">
                    <span class="pub-badge pub-badge-blue" id="modal-article-category">Kategori</span>
                    <span class="pub-readtime" id="modal-article-readtime">Waktu Baca</span>
                    <span class="pub-date" id="modal-article-date">Tanggal</span>
                </div>
                <button type="button" class="pub-modal-close" id="btn-close-article-modal" aria-label="Tutup modal">
                    <i data-lucide="x" class="icon-sm"></i>
                </button>
            </div>

            <div class="pub-modal-body">
                <h2 class="pub-modal-title" id="modal-article-title">Judul Analisis</h2>

                <div class="pub-modal-author-bar">
                    <div class="pub-author-wrap">
                        <div class="pub-author-avatar">
                            <i data-lucide="user" class="icon-xs"></i>
                        </div>
                        <div>
                            <span class="pub-author-name" id="modal-article-author">Penulis</span>
                            <span class="pub-meta-subtle">Kajian Kebijakan Berbasis Data</span>
                        </div>
                    </div>
                    <div class="pub-modal-views">
                        <i data-lucide="eye" class="icon-xs"></i>
                        <span id="modal-article-views">1.240</span> Pembaca
                    </div>
                </div>

                <!-- Box Temuan Kunci -->
                <div class="article-insights-box">
                    <div class="insights-header">
                        <i data-lucide="check-circle-2" class="icon-sm text-primary"></i>
                        <h3>Poin-Poin Temuan Kunci</h3>
                    </div>
                    <ul class="insights-list" id="modal-article-keypoints">
                        <!-- Dinamis via JS -->
                    </ul>
                </div>

                <!-- Konten Lengkap -->
                <div class="pub-modal-text" id="modal-article-content">
                    <!-- Paragraf analisis -->
                </div>

                <!-- Box Rekomendasi Kebijakan -->
                <div class="article-policy-box">
                    <div class="policy-header">
                        <i data-lucide="lightbulb" class="icon-sm text-warning"></i>
                        <h3>Implikasi & Rekomendasi Kebijakan Daerah</h3>
                    </div>
                    <p id="modal-article-recommendation"></p>
                </div>
            </div>

            <div class="pub-modal-footer">
                <div class="modal-footer-left">
                    <button type="button" class="btn-secondary-pub" id="btn-modal-bookmark-article">
                        <i data-lucide="bookmark" class="icon-xs"></i>
                        <span id="modal-bookmark-label">Simpan Artikel</span>
                    </button>
                    <button type="button" class="btn-secondary-pub" id="btn-modal-print-article">
                        <i data-lucide="printer" class="icon-xs"></i>
                        <span>Cetak Kajian</span>
                    </button>
                </div>

                <div class="modal-footer-right">
                    <button type="button" class="btn-secondary-pub" id="btn-modal-share-article">
                        <i data-lucide="share-2" class="icon-xs"></i>
                        <span>Bagikan</span>
                    </button>
                    <button type="button" class="btn-primary-pub" id="btn-modal-close-article">
                        <span>Tutup</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Raw data JSON untuk interaktivitas modal cepat -->
    <script id="article-data-json" type="application/json">
        {!! json_encode($items) !!}
    </script>
@endsection