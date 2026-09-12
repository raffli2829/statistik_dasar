@extends('layouts.app')

@section('title', 'Berita Statistik - Satu Data Kabupaten Bangka')
@section('meta_description', 'Informasi dan rilis berita terkini seputar data statistik Kabupaten Bangka terverifikasi BPS.')

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
                <span class="breadcrumb-current">Berita</span>
            </nav>

            <div class="pub-hero-text">
                <div class="pub-hero-icon-wrap">
                    <i data-lucide="newspaper" class="icon-lg"></i>
                </div>
                <div>
                    <h1 class="pub-hero-title">Berita Statistik Daerah</h1>
                    <p class="pub-hero-desc">Informasi rilis statistik resmi, pemutakhiran Satu Data Indonesia, dan kegiatan perstatistikan di Kabupaten Bangka.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sub-Navigasi 5 Halaman Publikasi -->
    @include('publikasi.partials.nav')

    <!-- Konten Utama Berita -->
    <section class="pub-content">
        <div class="container">

            @php
                $headlineItem = collect($items)->firstWhere('is_headline', true) ?? $items[0];
            @endphp

            <!-- 1. Headline / Berita Utama Banner -->
            <div class="pub-headline-card" id="headline-section">
                <div class="pub-headline-badge-bar">
                    <span class="pub-badge-pulse">
                        <span class="pulse-dot"></span>
                        BERITA UTAMA TERKINI
                    </span>
                    <span class="pub-headline-date">
                        <i data-lucide="calendar" class="icon-xs"></i>
                        {{ $headlineItem['tanggal'] }}
                    </span>
                </div>

                <div class="pub-headline-content">
                    <div class="pub-headline-info">
                        <div class="pub-headline-meta-top">
                            <span class="pub-badge pub-badge-blue">{{ $headlineItem['kategori'] }}</span>
                            <span class="pub-readtime">
                                <i data-lucide="clock" class="icon-xs"></i>
                                {{ $headlineItem['waktu_baca'] }}
                            </span>
                        </div>
                        <h2 class="pub-headline-title">{{ $headlineItem['judul'] }}</h2>
                        <p class="pub-headline-excerpt">{{ $headlineItem['ringkasan'] }}</p>
                        
                        <div class="pub-headline-tags">
                            @foreach($headlineItem['tags'] as $tag)
                            <span class="pub-tag">#{{ $tag }}</span>
                            @endforeach
                        </div>

                        <div class="pub-headline-action">
                            <button type="button" 
                                    class="btn-primary-pub btn-read-news" 
                                    data-news-id="{{ $headlineItem['id'] }}">
                                <i data-lucide="book-open" class="icon-xs"></i>
                                <span>Baca Berita Lengkap</span>
                            </button>
                            <button type="button" 
                                    class="btn-secondary-pub btn-share-news" 
                                    data-title="{{ $headlineItem['judul'] }}"
                                    data-id="{{ $headlineItem['id'] }}">
                                <i data-lucide="share-2" class="icon-xs"></i>
                                <span>Bagikan</span>
                            </button>
                        </div>
                    </div>

                    <div class="pub-headline-visual" aria-hidden="true">
                        <div class="headline-graphic-box">
                            <div class="graphic-icon-wrap">
                                <i data-lucide="{{ $headlineItem['ikon'] }}" class="icon-xl"></i>
                            </div>
                            <span class="graphic-source">{{ $headlineItem['sumber'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Kontrol Filter & Pencarian -->
            <div class="pub-controls-bar">
                <!-- Filter Pills -->
                <div class="pub-filter-pills" id="news-filter-pills" role="tablist">
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

                <!-- Live Search Box & Sort -->
                <div class="pub-search-group">
                    <div class="pub-search-box">
                        <i data-lucide="search" class="icon-xs search-icon"></i>
                        <input type="text" 
                               id="search-news-input" 
                               placeholder="Cari judul berita atau topik..." 
                               class="pub-search-input"
                               autocomplete="off">
                        <button type="button" id="clear-news-search" class="search-clear-btn" style="display: none;" title="Hapus pencarian">
                            <i data-lucide="x" class="icon-xs"></i>
                        </button>
                    </div>

                    <div class="pub-sort-select-wrap">
                        <select id="sort-news-select" class="pub-sort-select" aria-label="Urutkan Berita">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Counter Info -->
            <div class="pub-result-meta">
                <span id="news-count-text">Menampilkan {{ count($items) }} berita</span>
            </div>

            <!-- 3. Daftar Kartu Berita -->
            <div class="pub-list" id="news-list-container">
                @foreach($items as $index => $item)
                <article class="pub-card pub-card-horizontal news-item-card" 
                         data-category="{{ $item['kategori'] }}"
                         data-title="{{ strtolower($item['judul']) }}"
                         data-tags="{{ strtolower(implode(' ', $item['tags'])) }}"
                         data-date-index="{{ $index }}"
                         data-id="{{ $item['id'] }}">
                    <div class="pub-card-accent" style="background: var(--primary);"></div>
                    <div class="pub-card-body">
                        <div class="pub-card-meta">
                            <span class="pub-badge">{{ $item['kategori'] }}</span>
                            <span class="pub-date">
                                <i data-lucide="calendar" class="icon-xs"></i>
                                {{ $item['tanggal'] }}
                            </span>
                            <span class="pub-readtime">
                                <i data-lucide="clock" class="icon-xs"></i>
                                {{ $item['waktu_baca'] }}
                            </span>
                        </div>
                        <h2 class="pub-card-title">{{ $item['judul'] }}</h2>
                        <p class="pub-card-excerpt">{{ $item['ringkasan'] }}</p>
                        
                        <div class="pub-card-footer">
                            <span class="pub-source">
                                <i data-lucide="building-2" class="icon-xs"></i>
                                {{ $item['sumber'] }}
                            </span>

                            <div class="pub-card-actions-right">
                                <button type="button" 
                                        class="btn-text-action btn-read-news" 
                                        data-news-id="{{ $item['id'] }}">
                                    <span>Baca Berita</span>
                                    <i data-lucide="arrow-right" class="icon-xs"></i>
                                </button>
                                <button type="button" 
                                        class="btn-icon-subtle btn-share-news" 
                                        title="Bagikan tautan"
                                        data-title="{{ $item['judul'] }}"
                                        data-id="{{ $item['id'] }}">
                                    <i data-lucide="share-2" class="icon-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Empty State bila hasil cari nihil -->
            <div id="news-empty-state" class="pub-empty-state" style="display: none;">
                <div class="empty-icon-wrap">
                    <i data-lucide="search-x" class="icon-lg"></i>
                </div>
                <h3>Tidak ada berita yang sesuai</h3>
                <p>Coba gunakan kata kunci pencarian lain atau ubah pilihan filter kategori.</p>
                <button type="button" id="btn-reset-news-filter" class="btn-secondary-pub">
                    <i data-lucide="rotate-ccw" class="icon-xs"></i>
                    <span>Reset Filter</span>
                </button>
            </div>

        </div>
    </section>
</div>

<!-- Modal Baca Berita Lengkap -->
<div class="pub-modal-backdrop" id="news-modal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="pub-modal-container">
        <div class="pub-modal-header">
            <div class="pub-modal-meta">
                <span class="pub-badge" id="modal-news-category">Kategori</span>
                <span class="pub-date" id="modal-news-date">Tanggal</span>
                <span class="pub-readtime" id="modal-news-readtime">Waktu Baca</span>
            </div>
            <button type="button" class="pub-modal-close" id="btn-close-news-modal" aria-label="Tutup modal">
                <i data-lucide="x" class="icon-sm"></i>
            </button>
        </div>

        <div class="pub-modal-body">
            <h2 class="pub-modal-title" id="modal-news-title">Judul Berita</h2>
            <div class="pub-modal-source">
                <i data-lucide="building-2" class="icon-xs"></i>
                <span id="modal-news-source">Sumber: BPS Kabupaten Bangka</span>
            </div>

            <div class="pub-modal-text" id="modal-news-content">
                <!-- Konten paragraf berita -->
            </div>

            <div class="pub-modal-tags" id="modal-news-tags">
                <!-- Tags -->
            </div>
        </div>

        <div class="pub-modal-footer">
            <button type="button" class="btn-secondary-pub" id="btn-modal-share-news">
                <i data-lucide="copy" class="icon-xs"></i>
                <span>Salin Tautan</span>
            </button>
            <button type="button" class="btn-primary-pub" id="btn-modal-close-news">
                <span>Tutup</span>
            </button>
        </div>
    </div>
</div>

<!-- Raw data JSON untuk interaktivitas modal yang cepat dan aman -->
<script id="news-data-json" type="application/json">
    {!! json_encode($items) !!}
</script>
@endsection
