@extends('layouts.app')

@section('title', $article['judul'] . ' - Satu Data Kabupaten Bangka')
@section('meta_description', Str::limit($article['ringkasan'], 160))

@section('content')
    <div class="publikasi-page artikel-detail-page">
        <!-- Konten Baca Artikel Lengkap -->
        <main class="pub-content artikel-reading-section">
            <div class="container">
                <!-- Header Artikel -->
                <header class="artikel-detail-hero">
                    <nav class="breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('statistik.index') }}" class="breadcrumb-link">Statistik Dasar</a>
                        <span class="breadcrumb-sep">/</span>
                        <a href="{{ route('publikasi.artikel') }}" class="breadcrumb-link">Publikasi</a>
                        <span class="breadcrumb-sep">/</span>
                        <a href="{{ route('publikasi.artikel') }}" class="breadcrumb-link">Artikel</a>
                        <span class="breadcrumb-sep">/</span>
                        <span class="breadcrumb-current">{{ Str::limit($article['judul'], 45) }}</span>
                    </nav>

                    <div class="artikel-detail-hero-content">
                        <div class="artikel-meta-tags">
                            <span class="pub-badge pub-badge-blue">{{ $article['kategori'] }}</span>
                            <span class="artikel-hero-pill">
                                <i data-lucide="calendar" class="icon-xs"></i>
                                <span>{{ $article['tanggal'] }}</span>
                            </span>
                            <span class="artikel-hero-pill">
                                <i data-lucide="eye" class="icon-xs"></i>
                                <span>{{ number_format($article['views'], 0, ',', '.') }} Pembaca</span>
                            </span>
                        </div>

                        <h1 class="artikel-detail-title">{{ $article['judul'] }}</h1>
                        <p class="artikel-detail-excerpt">{{ $article['ringkasan'] }}</p>

                        <!-- Author Info & Action Bar -->
                        <div class="artikel-author-hero-bar">
                            <div class="pub-author-wrap">
                                <div class="pub-author-avatar">
                                    <i data-lucide="user-check" class="icon-sm"></i>
                                </div>
                                <div>
                                    <span class="pub-author-name">{{ $article['penulis'] }}</span>
                                    <span class="pub-meta-subtle">Kajian Kebijakan & Analisis Pembangunan Daerah</span>
                                </div>
                            </div>

                            <div class="artikel-action-tools">
                                <button type="button" class="btn-secondary-pub" id="btn-detail-share" title="Bagikan Tautan Kajian">
                                    <i data-lucide="share-2" class="icon-xs"></i>
                                    <span>Bagikan</span>
                                </button>
                                <button type="button" class="btn-secondary-pub" id="btn-detail-print" onclick="window.print()" title="Cetak Kajian PDF">
                                    <i data-lucide="printer" class="icon-xs"></i>
                                    <span>Cetak</span>
                                </button>
                                <a href="{{ route('publikasi.artikel') }}" class="btn-secondary-pub" title="Kembali ke Daftar">
                                    <i data-lucide="arrow-left" class="icon-xs"></i>
                                    <span>Daftar Artikel</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="artikel-reading-layout">
                    <!-- Kolom Utama Bacaan -->
                    <article class="artikel-main-column">
                        <!-- Box Poin Kunci / Temuan Utama -->
                        @if(!empty($article['poin_kunci']))
                            <div class="article-insights-box mb-6">
                                <div class="insights-header">
                                    <i data-lucide="check-circle-2" class="icon-sm text-primary"></i>
                                    <h3>Poin-Poin Temuan Kunci</h3>
                                </div>
                                <ul class="insights-list">
                                    @foreach($article['poin_kunci'] as $poin)
                                        <li>{{ $poin }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Teks Kajian / Isi Lengkap -->
                        <div class="artikel-body-text">
                            @foreach(explode("\n\n", $article['isi']) as $paragraf)
                                @if(trim($paragraf))
                                    <p>{{ trim($paragraf) }}</p>
                                @endif
                            @endforeach
                        </div>

                        <!-- Box Implikasi & Rekomendasi Kebijakan -->
                        @if(!empty($article['rekomendasi']))
                            <div class="article-policy-box mt-6">
                                <div class="policy-header">
                                    <i data-lucide="lightbulb" class="icon-sm text-warning"></i>
                                    <h3>Implikasi & Rekomendasi Kebijakan Daerah</h3>
                                </div>
                                <p>{{ $article['rekomendasi'] }}</p>
                            </div>
                        @endif

                        <!-- Footer Navigasi & Share Bottom -->
                        <div class="artikel-bottom-nav">
                            <a href="{{ route('publikasi.artikel') }}" class="btn-back-to-list">
                                <i data-lucide="arrow-left" class="icon-xs"></i>
                                <span>Kembali ke Katalog Artikel</span>
                            </a>

                            <div class="artikel-bottom-share">
                                <span class="share-label">Bagikan analisis:</span>
                                <button type="button" class="btn-share-icon" id="btn-share-copy" title="Salin tautan artikel">
                                    <i data-lucide="link" class="icon-xs"></i>
                                </button>
                                <button type="button" class="btn-share-icon" onclick="window.print()" title="Cetak dokumen analisis">
                                    <i data-lucide="printer" class="icon-xs"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Sidebar: Info Kajian & Artikel Terkait -->
                    <aside class="artikel-sidebar">
                        <!-- Metadata Card -->
                        <div class="artikel-sidebar-card">
                            <h3 class="sidebar-card-title">
                                <i data-lucide="info" class="icon-xs text-primary"></i>
                                <span>Tentang Kajian Ini</span>
                            </h3>
                            <div class="sidebar-meta-list">
                                <div class="sidebar-meta-row">
                                    <span class="sidebar-meta-label">Kategori</span>
                                    <span class="sidebar-meta-val"><span class="pub-badge pub-badge-blue">{{ $article['kategori'] }}</span></span>
                                </div>
                                <div class="sidebar-meta-row">
                                    <span class="sidebar-meta-label">Diterbitkan</span>
                                    <span class="sidebar-meta-val">{{ $article['tanggal'] }}</span>
                                </div>
                                <div class="sidebar-meta-row">
                                    <span class="sidebar-meta-label">Penulis / Unit</span>
                                    <span class="sidebar-meta-val">{{ $article['penulis'] }}</span>
                                </div>
                                <div class="sidebar-meta-row">
                                    <span class="sidebar-meta-label">Sumber Data</span>
                                    <span class="sidebar-meta-val">BPS & SDI Bangka</span>
                                </div>
                            </div>
                        </div>

                        <!-- Artikel Analisis Terkait -->
                        @if(!empty($relatedArticles))
                            <div class="artikel-sidebar-card">
                                <h3 class="sidebar-card-title">
                                    <i data-lucide="book-open" class="icon-xs text-primary"></i>
                                    <span>Analisis Terkait Lainnya</span>
                                </h3>
                                <div class="sidebar-related-list">
                                    @foreach($relatedArticles as $rel)
                                        <a href="{{ route('publikasi.artikel.detail', $rel['id']) }}" class="related-article-item">
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
        <span>Tautan artikel berhasil disalin!</span>
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
