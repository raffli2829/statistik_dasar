@extends('layouts.app')

@section('title', $news['judul'] . ' - Satu Data Kabupaten Bangka')
@section('meta_description', Str::limit($news['ringkasan'], 160))

@section('content')
    <div class="publikasi-page artikel-detail-page">
        <!-- Konten Baca Berita Lengkap -->
        <main class="pub-content artikel-reading-section">
            <div class="container">
                <!-- Header Berita -->
                <header class="artikel-detail-hero">
                    <nav class="breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('statistik.index') }}" class="breadcrumb-link">Statistik Dasar</a>
                        <span class="breadcrumb-sep">/</span>
                        <a href="{{ route('publikasi.berita') }}" class="breadcrumb-link">Publikasi</a>
                        <span class="breadcrumb-sep">/</span>
                        <a href="{{ route('publikasi.berita') }}" class="breadcrumb-link">Berita</a>
                        <span class="breadcrumb-sep">/</span>
                        <span class="breadcrumb-current">{{ Str::limit($news['judul'], 45) }}</span>
                    </nav>

                    <div class="artikel-detail-hero-content">
                        <div class="artikel-meta-tags">
                            <span class="pub-badge pub-badge-blue">{{ $news['kategori'] }}</span>
                            <span class="artikel-hero-pill">
                                <i data-lucide="clock" class="icon-xs"></i>
                                <span>{{ $news['waktu_baca'] }}</span>
                            </span>
                            <span class="artikel-hero-pill">
                                <i data-lucide="calendar" class="icon-xs"></i>
                                <span>{{ $news['tanggal'] }}</span>
                            </span>
                        </div>

                        <h1 class="artikel-detail-title">{{ $news['judul'] }}</h1>
                        <p class="artikel-detail-excerpt">{{ $news['ringkasan'] }}</p>

                        <!-- Tags -->
                        @if(!empty($news['tags']))
                            <div class="pub-headline-tags">
                                @foreach($news['tags'] as $tag)
                                    <span class="pub-tag">#{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Source & Action Bar -->
                        <div class="artikel-author-hero-bar">
                            <div class="pub-author-wrap">
                                <div class="pub-author-avatar">
                                    <i data-lucide="building-2" class="icon-sm"></i>
                                </div>
                                <div>
                                    <span class="pub-author-name">{{ $news['sumber'] }}</span>
                                    <span class="pub-meta-subtle">Sumber Berita Statistik Resmi</span>
                                </div>
                            </div>

                            <div class="artikel-action-tools">
                                <button type="button" class="btn-secondary-pub" id="btn-detail-share" title="Bagikan Tautan Berita">
                                    <i data-lucide="share-2" class="icon-xs"></i>
                                    <span>Bagikan</span>
                                </button>
                                <button type="button" class="btn-secondary-pub" id="btn-detail-print" onclick="window.print()" title="Cetak Berita">
                                    <i data-lucide="printer" class="icon-xs"></i>
                                    <span>Cetak</span>
                                </button>
                                <a href="{{ route('publikasi.berita') }}" class="btn-secondary-pub" title="Kembali ke Daftar">
                                    <i data-lucide="arrow-left" class="icon-xs"></i>
                                    <span>Daftar Berita</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="artikel-reading-layout">
                    <!-- Kolom Utama Bacaan -->
                    <article class="artikel-main-column">
                        <!-- Teks Berita / Isi Lengkap -->
                        <div class="artikel-body-text">
                            @foreach(explode("\n\n", $news['isi']) as $paragraf)
                                @if(trim($paragraf))
                                    <p>{{ trim($paragraf) }}</p>
                                @endif
                            @endforeach
                        </div>

                        <!-- Tags di bawah konten -->
                        @if(!empty($news['tags']))
                            <div class="berita-detail-tags">
                                @foreach($news['tags'] as $tag)
                                    <span class="pub-tag">#{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Footer Navigasi & Share Bottom -->
                        <div class="artikel-bottom-nav">
                            <a href="{{ route('publikasi.berita') }}" class="btn-back-to-list">
                                <i data-lucide="arrow-left" class="icon-xs"></i>
                                <span>Kembali ke Daftar Berita</span>
                            </a>

                            <div class="artikel-bottom-share">
                                <span class="share-label">Bagikan berita:</span>
                                <button type="button" class="btn-share-icon" id="btn-share-copy" title="Salin tautan berita">
                                    <i data-lucide="link" class="icon-xs"></i>
                                </button>
                                <button type="button" class="btn-share-icon" onclick="window.print()" title="Cetak berita">
                                    <i data-lucide="printer" class="icon-xs"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Sidebar: Info Berita & Berita Terkait -->
                    <aside class="artikel-sidebar">
                        <!-- Metadata Card -->
                        <div class="artikel-sidebar-card">
                            <h3 class="sidebar-card-title">
                                <i data-lucide="info" class="icon-xs text-primary"></i>
                                <span>Tentang Berita Ini</span>
                            </h3>
                            <div class="sidebar-meta-list">
                                <div class="sidebar-meta-row">
                                    <span class="sidebar-meta-label">Kategori</span>
                                    <span class="sidebar-meta-val"><span class="pub-badge pub-badge-blue">{{ $news['kategori'] }}</span></span>
                                </div>
                                <div class="sidebar-meta-row">
                                    <span class="sidebar-meta-label">Diterbitkan</span>
                                    <span class="sidebar-meta-val">{{ $news['tanggal'] }}</span>
                                </div>
                                <div class="sidebar-meta-row">
                                    <span class="sidebar-meta-label">Estimasi Baca</span>
                                    <span class="sidebar-meta-val">{{ $news['waktu_baca'] }}</span>
                                </div>
                                <div class="sidebar-meta-row">
                                    <span class="sidebar-meta-label">Sumber</span>
                                    <span class="sidebar-meta-val">{{ $news['sumber'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Berita Terkait -->
                        @if(!empty($relatedNews))
                            <div class="artikel-sidebar-card">
                                <h3 class="sidebar-card-title">
                                    <i data-lucide="newspaper" class="icon-xs text-primary"></i>
                                    <span>Berita Terkait Lainnya</span>
                                </h3>
                                <div class="sidebar-related-list">
                                    @foreach($relatedNews as $rel)
                                        <a href="{{ route('publikasi.berita.detail', $rel['id']) }}" class="related-article-item">
                                            <span class="related-category">{{ $rel['kategori'] }}</span>
                                            <h4 class="related-title">{{ $rel['judul'] }}</h4>
                                            <span class="related-date">{{ $rel['tanggal'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </aside>
                </div>
            </div>
        </main>
    </div>

    <!-- Notification Toast for Copy Link -->
    <div id="copy-toast" class="copy-toast" style="display: none;">
        <i data-lucide="check" class="icon-xs"></i>
        <span>Tautan berita berhasil disalin!</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) {
                window.lucide.createIcons();
            }

            const copyBtn = document.getElementById('btn-share-copy');
            const shareBtn = document.getElementById('btn-detail-share');
            const toast = document.getElementById('copy-toast');

            function copyCurrentUrl() {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(window.location.href).then(showToast);
                } else {
                    const temp = document.createElement('input');
                    temp.value = window.location.href;
                    document.body.appendChild(temp);
                    temp.select();
                    document.execCommand('copy');
                    document.body.removeChild(temp);
                    showToast();
                }
            }

            function showToast() {
                if (!toast) return;
                toast.style.display = 'flex';
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => { toast.style.display = 'none'; }, 300);
                }, 2500);
            }

            if (copyBtn) copyBtn.addEventListener('click', copyCurrentUrl);
            if (shareBtn) shareBtn.addEventListener('click', copyCurrentUrl);
        });
    </script>
@endsection
