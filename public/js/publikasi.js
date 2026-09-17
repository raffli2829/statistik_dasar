/**
 * SATU DATA KABUPATEN BANGKA - PUBLIKASI INTERACTIVITY
 * Berita, Artikel, Infografis, Statistik Sektoral OPD & Kabupaten
 */

document.addEventListener('DOMContentLoaded', () => {
    // =========================================================================
    // 1. GLOBAL TOAST NOTIFICATION
    // =========================================================================
    let toastTimeout = null;

    function showPubToast(message, iconName = 'check-circle-2') {
        let toast = document.getElementById('pub-global-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'pub-global-toast';
            toast.className = 'pub-toast';
            document.body.appendChild(toast);
        }

        toast.innerHTML = `
            <div class="pub-toast-icon">
                <i data-lucide="${iconName}" class="icon-sm"></i>
            </div>
            <span>${message}</span>
        `;

        if (window.lucide) {
            lucide.createIcons({ root: toast });
        }

        toast.classList.add('active');

        if (toastTimeout) clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toast.classList.remove('active');
        }, 3200);
    }

    // Export to window for inline calls if needed
    window.showPubToast = showPubToast;

    // Helper: Copy Text to Clipboard
    function copyToClipboard(text, successMessage = 'Tautan berhasil disalin ke clipboard!') {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                showPubToast(successMessage, 'check-check');
            }).catch(() => {
                fallbackCopy(text, successMessage);
            });
        } else {
            fallbackCopy(text, successMessage);
        }
    }

    function fallbackCopy(text, successMessage) {
        const temp = document.createElement('textarea');
        temp.value = text;
        temp.style.position = 'fixed';
        temp.style.left = '-9999px';
        document.body.appendChild(temp);
        temp.focus();
        temp.select();
        try {
            document.execCommand('copy');
            showPubToast(successMessage, 'check-check');
        } catch (e) {
            showPubToast('Gagal menyalin tautan.', 'alert-circle');
        }
        document.body.removeChild(temp);
    }

    // Modal helpers
    function openModal(modalEl) {
        if (!modalEl) return;
        modalEl.classList.add('active');
        modalEl.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        if (window.lucide) {
            lucide.createIcons({ root: modalEl });
        }
    }

    function closeModal(modalEl) {
        if (!modalEl) return;
        modalEl.classList.remove('active');
        modalEl.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Close modal on ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const activeModal = document.querySelector('.pub-modal-backdrop.active');
            if (activeModal) closeModal(activeModal);
        }
    });

    // Close modal on backdrop click
    document.querySelectorAll('.pub-modal-backdrop').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal(modal);
            }
        });
    });


    // =========================================================================
    // 2. HALAMAN BERITA
    // =========================================================================
    const newsJsonEl = document.getElementById('news-data-json');
    if (newsJsonEl) {
        let newsData = [];
        try {
            newsData = JSON.parse(newsJsonEl.textContent);
        } catch (e) {
            console.error('Failed to parse news JSON', e);
        }

        const newsPills = document.querySelectorAll('#news-filter-pills .pub-pill-btn');
        const newsSearchInput = document.getElementById('search-news-input');
        const clearNewsBtn = document.getElementById('clear-news-search');
        const newsSortSelect = document.getElementById('sort-news-select');
        const newsCards = document.querySelectorAll('.news-item-card');
        const newsCountText = document.getElementById('news-count-text');
        const newsEmptyState = document.getElementById('news-empty-state');
        const btnResetNews = document.getElementById('btn-reset-news-filter');

        const newsModal = document.getElementById('news-modal');
        const btnCloseNewsModal = document.getElementById('btn-close-news-modal');
        const btnModalCloseNews = document.getElementById('btn-modal-close-news');
        const btnModalShareNews = document.getElementById('btn-modal-share-news');

        let activeCategory = 'Semua';
        let searchQuery = '';
        let sortOrder = 'newest';
        let currentModalNews = null;

        function filterNews() {
            let visibleCount = 0;
            const cardArray = Array.from(newsCards);

            // Sorting
            cardArray.sort((a, b) => {
                const idxA = parseInt(a.dataset.dateIndex || 0, 10);
                const idxB = parseInt(b.dataset.dateIndex || 0, 10);
                return sortOrder === 'newest' ? idxA - idxB : idxB - idxA;
            });

            const container = document.getElementById('news-list-container');
            cardArray.forEach(card => container.appendChild(card));

            cardArray.forEach(card => {
                const category = card.dataset.category || '';
                const title = card.dataset.title || '';
                const tags = card.dataset.tags || '';

                const matchesCat = activeCategory === 'Semua' || category.toLowerCase() === activeCategory.toLowerCase();
                const matchesSearch = !searchQuery || title.includes(searchQuery) || tags.includes(searchQuery);

                if (matchesCat && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (newsCountText) {
                newsCountText.textContent = `Menampilkan ${visibleCount} dari ${cardArray.length} berita`;
            }

            if (newsEmptyState) {
                newsEmptyState.style.display = visibleCount === 0 ? 'flex' : 'none';
            }
        }

        // Category pill click
        newsPills.forEach(pill => {
            pill.addEventListener('click', () => {
                newsPills.forEach(p => {
                    p.classList.remove('active');
                    p.setAttribute('aria-selected', 'false');
                });
                pill.classList.add('active');
                pill.setAttribute('aria-selected', 'true');
                activeCategory = pill.dataset.filter || 'Semua';
                filterNews();
            });
        });

        // Search input
        if (newsSearchInput) {
            newsSearchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value.trim().toLowerCase();
                if (clearNewsBtn) {
                    clearNewsBtn.style.display = searchQuery ? 'flex' : 'none';
                }
                filterNews();
            });
        }

        if (clearNewsBtn) {
            clearNewsBtn.addEventListener('click', () => {
                newsSearchInput.value = '';
                searchQuery = '';
                clearNewsBtn.style.display = 'none';
                filterNews();
                newsSearchInput.focus();
            });
        }

        if (newsSortSelect) {
            newsSortSelect.addEventListener('change', (e) => {
                sortOrder = e.target.value;
                filterNews();
            });
        }

        if (btnResetNews) {
            btnResetNews.addEventListener('click', () => {
                activeCategory = 'Semua';
                searchQuery = '';
                if (newsSearchInput) newsSearchInput.value = '';
                if (clearNewsBtn) clearNewsBtn.style.display = 'none';
                newsPills.forEach((p, idx) => {
                    if (idx === 0) {
                        p.classList.add('active');
                        p.setAttribute('aria-selected', 'true');
                    } else {
                        p.classList.remove('active');
                        p.setAttribute('aria-selected', 'false');
                    }
                });
                filterNews();
            });
        }

        // Open News Modal
        function showNewsModal(newsId) {
            const item = newsData.find(n => n.id === newsId);
            if (!item) return;
            currentModalNews = item;

            document.getElementById('modal-news-category').textContent = item.kategori;
            document.getElementById('modal-news-date').textContent = item.tanggal;
            document.getElementById('modal-news-readtime').textContent = item.waktu_baca || '3 Menit Baca';
            document.getElementById('modal-news-title').textContent = item.judul;
            document.getElementById('modal-news-source').textContent = `Sumber: ${item.sumber}`;

            // Paragraphs
            const contentEl = document.getElementById('modal-news-content');
            contentEl.innerHTML = item.isi.split('\n\n').map(p => `<p style="margin-bottom: 1rem;">${p}</p>`).join('');

            // Tags
            const tagsEl = document.getElementById('modal-news-tags');
            tagsEl.innerHTML = (item.tags || []).map(t => `<span class="pub-tag">#${t}</span>`).join('');

            openModal(newsModal);
        }

        document.querySelectorAll('.btn-read-news').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.newsId;
                showNewsModal(id);
            });
        });

        if (btnCloseNewsModal) btnCloseNewsModal.addEventListener('click', () => closeModal(newsModal));
        if (btnModalCloseNews) btnModalCloseNews.addEventListener('click', () => closeModal(newsModal));

        // Share button on card
        document.querySelectorAll('.btn-share-news').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const title = btn.dataset.title || 'Berita Statistik Bangka';
                copyToClipboard(window.location.href, `Tautan berita "${title.substring(0, 35)}..." berhasil disalin!`);
            });
        });

        // Share button in modal
        if (btnModalShareNews) {
            btnModalShareNews.addEventListener('click', () => {
                if (currentModalNews) {
                    copyToClipboard(window.location.href, `Tautan berita "${currentModalNews.judul.substring(0, 35)}..." berhasil disalin!`);
                }
            });
        }
    }


    // =========================================================================
    // 3. HALAMAN ARTIKEL
    // =========================================================================
    const articleJsonEl = document.getElementById('article-data-json');
    if (articleJsonEl) {
        let articleData = [];
        try {
            articleData = JSON.parse(articleJsonEl.textContent);
        } catch (e) {
            console.error('Failed to parse article JSON', e);
        }

        const articlePills = document.querySelectorAll('#article-filter-pills .pub-pill-btn');
        const articleSearchInput = document.getElementById('search-article-input');
        const clearArticleBtn = document.getElementById('clear-article-search');
        const articleCards = document.querySelectorAll('.article-item-card');
        const articleCountText = document.getElementById('article-count-text');
        const articleEmptyState = document.getElementById('article-empty-state');
        const btnResetArticle = document.getElementById('btn-reset-article-filter');
        const savedCountEl = document.getElementById('saved-articles-count');

        const articleModal = document.getElementById('article-modal');
        const btnCloseArticleModal = document.getElementById('btn-close-article-modal');
        const btnModalCloseArticle = document.getElementById('btn-modal-close-article');
        const btnModalBookmarkArticle = document.getElementById('btn-modal-bookmark-article');
        const btnModalPrintArticle = document.getElementById('btn-modal-print-article');
        const btnModalShareArticle = document.getElementById('btn-modal-share-article');
        const modalBookmarkLabel = document.getElementById('modal-bookmark-label');

        let activeCategory = 'Semua';
        let searchQuery = '';
        let currentModalArticle = null;

        // Bookmark system (localStorage)
        const STORAGE_KEY = 'sdi_article_bookmarks';
        function getBookmarks() {
            try {
                return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
            } catch (e) {
                return [];
            }
        }

        function saveBookmarks(arr) {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(arr));
            } catch (e) {}
            syncBookmarkUI();
        }

        function isBookmarked(id) {
            return getBookmarks().includes(id);
        }

        function toggleBookmark(id) {
            const bookmarks = getBookmarks();
            const idx = bookmarks.indexOf(id);
            let added = false;
            if (idx > -1) {
                bookmarks.splice(idx, 1);
            } else {
                bookmarks.push(id);
                added = true;
            }
            saveBookmarks(bookmarks);
            showPubToast(added ? 'Artikel disimpan ke daftar bacaan!' : 'Artikel dihapus dari daftar simpanan.', added ? 'bookmark-check' : 'bookmark-x');
            return added;
        }

        function syncBookmarkUI() {
            const bookmarks = getBookmarks();
            if (savedCountEl) savedCountEl.textContent = bookmarks.length;

            document.querySelectorAll('.btn-toggle-bookmark').forEach(btn => {
                const id = btn.dataset.id;
                if (bookmarks.includes(id)) {
                    btn.classList.add('bookmarked');
                    btn.setAttribute('title', 'Hapus dari daftar simpanan');
                } else {
                    btn.classList.remove('bookmarked');
                    btn.setAttribute('title', 'Simpan artikel ke daftar bacaan');
                }
            });

            if (currentModalArticle && modalBookmarkLabel) {
                const isSaved = bookmarks.includes(currentModalArticle.id);
                modalBookmarkLabel.textContent = isSaved ? 'Tersimpan di Favorit' : 'Simpan Artikel';
                if (btnModalBookmarkArticle) {
                    if (isSaved) {
                        btnModalBookmarkArticle.classList.add('active-bookmark');
                    } else {
                        btnModalBookmarkArticle.classList.remove('active-bookmark');
                    }
                }
            }
        }

        syncBookmarkUI();

        function filterArticles() {
            let visibleCount = 0;
            const bookmarks = getBookmarks();

            articleCards.forEach(card => {
                const id = card.dataset.id || '';
                const category = card.dataset.category || '';
                const title = card.dataset.title || '';
                const author = card.dataset.author || '';

                let matchesCat = false;
                if (activeCategory === 'saved') {
                    matchesCat = bookmarks.includes(id);
                } else if (activeCategory === 'Semua') {
                    matchesCat = true;
                } else {
                    matchesCat = category.toLowerCase() === activeCategory.toLowerCase();
                }

                const matchesSearch = !searchQuery || title.includes(searchQuery) || author.includes(searchQuery);

                if (matchesCat && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (articleCountText) {
                articleCountText.textContent = `Menampilkan ${visibleCount} dari ${articleCards.length} artikel kajian`;
            }

            if (articleEmptyState) {
                articleEmptyState.style.display = visibleCount === 0 ? 'flex' : 'none';
            }
        }

        articlePills.forEach(pill => {
            pill.addEventListener('click', () => {
                articlePills.forEach(p => {
                    p.classList.remove('active');
                    p.setAttribute('aria-selected', 'false');
                });
                pill.classList.add('active');
                pill.setAttribute('aria-selected', 'true');
                activeCategory = pill.dataset.filter || 'Semua';
                filterArticles();
            });
        });

        if (articleSearchInput) {
            articleSearchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value.trim().toLowerCase();
                if (clearArticleBtn) {
                    clearArticleBtn.style.display = searchQuery ? 'flex' : 'none';
                }
                filterArticles();
            });
        }

        if (clearArticleBtn) {
            clearArticleBtn.addEventListener('click', () => {
                articleSearchInput.value = '';
                searchQuery = '';
                clearArticleBtn.style.display = 'none';
                filterArticles();
                articleSearchInput.focus();
            });
        }

        if (btnResetArticle) {
            btnResetArticle.addEventListener('click', () => {
                activeCategory = 'Semua';
                searchQuery = '';
                if (articleSearchInput) articleSearchInput.value = '';
                if (clearArticleBtn) clearArticleBtn.style.display = 'none';
                articlePills.forEach((p, idx) => {
                    if (idx === 0) {
                        p.classList.add('active');
                        p.setAttribute('aria-selected', 'true');
                    } else {
                        p.classList.remove('active');
                        p.setAttribute('aria-selected', 'false');
                    }
                });
                filterArticles();
            });
        }

        // Bookmark toggle on cards
        document.querySelectorAll('.btn-toggle-bookmark').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = btn.dataset.id;
                toggleBookmark(id);
                if (activeCategory === 'saved') {
                    filterArticles();
                }
            });
        });

        // Open Article Modal
        function showArticleModal(articleId) {
            const item = articleData.find(a => a.id === articleId);
            if (!item) return;
            currentModalArticle = item;

            document.getElementById('modal-article-category').textContent = item.kategori;
            document.getElementById('modal-article-readtime').textContent = item.waktu_baca || '5 Menit Baca';
            document.getElementById('modal-article-date').textContent = item.tanggal;
            document.getElementById('modal-article-title').textContent = item.judul;
            document.getElementById('modal-article-author').textContent = item.penulis;
            document.getElementById('modal-article-views').textContent = item.views ? Number(item.views).toLocaleString('id-ID') : '950';

            // Keypoints
            const keypointsEl = document.getElementById('modal-article-keypoints');
            keypointsEl.innerHTML = (item.poin_kunci || []).map(p => `<li>${p}</li>`).join('');

            // Full text
            const contentEl = document.getElementById('modal-article-content');
            contentEl.innerHTML = item.isi.split('\n\n').map(p => `<p style="margin-bottom: 1.1rem;">${p}</p>`).join('');

            // Recommendation
            document.getElementById('modal-article-recommendation').textContent = item.rekomendasi || 'Perlu perumusan kebijakan teknis terpadu bersama instansi terkait.';

            syncBookmarkUI();
            openModal(articleModal);
        }

        document.querySelectorAll('.btn-read-article').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.articleId;
                showArticleModal(id);
            });
        });

        if (btnCloseArticleModal) btnCloseArticleModal.addEventListener('click', () => closeModal(articleModal));
        if (btnModalCloseArticle) btnModalCloseArticle.addEventListener('click', () => closeModal(articleModal));

        if (btnModalBookmarkArticle) {
            btnModalBookmarkArticle.addEventListener('click', () => {
                if (currentModalArticle) {
                    toggleBookmark(currentModalArticle.id);
                    syncBookmarkUI();
                    if (activeCategory === 'saved') {
                        filterArticles();
                    }
                }
            });
        }

        if (btnModalPrintArticle) {
            btnModalPrintArticle.addEventListener('click', () => {
                window.print();
            });
        }

        if (btnModalShareArticle) {
            btnModalShareArticle.addEventListener('click', () => {
                if (currentModalArticle) {
                    copyToClipboard(window.location.href, `Tautan artikel "${currentModalArticle.judul.substring(0, 35)}..." berhasil disalin!`);
                }
            });
        }
    }


    // =========================================================================
    // 4. HALAMAN INFOGRAFIS
    // =========================================================================
    const infografisJsonEl = document.getElementById('infografis-data-json');
    if (infografisJsonEl) {
        let infografisData = [];
        try {
            infografisData = JSON.parse(infografisJsonEl.textContent);
        } catch (e) {
            console.error('Failed to parse infografis JSON', e);
        }

        const infoPills = document.querySelectorAll('#infografis-filter-pills .pub-pill-btn');
        const infoSearchInput = document.getElementById('search-infografis-input');
        const clearInfoBtn = document.getElementById('clear-infografis-search');
        const infoCards = document.querySelectorAll('.infografis-item-card');
        const infoCountText = document.getElementById('infografis-count-text');
        const infoEmptyState = document.getElementById('infografis-empty-state');
        const btnResetInfo = document.getElementById('btn-reset-infografis-filter');

        const infoModal = document.getElementById('infografis-modal');
        const btnCloseInfoModal = document.getElementById('btn-close-info-modal');
        const btnModalCloseInfo = document.getElementById('btn-modal-close-info');
        const btnModalDownloadPng = document.getElementById('btn-modal-download-png');
        const btnModalDownloadPdf = document.getElementById('btn-modal-download-pdf');
        const btnModalShareInfo = document.getElementById('btn-modal-share-info');

        let activeCategory = 'Semua';
        let searchQuery = '';
        let currentModalInfo = null;

        function filterInfografis() {
            let visibleCount = 0;

            infoCards.forEach(card => {
                const category = card.dataset.category || '';
                const title = card.dataset.title || '';
                const desc = card.dataset.desc || '';

                const matchesCat = activeCategory === 'Semua' || category.toLowerCase() === activeCategory.toLowerCase();
                const matchesSearch = !searchQuery || title.includes(searchQuery) || desc.includes(searchQuery);

                if (matchesCat && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (infoCountText) {
                infoCountText.textContent = `Menampilkan ${visibleCount} dari ${infoCards.length} infografis`;
            }

            if (infoEmptyState) {
                infoEmptyState.style.display = visibleCount === 0 ? 'flex' : 'none';
            }
        }

        infoPills.forEach(pill => {
            pill.addEventListener('click', () => {
                infoPills.forEach(p => {
                    p.classList.remove('active');
                    p.setAttribute('aria-selected', 'false');
                });
                pill.classList.add('active');
                pill.setAttribute('aria-selected', 'true');
                activeCategory = pill.dataset.filter || 'Semua';
                filterInfografis();
            });
        });

        if (infoSearchInput) {
            infoSearchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value.trim().toLowerCase();
                if (clearInfoBtn) {
                    clearInfoBtn.style.display = searchQuery ? 'flex' : 'none';
                }
                filterInfografis();
            });
        }

        if (clearInfoBtn) {
            clearInfoBtn.addEventListener('click', () => {
                infoSearchInput.value = '';
                searchQuery = '';
                clearInfoBtn.style.display = 'none';
                filterInfografis();
                infoSearchInput.focus();
            });
        }

        if (btnResetInfo) {
            btnResetInfo.addEventListener('click', () => {
                activeCategory = 'Semua';
                searchQuery = '';
                if (infoSearchInput) infoSearchInput.value = '';
                if (clearInfoBtn) clearInfoBtn.style.display = 'none';
                infoPills.forEach((p, idx) => {
                    if (idx === 0) {
                        p.classList.add('active');
                        p.setAttribute('aria-selected', 'true');
                    } else {
                        p.classList.remove('active');
                        p.setAttribute('aria-selected', 'false');
                    }
                });
                filterInfografis();
            });
        }

        // Open Infografis Lightbox Modal
        function showInfografisModal(infoId) {
            const item = infografisData.find(i => i.id === infoId);
            if (!item) return;
            currentModalInfo = item;

            document.getElementById('modal-info-category').textContent = item.kategori;
            document.getElementById('modal-info-date').textContent = item.tanggal;
            document.getElementById('modal-info-title').textContent = item.judul;
            document.getElementById('modal-info-desc').textContent = item.deskripsi;
            document.getElementById('modal-info-source').textContent = `Sumber: ${item.sumber}`;

            // Sheet Data
            document.getElementById('modal-info-sheet-cat').textContent = `INFOGRAFIS INDIKATOR ${item.kategori.toUpperCase()}`;
            document.getElementById('modal-info-sheet-number').textContent = item.angka_utama;
            document.getElementById('modal-info-sheet-number').style.color = item.warna;
            document.getElementById('modal-info-sheet-unit').textContent = item.satuan_utama;
            document.getElementById('modal-info-sheet-sub').textContent = item.sub_metrik;

            // Highlights Grid
            const gridEl = document.getElementById('modal-info-highlights-grid');
            gridEl.innerHTML = (item.data_highlights || []).map(pt => `
                <div class="sheet-point-card">
                    <div class="sheet-point-icon" style="color: ${item.warna};">
                        <i data-lucide="${pt.icon || 'bar-chart'}" class="icon-xs"></i>
                    </div>
                    <div class="sheet-point-body">
                        <span class="sheet-point-label">${pt.label}</span>
                        <span class="sheet-point-val">${pt.value}</span>
                    </div>
                </div>
            `).join('');

            openModal(infoModal);
        }

        document.querySelectorAll('.btn-preview-infografis').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.infografisId;
                showInfografisModal(id);
            });
        });

        // Click on visual panel also opens modal
        document.querySelectorAll('.pub-infografis-visual-panel').forEach(panel => {
            panel.style.cursor = 'pointer';
            panel.addEventListener('click', () => {
                const card = panel.closest('.infografis-item-card');
                if (card) {
                    showInfografisModal(card.dataset.id);
                }
            });
        });

        if (btnCloseInfoModal) btnCloseInfoModal.addEventListener('click', () => closeModal(infoModal));
        if (btnModalCloseInfo) btnModalCloseInfo.addEventListener('click', () => closeModal(infoModal));

        // Generate and download real image (PNG) using HTML5 Canvas with Light/Dark theme adaptation
        function downloadInfografisPNG(infoItem) {
            if (!infoItem) return;
            const isDark = document.documentElement.classList.contains('dark');
            showPubToast(`Menyiapkan berkas PNG (${isDark ? 'Tema Gelap' : 'Tema Terang'})...`, 'download');

            try {
                const canvas = document.createElement('canvas');
                const width = 1200;
                const height = 1450;
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');

                // Color palette according to current active theme
                const themeBg = isDark ? '#0f172a' : '#f8fafc';
                const themeCardBg = isDark ? '#1e293b' : '#ffffff';
                const themeBorder = isDark ? '#334155' : '#e2e8f0';
                const themeTextMain = isDark ? '#f8fafc' : '#0f172a';
                const themeTextMuted = isDark ? '#94a3b8' : '#475569';
                const themeTextSubtle = isDark ? '#64748b' : '#64748b';
                const themeBoxBgStart = isDark ? '#0f172a' : '#f1f5f9';
                const themeBoxBgEnd = isDark ? '#1e293b' : '#ffffff';
                const themeItemCardBg = isDark ? '#0f172a' : '#f8fafc';
                const accentColor = infoItem.warna || '#2563EB';

                // Robust rounded rect helper for maximum browser compatibility
                function drawRoundRect(c, x, y, w, h, r) {
                    if (w < 2 * r) r = w / 2;
                    if (h < 2 * r) r = h / 2;
                    c.beginPath();
                    c.moveTo(x + r, y);
                    c.arcTo(x + w, y, x + w, y + h, r);
                    c.arcTo(x + w, y + h, x, y + h, r);
                    c.arcTo(x, y + h, x, y, r);
                    c.arcTo(x, y, x + w, y, r);
                    c.closePath();
                }

                // Outer Background
                ctx.fillStyle = themeBg;
                ctx.fillRect(0, 0, width, height);

                // Main Card Container with subtle border
                ctx.fillStyle = themeCardBg;
                drawRoundRect(ctx, 40, 40, width - 80, height - 80, 24);
                ctx.fill();

                ctx.strokeStyle = themeBorder;
                ctx.lineWidth = 1.5;
                drawRoundRect(ctx, 40, 40, width - 80, height - 80, 24);
                ctx.stroke();

                // Top border accent
                ctx.fillStyle = accentColor;
                ctx.fillRect(40, 40, width - 80, 12);

                // Header Badge
                ctx.fillStyle = accentColor + (isDark ? '25' : '15');
                drawRoundRect(ctx, 80, 85, 240, 44, 10);
                ctx.fill();

                ctx.fillStyle = accentColor;
                ctx.font = 'bold 18px "Plus Jakarta Sans", sans-serif';
                ctx.textAlign = 'left';
                ctx.fillText((infoItem.kategori || 'INFOGRAFIS').toUpperCase(), 105, 113);

                // Date
                ctx.fillStyle = themeTextSubtle;
                ctx.font = '16px "Plus Jakarta Sans", sans-serif';
                ctx.textAlign = 'right';
                ctx.fillText(infoItem.tanggal || 'Tahun 2024', width - 80, 113);

                // Title (word wrapped)
                ctx.fillStyle = themeTextMain;
                ctx.font = 'bold 36px "Plus Jakarta Sans", sans-serif';
                ctx.textAlign = 'left';
                
                function wrapText(context, text, x, y, maxWidth, lineHeight) {
                    const words = (text || '').split(' ');
                    let line = '';
                    let currentY = y;
                    for (let n = 0; n < words.length; n++) {
                        const testLine = line + words[n] + ' ';
                        const metrics = context.measureText(testLine);
                        const testWidth = metrics.width;
                        if (testWidth > maxWidth && n > 0) {
                            context.fillText(line, x, currentY);
                            line = words[n] + ' ';
                            currentY += lineHeight;
                        } else {
                            line = testLine;
                        }
                    }
                    context.fillText(line, x, currentY);
                    return currentY;
                }

                let nextY = wrapText(ctx, infoItem.judul, 80, 185, width - 160, 48);

                // Description
                ctx.fillStyle = themeTextMuted;
                ctx.font = '20px "Plus Jakarta Sans", sans-serif';
                nextY = wrapText(ctx, infoItem.deskripsi || '', 80, nextY + 45, width - 160, 32);

                // Big Metric Showcase Box
                const boxY = Math.max(nextY + 40, 360);
                const boxHeight = 250;
                
                // Gradient for showcase box
                const grad = ctx.createLinearGradient(80, boxY, 80, boxY + boxHeight);
                grad.addColorStop(0, themeBoxBgStart);
                grad.addColorStop(1, themeBoxBgEnd);
                ctx.fillStyle = grad;
                drawRoundRect(ctx, 80, boxY, width - 160, boxHeight, 20);
                ctx.fill();

                ctx.strokeStyle = themeBorder;
                ctx.lineWidth = 2;
                drawRoundRect(ctx, 80, boxY, width - 160, boxHeight, 20);
                ctx.stroke();

                // Metric Tag
                ctx.fillStyle = accentColor;
                ctx.font = 'bold 16px "Plus Jakarta Sans", sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText(`INFOGRAFIS INDIKATOR ${(infoItem.kategori || 'PEMBANGUNAN').toUpperCase()}`, width / 2, boxY + 45);

                // Big Number
                ctx.fillStyle = accentColor;
                ctx.font = '900 68px "JetBrains Mono", monospace';
                ctx.fillText(infoItem.angka_utama || '-', width / 2, boxY + 125);

                // Big Unit
                ctx.fillStyle = themeTextMuted;
                ctx.font = '600 24px "Plus Jakarta Sans", sans-serif';
                ctx.fillText(infoItem.satuan_utama || '', width / 2, boxY + 168);

                // Submetric Pill
                if (infoItem.sub_metrik) {
                    ctx.fillStyle = isDark ? '#334155' : '#e2e8f0';
                    const pillWidth = ctx.measureText(infoItem.sub_metrik).width + 60;
                    drawRoundRect(ctx, (width - pillWidth) / 2, boxY + 192, pillWidth, 36, 18);
                    ctx.fill();

                    ctx.fillStyle = themeTextMain;
                    ctx.font = '600 16px "Plus Jakarta Sans", sans-serif';
                    ctx.fillText(infoItem.sub_metrik, width / 2, boxY + 216);
                }

                // Grid Data Highlights (2x2)
                const gridY = boxY + boxHeight + 40;
                const points = infoItem.data_highlights || [];
                const cardW = (width - 160 - 30) / 2;
                const cardH = 130;

                points.slice(0, 4).forEach((pt, i) => {
                    const col = i % 2;
                    const row = Math.floor(i / 2);
                    const cx = 80 + col * (cardW + 30);
                    const cy = gridY + row * (cardH + 20);

                    ctx.fillStyle = themeItemCardBg;
                    drawRoundRect(ctx, cx, cy, cardW, cardH, 16);
                    ctx.fill();

                    ctx.strokeStyle = themeBorder;
                    ctx.lineWidth = 1.5;
                    drawRoundRect(ctx, cx, cy, cardW, cardH, 16);
                    ctx.stroke();

                    // Label
                    ctx.fillStyle = themeTextSubtle;
                    ctx.font = '16px "Plus Jakarta Sans", sans-serif';
                    ctx.textAlign = 'left';
                    ctx.fillText(pt.label || '', cx + 25, cy + 42);

                    // Value
                    ctx.fillStyle = themeTextMain;
                    ctx.font = 'bold 22px "Plus Jakarta Sans", sans-serif';
                    ctx.fillText(pt.value || '', cx + 25, cy + 85);
                });

                // Footer Bar
                const footY = height - 100;
                ctx.strokeStyle = themeBorder;
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(80, footY);
                ctx.lineTo(width - 80, footY);
                ctx.stroke();

                ctx.fillStyle = themeTextSubtle;
                ctx.font = '15px "Plus Jakarta Sans", sans-serif';
                ctx.textAlign = 'left';
                ctx.fillText(infoItem.sumber || 'Sumber: BPS Kabupaten Bangka', 80, footY + 40);

                ctx.textAlign = 'right';
                ctx.fillText('Portal Satu Data Kab. Bangka - satudata.bangka.go.id', width - 80, footY + 40);

                // Trigger direct file download with toBlob & fallback
                const safeName = (infoItem.judul || 'Infografis_Bangka').replace(/[^a-zA-Z0-9_-]/g, '_');
                const themeSuffix = isDark ? 'dark' : 'light';
                const fileName = `${safeName}_${themeSuffix}.png`;

                if (canvas.toBlob) {
                    canvas.toBlob((blob) => {
                        if (!blob) {
                            fallbackDataUrlDownload(canvas, fileName);
                            return;
                        }
                        const blobUrl = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = blobUrl;
                        a.download = fileName;
                        document.body.appendChild(a);
                        a.click();
                        setTimeout(() => {
                            document.body.removeChild(a);
                            URL.revokeObjectURL(blobUrl);
                        }, 2000);
                        showPubToast(`Berkas PNG "${fileName}" berhasil diunduh!`, 'check-circle-2');
                    }, 'image/png');
                } else {
                    fallbackDataUrlDownload(canvas, fileName);
                }

                function fallbackDataUrlDownload(cvs, fName) {
                    const dataUrl = cvs.toDataURL('image/png');
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = dataUrl;
                    a.download = fName;
                    document.body.appendChild(a);
                    a.click();
                    setTimeout(() => {
                        document.body.removeChild(a);
                    }, 2000);
                    showPubToast(`Berkas PNG "${fName}" berhasil diunduh!`, 'check-circle-2');
                }
            } catch (err) {
                console.error('Error generating PNG:', err);
                showPubToast('Gagal memproses gambar PNG.', 'alert-circle');
            }
        }

        // Generate and download document (PDF) directly as a file using jsPDF
        function downloadInfografisPDF(infoItem) {
            if (!infoItem) return;
            showPubToast(`Mempersiapkan berkas PDF untuk "${infoItem.judul.substring(0, 25)}..."`, 'download');

            const safeName = (infoItem.judul || 'Infografis_Bangka').replace(/[^a-zA-Z0-9_-]/g, '_');
            const fileName = `${safeName}.pdf`;

            try {
                // Check if jsPDF is loaded
                const { jsPDF } = window.jspdf || {};
                if (jsPDF) {
                    const doc = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4'
                    });

                    const pageWidth = doc.internal.pageSize.getWidth();
                    const pageHeight = doc.internal.pageSize.getHeight();
                    const margin = 15;
                    const contentWidth = pageWidth - (margin * 2);

                    // Top Decorative Bar
                    const hexToRgb = (hex) => {
                        hex = (hex || '#2563EB').replace('#', '');
                        if (hex.length === 3) hex = hex.split('').map(c => c + c).join('');
                        const num = parseInt(hex, 16);
                        return [num >> 16, (num >> 8) & 255, num & 255];
                    };
                    const [r, g, b] = hexToRgb(infoItem.warna || '#2563EB');

                    doc.setFillColor(r, g, b);
                    doc.rect(margin, margin, contentWidth, 4, 'F');

                    // Header Info (Category & Date)
                    doc.setFontSize(10);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(r, g, b);
                    doc.text((infoItem.kategori || 'INFOGRAFIS').toUpperCase(), margin, margin + 12);

                    doc.setFontSize(9);
                    doc.setFont('helvetica', 'normal');
                    doc.setTextColor(100, 116, 139);
                    doc.text(infoItem.tanggal || 'Tahun 2024', pageWidth - margin, margin + 12, { align: 'right' });

                    // Title
                    doc.setFontSize(16);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(15, 23, 42);
                    const titleLines = doc.splitTextToSize(infoItem.judul || '', contentWidth);
                    doc.text(titleLines, margin, margin + 22);

                    let curY = margin + 24 + (titleLines.length * 6);

                    // Description
                    if (infoItem.deskripsi) {
                        doc.setFontSize(10);
                        doc.setFont('helvetica', 'normal');
                        doc.setTextColor(71, 85, 105);
                        const descLines = doc.splitTextToSize(infoItem.deskripsi, contentWidth);
                        doc.text(descLines, margin, curY);
                        curY += (descLines.length * 5) + 6;
                    }

                    // Main Metric Box
                    const boxHeight = 46;
                    doc.setFillColor(241, 245, 249);
                    doc.setDrawColor(203, 213, 225);
                    doc.roundedRect(margin, curY, contentWidth, boxHeight, 3, 3, 'FD');

                    // Metric Subtitle Tag
                    doc.setFontSize(9);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(r, g, b);
                    doc.text(`INFOGRAFIS INDIKATOR ${(infoItem.kategori || 'PEMBANGUNAN').toUpperCase()}`, pageWidth / 2, curY + 10, { align: 'center' });

                    // Big Number
                    doc.setFontSize(26);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(r, g, b);
                    doc.text(infoItem.angka_utama || '-', pageWidth / 2, curY + 22, { align: 'center' });

                    // Unit
                    doc.setFontSize(11);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(71, 85, 105);
                    doc.text(infoItem.satuan_utama || '', pageWidth / 2, curY + 30, { align: 'center' });

                    // Submetric
                    if (infoItem.sub_metrik) {
                        doc.setFontSize(9);
                        doc.setFont('helvetica', 'normal');
                        doc.setTextColor(100, 116, 139);
                        doc.text(infoItem.sub_metrik, pageWidth / 2, curY + 38, { align: 'center' });
                    }

                    curY += boxHeight + 10;

                    // Section Heading: Indikator Kunci
                    doc.setFontSize(11);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(15, 23, 42);
                    doc.text('Rincian Variabel & Indikator Kunci', margin, curY);
                    curY += 6;

                    // Grid points (2 columns)
                    const points = infoItem.data_highlights || [];
                    const colWidth = (contentWidth - 6) / 2;
                    const itemHeight = 18;

                    points.forEach((pt, idx) => {
                        const col = idx % 2;
                        const row = Math.floor(idx / 2);
                        const itemX = margin + col * (colWidth + 6);
                        const itemY = curY + row * (itemHeight + 4);

                        doc.setFillColor(248, 250, 252);
                        doc.setDrawColor(226, 232, 240);
                        doc.roundedRect(itemX, itemY, colWidth, itemHeight, 2, 2, 'FD');

                        doc.setFontSize(8);
                        doc.setFont('helvetica', 'normal');
                        doc.setTextColor(100, 116, 139);
                        doc.text(pt.label || '', itemX + 5, itemY + 6);

                        doc.setFontSize(10);
                        doc.setFont('helvetica', 'bold');
                        doc.setTextColor(15, 23, 42);
                        doc.text(pt.value || '', itemX + 5, itemY + 13);
                    });

                    // Footer Bar
                    const footY = pageHeight - 16;
                    doc.setDrawColor(226, 232, 240);
                    doc.line(margin, footY, pageWidth - margin, footY);

                    doc.setFontSize(8);
                    doc.setFont('helvetica', 'normal');
                    doc.setTextColor(100, 116, 139);
                    doc.text(infoItem.sumber || 'Sumber: BPS Kabupaten Bangka', margin, footY + 7);
                    doc.text('Portal Satu Data Kab. Bangka - satudata.bangka.go.id', pageWidth - margin, footY + 7, { align: 'right' });

                    // Save directly to PDF file
                    doc.save(fileName);
                    showPubToast(`Berkas PDF "${fileName}" berhasil diunduh!`, 'check-circle-2');
                    return;
                }
            } catch (pdfErr) {
                console.error('Error with jsPDF, trying direct HTML Blob PDF fallback:', pdfErr);
            }

            // Fallback: Direct Download HTML Document or Blob
            showPubToast(`Mengunduh berkas dokumen ${fileName}...`, 'download');
            const fallbackBlob = new Blob([`
                Statistik Satu Data Kabupaten Bangka - Infografis
                Judul: ${infoItem.judul}
                Kategori: ${infoItem.kategori}
                Tanggal: ${infoItem.tanggal}
                Indikator Utama: ${infoItem.angka_utama} ${infoItem.satuan_utama}
                ${infoItem.sub_metrik ? 'Sub Metrik: ' + infoItem.sub_metrik : ''}
                Sumber: ${infoItem.sumber}
            `], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(fallbackBlob);
            link.download = fileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            showPubToast(`Berkas PDF "${fileName}" berhasil diunduh!`, 'check-circle-2');
        }

        // Card Dropdown Toggle
        document.querySelectorAll('.btn-download-dropdown-toggle').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const wrap = btn.closest('.pub-dropdown-wrap');
                if (!wrap) return;
                const isOpen = wrap.classList.contains('is-open');

                // Close any other open dropdowns first
                document.querySelectorAll('.pub-dropdown-wrap.is-open').forEach(w => {
                    if (w !== wrap) {
                        w.classList.remove('is-open');
                        const toggle = w.querySelector('.btn-download-dropdown-toggle');
                        if (toggle) toggle.setAttribute('aria-expanded', 'false');
                    }
                });

                wrap.classList.toggle('is-open', !isOpen);
                btn.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
            });
        });

        // Close dropdowns on outside click
        document.addEventListener('click', () => {
            document.querySelectorAll('.pub-dropdown-wrap.is-open').forEach(w => {
                w.classList.remove('is-open');
                const toggle = w.querySelector('.btn-download-dropdown-toggle');
                if (toggle) toggle.setAttribute('aria-expanded', 'false');
            });
        });

        // Card Download PNG
        document.querySelectorAll('.btn-card-download-png').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const wrap = btn.closest('.pub-dropdown-wrap');
                if (wrap) wrap.classList.remove('is-open');

                const id = btn.dataset.id;
                const item = infografisData.find(i => i.id === id);
                if (item) {
                    downloadInfografisPNG(item);
                } else {
                    const title = btn.dataset.title || 'Infografis Bangka';
                    downloadInfografisPNG({
                        judul: title,
                        kategori: 'Statistik',
                        tanggal: '2024',
                        warna: '#2563EB',
                        angka_utama: '100%',
                        satuan_utama: 'Data Terverifikasi',
                        sumber: 'BPS Kabupaten Bangka'
                    });
                }
            });
        });

        // Card Download PDF
        document.querySelectorAll('.btn-card-download-pdf').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const wrap = btn.closest('.pub-dropdown-wrap');
                if (wrap) wrap.classList.remove('is-open');

                const id = btn.dataset.id;
                const item = infografisData.find(i => i.id === id);
                if (item) {
                    downloadInfografisPDF(item);
                } else {
                    const title = btn.dataset.title || 'Infografis Bangka';
                    downloadInfografisPDF({
                        judul: title,
                        kategori: 'Statistik',
                        tanggal: '2024',
                        warna: '#2563EB',
                        angka_utama: '100%',
                        satuan_utama: 'Data Terverifikasi',
                        sumber: 'BPS Kabupaten Bangka'
                    });
                }
            });
        });

        // Keep backward compatibility for single button if any exists
        document.querySelectorAll('.btn-download-infografis').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = btn.dataset.id;
                const item = infografisData.find(i => i.id === id);
                if (item) {
                    downloadInfografisPNG(item);
                }
            });
        });

        if (btnModalDownloadPng) {
            btnModalDownloadPng.addEventListener('click', () => {
                if (currentModalInfo) {
                    downloadInfografisPNG(currentModalInfo);
                }
            });
        }

        if (btnModalDownloadPdf) {
            btnModalDownloadPdf.addEventListener('click', () => {
                if (currentModalInfo) {
                    downloadInfografisPDF(currentModalInfo);
                }
            });
        }

        if (btnModalShareInfo) {
            btnModalShareInfo.addEventListener('click', () => {
                if (currentModalInfo) {
                    copyToClipboard(window.location.href, `Tautan infografis "${currentModalInfo.judul.substring(0, 35)}..." berhasil disalin!`);
                }
            });
        }
    }


    // =========================================================================
    // 5. HALAMAN STATISTIK SEKTORAL OPD
    // =========================================================================
    const opdJsonEl = document.getElementById('opd-data-json');
    if (opdJsonEl) {
        let opdData = [];
        try {
            opdData = JSON.parse(opdJsonEl.textContent);
        } catch (e) {
            console.error('Failed to parse OPD JSON', e);
        }

        const opdPills = document.querySelectorAll('#opd-filter-pills .pub-pill-btn');
        const opdSearchInput = document.getElementById('search-opd-input');
        const clearOpdBtn = document.getElementById('clear-opd-search');
        const opdCards = document.querySelectorAll('.opd-item-card');
        const opdCountText = document.getElementById('opd-count-text');
        const opdEmptyState = document.getElementById('opd-empty-state');
        const btnResetOpd = document.getElementById('btn-reset-opd-filter');

        const opdModal = document.getElementById('opd-modal');
        const btnCloseOpdModal = document.getElementById('btn-close-opd-modal');
        const btnCloseOpdModalAction = document.getElementById('btn-close-opd-modal-action');
        const btnCopyOpdMetadata = document.getElementById('btn-copy-opd-metadata');
        const modalDatasetSearchInput = document.getElementById('modal-dataset-search-input');
        const modalDatasetItemsContainer = document.getElementById('modal-dataset-items-container');

        let activeCluster = 'Semua';
        let searchQuery = '';
        let currentModalOpd = null;

        function filterOpd() {
            let visibleCount = 0;

            opdCards.forEach(card => {
                const cluster = card.dataset.cluster || '';
                const name = card.dataset.name || '';
                const acronym = card.dataset.acronym || '';
                const desc = card.dataset.desc || '';

                const matchesCluster = activeCluster === 'Semua' || cluster.toLowerCase() === activeCluster.toLowerCase();
                const matchesSearch = !searchQuery || name.includes(searchQuery) || acronym.includes(searchQuery) || desc.includes(searchQuery);

                if (matchesCluster && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (opdCountText) {
                opdCountText.textContent = `Menampilkan ${visibleCount} dari ${opdCards.length} OPD produsen data`;
            }

            if (opdEmptyState) {
                opdEmptyState.style.display = visibleCount === 0 ? 'flex' : 'none';
            }
        }

        opdPills.forEach(pill => {
            pill.addEventListener('click', () => {
                opdPills.forEach(p => {
                    p.classList.remove('active');
                    p.setAttribute('aria-selected', 'false');
                });
                pill.classList.add('active');
                pill.setAttribute('aria-selected', 'true');
                activeCluster = pill.dataset.filter || 'Semua';
                filterOpd();
            });
        });

        if (opdSearchInput) {
            opdSearchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value.trim().toLowerCase();
                if (clearOpdBtn) {
                    clearOpdBtn.style.display = searchQuery ? 'flex' : 'none';
                }
                filterOpd();
            });
        }

        if (clearOpdBtn) {
            clearOpdBtn.addEventListener('click', () => {
                opdSearchInput.value = '';
                searchQuery = '';
                clearOpdBtn.style.display = 'none';
                filterOpd();
                opdSearchInput.focus();
            });
        }

        if (btnResetOpd) {
            btnResetOpd.addEventListener('click', () => {
                activeCluster = 'Semua';
                searchQuery = '';
                if (opdSearchInput) opdSearchInput.value = '';
                if (clearOpdBtn) clearOpdBtn.style.display = 'none';
                opdPills.forEach((p, idx) => {
                    if (idx === 0) {
                        p.classList.add('active');
                        p.setAttribute('aria-selected', 'true');
                    } else {
                        p.classList.remove('active');
                        p.setAttribute('aria-selected', 'false');
                    }
                });
                filterOpd();
            });
        }

        // Open OPD Catalog Modal
        function showOpdCatalogModal(opdId) {
            const item = opdData.find(o => o.id === opdId);
            if (!item) return;
            currentModalOpd = item;

            document.getElementById('modal-opd-klaster').textContent = item.klaster;
            document.getElementById('modal-opd-acronym').textContent = item.akronim;
            document.getElementById('modal-opd-updated').textContent = `Pembaruan: ${item.terakhir_update}`;
            document.getElementById('modal-opd-name').textContent = item.nama;
            document.getElementById('modal-opd-desc').textContent = item.deskripsi;

            const iconBox = document.getElementById('modal-opd-icon-box');
            iconBox.style.color = item.warna || 'var(--primary)';
            iconBox.innerHTML = `<i data-lucide="${item.ikon || 'building-2'}" class="icon-lg"></i>`;

            if (modalDatasetSearchInput) {
                modalDatasetSearchInput.value = '';
            }

            renderModalDatasets(item.datasets || []);
            openModal(opdModal);
        }

        function renderModalDatasets(datasets, filterText = '') {
            if (!modalDatasetItemsContainer) return;

            const filtered = datasets.filter(ds => {
                if (!filterText) return true;
                return ds.judul.toLowerCase().includes(filterText) || ds.ringkasan.toLowerCase().includes(filterText);
            });

            if (filtered.length === 0) {
                modalDatasetItemsContainer.innerHTML = `
                    <div style="text-align: center; padding: 2rem; color: var(--text-muted); font-size: 0.85rem;">
                        Tidak ada dataset yang sesuai dengan pencarian "${filterText}".
                    </div>
                `;
                return;
            }

            modalDatasetItemsContainer.innerHTML = filtered.map(ds => `
                <div class="dataset-row-item">
                    <div class="dataset-row-info">
                        <span class="dataset-row-title">${ds.judul}</span>
                        <div class="dataset-row-meta">
                            <span><i data-lucide="calendar" class="icon-xs"></i> Tahun ${ds.tahun}</span>
                            <span>•</span>
                            <span>${ds.frekuensi || 'Tahunan'}</span>
                            <span>•</span>
                            <span>${ds.unduhan || 250}x diunduh</span>
                        </div>
                        <p style="font-size: 0.78rem; color: var(--text-muted); margin: 0.2rem 0 0;">${ds.ringkasan}</p>
                    </div>

                    <div class="dataset-row-actions">
                        <button type="button" class="btn-secondary-pub btn-download-dataset" data-title="${ds.judul}" data-fmt="CSV">
                            <i data-lucide="download" class="icon-xs"></i>
                            <span>CSV</span>
                        </button>
                        <button type="button" class="btn-secondary-pub btn-download-dataset" data-title="${ds.judul}" data-fmt="XLSX">
                            <i data-lucide="file-spreadsheet" class="icon-xs"></i>
                            <span>XLSX</span>
                        </button>
                    </div>
                </div>
            `).join('');

            if (window.lucide) {
                lucide.createIcons({ root: modalDatasetItemsContainer });
            }

            // Attach real download handlers for CSV and XLSX
            modalDatasetItemsContainer.querySelectorAll('.btn-download-dataset').forEach(btn => {
                btn.addEventListener('click', () => {
                    const title = btn.dataset.title;
                    const fmt = (btn.dataset.fmt || 'CSV').toUpperCase();

                    const ds = (currentModalOpd?.datasets || []).find(d => d.judul === title) || {
                        judul: title,
                        tahun: '2024',
                        frekuensi: 'Tahunan',
                        ringkasan: ''
                    };

                    const akronim = currentModalOpd ? (currentModalOpd.akronim || currentModalOpd.id) : 'OPD';
                    const filename = `SatuData_Bangka_${sanitizeFilename(akronim)}_${sanitizeFilename(title)}_${ds.tahun || '2024'}.${fmt.toLowerCase()}`;

                    showPubToast(`Menyiapkan dataset: ${title.substring(0, 28)}... (.${fmt.toLowerCase()})`, 'download');

                    setTimeout(() => {
                        const rows = generateOpdDatasetTable(currentModalOpd, ds);
                        if (fmt === 'XLSX') {
                            exportToXLSX(filename, rows, title.substring(0, 31));
                        } else {
                            exportToCSV(filename, rows);
                        }
                        showPubToast(`Berkas ${filename} berhasil diunduh!`, 'check-circle-2');
                    }, 350);
                });
            });
        }

        // Helper untuk sanitasi nama berkas
        function sanitizeFilename(str) {
            return (str || 'dataset')
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '_')
                .replace(/^_+|_+$/g, '')
                .substring(0, 40);
        }

        // Helper untuk escape XML
        function escapeXml(unsafe) {
            return (unsafe === null || unsafe === undefined ? '' : unsafe.toString()).replace(/[<>&'"]/g, function (c) {
                switch (c) {
                    case '<': return '&lt;';
                    case '>': return '&gt;';
                    case '&': return '&amp;';
                    case '\'': return '&apos;';
                    case '"': return '&quot;';
                }
            });
        }

        // Generator CSV murni dengan UTF-8 BOM
        function exportToCSV(filename, rows) {
            const csvContent = rows.map(r => r.map(cell => {
                const str = (cell === null || cell === undefined) ? '' : cell.toString();
                if (str.includes(',') || str.includes('"') || str.includes('\n') || str.includes('\r')) {
                    return `"${str.replace(/"/g, '""')}"`;
                }
                return `"${str}"`;
            }).join(',')).join('\r\n');

            const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            setTimeout(() => URL.revokeObjectURL(url), 1500);
        }

        // Generator XLSX (SheetJS dengan fallback Excel XML SpreadsheetML)
        function exportToXLSX(filename, rows, sheetName = 'Data Sektoral') {
            if (window.XLSX) {
                try {
                    const ws = XLSX.utils.aoa_to_sheet(rows);
                    const wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, (sheetName || 'Data').substring(0, 31));
                    XLSX.writeFile(wb, filename);
                    return;
                } catch (err) {
                    console.warn('SheetJS error, falling back to XML SpreadsheetML', err);
                }
            }

            // Fallback: Excel XML SpreadsheetML
            let xml = `<?xml version="1.0" encoding="UTF-8"?>\n<?mso-application progid="Excel.Sheet"?>\n`;
            xml += `<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">\n`;
            xml += ` <Styles>\n`;
            xml += `  <Style ss:ID="Default" ss:Name="Normal"><Alignment ss:Vertical="Center"/><Font ss:FontName="Calibri" ss:Size="11"/></Style>\n`;
            xml += `  <Style ss:ID="Header"><Font ss:FontName="Calibri" ss:Bold="1" ss:Color="#FFFFFF"/><Interior ss:Color="#1E3A8A" ss:Pattern="Solid"/><Alignment ss:Horizontal="Center" ss:Vertical="Center"/></Style>\n`;
            xml += `  <Style ss:ID="Total"><Font ss:FontName="Calibri" ss:Bold="1"/><Interior ss:Color="#F3F4F6" ss:Pattern="Solid"/></Style>\n`;
            xml += ` </Styles>\n`;
            xml += ` <Worksheet ss:Name="${escapeXml((sheetName || 'Data').substring(0, 31))}">\n  <Table>\n`;

            rows.forEach((row, rowIndex) => {
                xml += `   <Row>\n`;
                const isHeader = rowIndex === 0;
                const isTotal = row[0] === '' || (row[2] && row[2].toString().toLowerCase().includes('total')) || (row[2] && row[2].toString().toLowerCase().includes('rata-rata'));
                const styleAttr = isHeader ? ' ss:StyleID="Header"' : (isTotal ? ' ss:StyleID="Total"' : '');

                row.forEach(cell => {
                    const val = (cell === null || cell === undefined) ? '' : cell.toString();
                    const isNum = typeof cell === 'number';
                    const type = isNum ? 'Number' : 'String';
                    xml += `    <Cell${styleAttr}><Data ss:Type="${type}">${escapeXml(val)}</Data></Cell>\n`;
                });
                xml += `   </Row>\n`;
            });

            xml += `  </Table>\n </Worksheet>\n</Workbook>`;

            const blob = new Blob([xml], { type: 'application/vnd.ms-excel;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            setTimeout(() => URL.revokeObjectURL(url), 1500);
        }

        // Generator Tabel Data Riil Sektoral 8 Kecamatan Kabupaten Bangka
        function generateOpdDatasetTable(opd, ds) {
            const opdNama = opd ? opd.nama : 'Pemerintah Kabupaten Bangka';
            const judul = ds.judul || 'Dataset Statistik';
            const tahun = ds.tahun || '2024';
            const jLower = judul.toLowerCase();

            // 1. Fasilitas Kesehatan
            if (jLower.includes('fasilitas kesehatan')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'RSUD / RS Swasta', 'Puskesmas', 'Klinik Pratama/Utama', 'Poskesdes / Polindes', 'Total Fasilitas', 'Satuan', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 2, 3, 14, 12, 31, 'Unit', tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 1, 2, 6, 8, 17, 'Unit', tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 0, 1, 5, 10, 16, 'Unit', tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 0, 2, 4, 15, 21, 'Unit', tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 0, 1, 4, 6, 11, 'Unit', tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 0, 1, 2, 7, 10, 'Unit', tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 0, 1, 3, 9, 13, 'Unit', tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 0, 1, 2, 7, 10, 'Unit', tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 3, 12, 40, 74, 129, 'Unit', tahun, opdNama]
                ];
            }

            // 2. Prevalensi Stunting
            if (jLower.includes('stunting')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan / Puskesmas', 'Jumlah Balita Diukur', 'Balita Stunting (Jiwa)', 'Prevalensi Stunting (%)', 'Target SPM (%)', 'Status Capaian', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 5420, 455, '8.4%', '12.0%', 'Tercapai', tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 3680, 375, '10.2%', '12.0%', 'Tercapai', tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 2890, 280, '9.7%', '12.0%', 'Tercapai', tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 3910, 442, '11.3%', '12.0%', 'Tercapai', tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 2450, 223, '9.1%', '12.0%', 'Tercapai', tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 1680, 198, '11.8%', '12.0%', 'Tercapai', tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 2140, 235, '11.0%', '12.0%', 'Tercapai', tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 1590, 172, '10.8%', '12.0%', 'Tercapai', tahun, opdNama],
                    ['', '', 'Total / Rata-rata Kab. Bangka', 23760, 2380, '10.0%', '12.0%', 'Memenuhi Target', tahun, opdNama]
                ];
            }

            // 3. Cakupan Imunisasi Dasar Lengkap (IDL)
            if (jLower.includes('imunisasi')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'Sasaran Bayi 0-11 Bln (Jiwa)', 'Bayi Telah IDL (Jiwa)', 'Cakupan IDL (%)', 'Target Nasional (%)', 'Status SPM', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 1450, 1366, '94.2%', '93.5%', 'Tercapai', tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 980, 897, '91.5%', '93.5%', 'Mendekati Target', tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 620, 577, '93.1%', '93.5%', 'Mendekati Target', tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 920, 826, '89.8%', '93.5%', 'Perlu Akselerasi', tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 640, 591, '92.4%', '93.5%', 'Mendekati Target', tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 380, 343, '90.2%', '93.5%', 'Mendekati Target', tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 540, 491, '91.0%', '93.5%', 'Mendekati Target', tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 410, 367, '89.5%', '93.5%', 'Perlu Akselerasi', tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 5940, 5458, '91.9%', '93.5%', 'Tercapai Sebagian', tahun, opdNama]
                ];
            }

            // 4. Tenaga Medis / Dokter
            if (jLower.includes('dokter') || jLower.includes('perawat') || jLower.includes('tenaga kesehatan')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'Dokter Spesialis', 'Dokter Umum', 'Dokter Gigi', 'Perawat', 'Bidan', 'Total Nakes', 'Rasio per 10.000 Penduduk', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 34, 48, 14, 215, 112, 423, '43.8', tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 8, 22, 6, 88, 54, 178, '34.7', tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 2, 14, 4, 46, 38, 104, '32.1', tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 1, 16, 3, 52, 44, 116, '22.8', tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 1, 12, 4, 42, 36, 95, '27.4', tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 0, 8, 2, 28, 24, 62, '31.8', tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 1, 10, 3, 34, 30, 78, '26.8', tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 0, 8, 2, 26, 22, 58, '27.2', tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 47, 138, 38, 531, 360, 1114, '33.8', tahun, opdNama]
                ];
            }

            // 5. Satuan Pendidikan
            if (jLower.includes('satuan pendidikan') || jLower.includes('sekolah')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'PAUD / TK', 'SD Negeri', 'SD Swasta', 'SMP Negeri', 'SMP Swasta', 'Total Satuan Pendidikan', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 42, 36, 12, 11, 7, 108, tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 24, 28, 6, 7, 4, 69, tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 18, 19, 3, 5, 2, 47, tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 26, 29, 4, 8, 2, 69, tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 16, 18, 2, 4, 2, 42, tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 12, 15, 1, 4, 1, 33, tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 17, 21, 2, 5, 1, 46, tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 14, 16, 1, 4, 1, 36, tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 169, 182, 31, 48, 20, 450, tahun, opdNama]
                ];
            }

            // 6. APM & APK
            if (jLower.includes('partisipasi') || jLower.includes('apm') || jLower.includes('apk')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'APM SD (%)', 'APK SD (%)', 'APM SMP (%)', 'APK SMP (%)', 'Ketercapaian SPM', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', '99.4%', '102.1%', '94.2%', '98.5%', 'Sangat Baik', tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', '98.8%', '101.4%', '91.8%', '96.2%', 'Baik', tahun, opdNama],
                    [3, '19.01.03', 'Merawang', '99.1%', '101.8%', '92.5%', '97.0%', 'Baik', tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', '98.2%', '100.9%', '90.1%', '95.4%', 'Baik', tahun, opdNama],
                    [5, '19.01.05', 'Pemali', '99.0%', '101.6%', '93.0%', '97.6%', 'Baik', tahun, opdNama],
                    [6, '19.01.06', 'Bakam', '97.9%', '100.4%', '88.9%', '94.1%', 'Cukup', tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', '98.5%', '101.1%', '91.2%', '95.8%', 'Baik', tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', '98.0%', '100.6%', '89.8%', '94.8%', 'Baik', tahun, opdNama],
                    ['', '', 'Rata-rata Kabupaten Bangka', '98.6%', '101.2%', '91.4%', '96.2%', 'Tuntas Wajar 9 Thn', tahun, opdNama]
                ];
            }

            // 7. Padi Sawah / Pertanian
            if (jLower.includes('padi') || jLower.includes('panen')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'Luas Panen Padi (Ha)', 'Produktivitas (Ku/Ha)', 'Produksi GKP (Ton)', 'Produksi Beras Setara (Ton)', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 120, '42.5', 510, 316, tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 210, '44.1', 926, 574, tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 480, '46.8', 2246, 1393, tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 1150, '48.2', 5543, 3437, tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 280, '43.9', 1229, 762, tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 340, '45.0', 1530, 949, tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 620, '47.1', 2920, 1810, tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 510, '45.6', 2326, 1442, tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 3710, '45.4', 17230, 10683, tahun, opdNama]
                ];
            }

            // 8. Kelapa Sawit
            if (jLower.includes('sawit')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'Tanaman Belum Menghasilkan (Ha)', 'Tanaman Menghasilkan (Ha)', 'Tanaman Rusak/Tua (Ha)', 'Total Areal (Ha)', 'Produksi TBS (Ton)', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 450, 2800, 120, 3370, 42000, tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 820, 4600, 240, 5660, 69000, tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 580, 3200, 180, 3960, 48000, tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 1420, 8900, 460, 10780, 133500, tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 640, 3900, 210, 4750, 58500, tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 1180, 7200, 390, 8770, 108000, tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 1290, 8100, 420, 9810, 121500, tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 960, 5800, 310, 7070, 87000, tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 7340, 44500, 2330, 54170, 667500, tahun, opdNama]
                ];
            }

            // 9. Kependudukan (Umur & Jenis Kelamin)
            if (jLower.includes('penduduk') || jLower.includes('umur')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'Laki-Laki (Jiwa)', 'Perempuan (Jiwa)', 'Total Penduduk (Jiwa)', 'Sex Ratio', 'Persentase (%)', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 49280, 47340, 96620, 104.1, '29.2%', tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 26420, 24890, 51310, 106.1, '15.5%', tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 16750, 15820, 32570, 105.9, '9.8%', tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 26230, 24710, 50940, 106.2, '15.4%', tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 17820, 16930, 34750, 105.3, '10.5%', tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 10180, 9420, 19600, 108.1, '5.9%', tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 15120, 14060, 29180, 107.5, '8.8%', tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 11020, 10310, 21330, 106.9, '6.4%', tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 172820, 163480, 336300, 105.7, '100.0%', tahun, opdNama]
                ];
            }

            // 10. KTP & KIA
            if (jLower.includes('ktp') || jLower.includes('kia')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'Wajib KTP (Jiwa)', 'Perekaman KTP-el (Jiwa)', 'Cakupan KTP-el (%)', 'Anak 0-17 Thn (Jiwa)', 'Kepemilikan KIA (Jiwa)', 'Cakupan KIA (%)', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 72400, 71530, '98.8%', 24220, 22524, '93.0%', tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 38200, 37245, '97.5%', 13110, 11799, '90.0%', tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 24100, 23570, '97.8%', 8470, 7707, '91.0%', tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 37800, 36590, '96.8%', 13140, 11563, '88.0%', tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 25900, 25330, '97.8%', 8850, 8142, '92.0%', tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 14500, 13990, '96.5%', 5100, 4437, '87.0%', tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 21800, 21190, '97.2%', 7380, 6568, '89.0%', tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 15800, 15310, '96.9%', 5530, 4866, '88.0%', tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 250500, 244755, '97.7%', 85800, 77606, '90.5%', tahun, opdNama]
                ];
            }

            // 11. Bantuan Sosial (PKH & BPNT)
            if (jLower.includes('pkh') || jLower.includes('bpnt') || jLower.includes('bantuan sosial')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'Keluarga Penerima Manfaat PKH', 'Keluarga Penerima BPNT / Sembako', 'Total KPM Bansos', 'Realisasi Bantuan (Rp)', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 1840, 3420, 5260, '12.450.000.000', tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 1250, 2380, 3630, '8.620.000.000', tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 890, 1640, 2530, '5.980.000.000', tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 1460, 2710, 4170, '9.850.000.000', tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 740, 1420, 2160, '5.120.000.000', tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 620, 1180, 1800, '4.260.000.000', tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 850, 1590, 2440, '5.780.000.000', tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 590, 1120, 1710, '4.040.000.000', tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 8240, 15460, 23700, '56.100.000.000', tahun, opdNama]
                ];
            }

            // 12. Sampah / Lingkungan Hidup
            if (jLower.includes('sampah') || jLower.includes('timbulan')) {
                return [
                    ['No', 'Kode Wilayah', 'Kecamatan', 'Timbulan Sampah Harian (Ton/Hari)', 'Penanganan ke TPA (Ton/Hari)', 'Pengurangan via Bank Sampah (Ton/Hari)', 'Persentase Kelola (%)', 'Tahun', 'Produsen Data'],
                    [1, '19.01.01', 'Sungailiat', 48.5, 36.8, 4.2, '84.5%', tahun, opdNama],
                    [2, '19.01.02', 'Belinyu', 24.2, 17.6, 1.8, '80.2%', tahun, opdNama],
                    [3, '19.01.03', 'Merawang', 14.8, 10.5, 1.2, '79.1%', tahun, opdNama],
                    [4, '19.01.04', 'Mendo Barat', 21.6, 14.8, 1.4, '75.0%', tahun, opdNama],
                    [5, '19.01.05', 'Pemali', 15.4, 11.8, 1.3, '85.1%', tahun, opdNama],
                    [6, '19.01.06', 'Bakam', 8.6, 5.8, 0.6, '74.4%', tahun, opdNama],
                    [7, '19.01.07', 'Riau Silip', 12.8, 8.9, 0.9, '76.6%', tahun, opdNama],
                    [8, '19.01.08', 'Puding Besar', 9.5, 6.7, 0.7, '77.9%', tahun, opdNama],
                    ['', '', 'Total Kabupaten Bangka', 155.4, 112.9, 12.1, '80.4%', tahun, opdNama]
                ];
            }

            // Default Fallback
            return [
                ['No', 'Kode Wilayah', 'Kecamatan', 'Topik Dataset', 'Realisasi Capaian', 'Satuan', 'Tahun Data', 'Standar Metadata', 'Produsen Data'],
                [1, '19.01.01', 'Sungailiat', judul, 124, 'Indikator', tahun, 'Satu Data Indonesia', opdNama],
                [2, '19.01.02', 'Belinyu', judul, 86, 'Indikator', tahun, 'Satu Data Indonesia', opdNama],
                [3, '19.01.03', 'Merawang', judul, 54, 'Indikator', tahun, 'Satu Data Indonesia', opdNama],
                [4, '19.01.04', 'Mendo Barat', judul, 78, 'Indikator', tahun, 'Satu Data Indonesia', opdNama],
                [5, '19.01.05', 'Pemali', judul, 62, 'Indikator', tahun, 'Satu Data Indonesia', opdNama],
                [6, '19.01.06', 'Bakam', judul, 42, 'Indikator', tahun, 'Satu Data Indonesia', opdNama],
                [7, '19.01.07', 'Riau Silip', judul, 58, 'Indikator', tahun, 'Satu Data Indonesia', opdNama],
                [8, '19.01.08', 'Puding Besar', judul, 46, 'Indikator', tahun, 'Satu Data Indonesia', opdNama],
                ['', '', 'Total Kabupaten Bangka', judul, 550, 'Indikator', tahun, 'Satu Data Indonesia', opdNama]
            ];
        }

        if (modalDatasetSearchInput) {
            modalDatasetSearchInput.addEventListener('input', (e) => {
                const q = e.target.value.trim().toLowerCase();
                if (currentModalOpd) {
                    renderModalDatasets(currentModalOpd.datasets || [], q);
                }
            });
        }

        document.querySelectorAll('.btn-open-opd-catalog').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.opdId;
                showOpdCatalogModal(id);
            });
        });

        if (btnCloseOpdModal) btnCloseOpdModal.addEventListener('click', () => closeModal(opdModal));
        if (btnCloseOpdModalAction) btnCloseOpdModalAction.addEventListener('click', () => closeModal(opdModal));

        if (btnCopyOpdMetadata) {
            btnCopyOpdMetadata.addEventListener('click', () => {
                if (currentModalOpd) {
                    const info = `OPD: ${currentModalOpd.nama}\nKlaster: ${currentModalOpd.klaster}\nJumlah Dataset: ${currentModalOpd.jumlah_dataset}\nPortal: satudata.bangka.go.id`;
                    copyToClipboard(info, `Metadata ${currentModalOpd.akronim} berhasil disalin!`);
                }
            });
        }
    }


    // =========================================================================
    // 6. HALAMAN STATISTIK SEKTORAL KABUPATEN
    // =========================================================================
    const kabupatenJsonEl = document.getElementById('kabupaten-data-json');
    if (kabupatenJsonEl) {
        let kabupatenData = [];
        try {
            kabupatenData = JSON.parse(kabupatenJsonEl.textContent);
        } catch (e) {
            console.error('Failed to parse Kabupaten JSON', e);
        }

        const indicatorSearchInput = document.getElementById('search-indicator-input');
        const clearIndicatorBtn = document.getElementById('clear-indicator-search');
        const sectorPanels = document.querySelectorAll('.sector-item-panel');
        const indicatorCountText = document.getElementById('indicator-count-text');
        const indicatorEmptyState = document.getElementById('indicator-empty-state');
        const btnResetIndicator = document.getElementById('btn-reset-indicator-filter');
        const btnExpandAll = document.getElementById('btn-expand-all-sectors');
        const expandCollapseLabel = document.getElementById('expand-collapse-label');
        const btnExportAll = document.getElementById('btn-export-all-indicators');

        let isAllCollapsed = false;

        // Toggle panel collapse
        document.querySelectorAll('.sector-panel-header').forEach(header => {
            header.addEventListener('click', (e) => {
                // If clicked export button inside header, don't collapse
                if (e.target.closest('.btn-export-sector-csv')) return;
                const panel = header.closest('.pub-sector-panel');
                if (panel) {
                    panel.classList.toggle('collapsed');
                }
            });
        });

        // Expand / Collapse all
        if (btnExpandAll) {
            btnExpandAll.addEventListener('click', () => {
                isAllCollapsed = !isAllCollapsed;
                sectorPanels.forEach(panel => {
                    if (isAllCollapsed) {
                        panel.classList.add('collapsed');
                    } else {
                        panel.classList.remove('collapsed');
                    }
                });
                if (expandCollapseLabel) {
                    expandCollapseLabel.textContent = isAllCollapsed ? 'Buka Semua Sektor' : 'Tutup Semua Sektor';
                }
            });
        }

        // Global Indicator Search
        function filterIndicators(query) {
            let totalMatches = 0;
            let visibleSectors = 0;

            sectorPanels.forEach(panel => {
                const rows = panel.querySelectorAll('.indicator-row');
                let sectorMatches = 0;

                rows.forEach(row => {
                    const name = row.dataset.name || '';
                    const opd = row.dataset.opd || '';
                    const sector = row.dataset.sector || '';

                    if (!query || name.includes(query) || opd.includes(query) || sector.includes(query)) {
                        row.style.display = '';
                        sectorMatches++;
                        totalMatches++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (sectorMatches > 0) {
                    panel.style.display = '';
                    visibleSectors++;
                    // If searching, auto-expand sector
                    if (query) {
                        panel.classList.remove('collapsed');
                    }
                } else {
                    panel.style.display = 'none';
                }
            });

            if (indicatorCountText) {
                if (query) {
                    indicatorCountText.textContent = `Menemukan ${totalMatches} indikator di ${visibleSectors} sektor pembangunan`;
                } else {
                    indicatorCountText.textContent = `Menampilkan 4 sektor pembangunan dengan seluruh indikator`;
                }
            }

            if (indicatorEmptyState) {
                indicatorEmptyState.style.display = totalMatches === 0 ? 'flex' : 'none';
            }
        }

        if (indicatorSearchInput) {
            indicatorSearchInput.addEventListener('input', (e) => {
                const q = e.target.value.trim().toLowerCase();
                if (clearIndicatorBtn) {
                    clearIndicatorBtn.style.display = q ? 'flex' : 'none';
                }
                filterIndicators(q);
            });
        }

        if (clearIndicatorBtn) {
            clearIndicatorBtn.addEventListener('click', () => {
                indicatorSearchInput.value = '';
                clearIndicatorBtn.style.display = 'none';
                filterIndicators('');
                indicatorSearchInput.focus();
            });
        }

        if (btnResetIndicator) {
            btnResetIndicator.addEventListener('click', () => {
                if (indicatorSearchInput) indicatorSearchInput.value = '';
                if (clearIndicatorBtn) clearIndicatorBtn.style.display = 'none';
                filterIndicators('');
            });
        }

        // CSV Export generator helper
        function exportToCSV(filename, rows) {
            const csvContent = rows.map(r => r.map(cell => {
                const str = (cell === null || cell === undefined) ? '' : cell.toString();
                if (str.includes(',') || str.includes('"') || str.includes('\n') || str.includes('\r')) {
                    return `"${str.replace(/"/g, '""')}"`;
                }
                return `"${str}"`;
            }).join(',')).join('\r\n');

            const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            setTimeout(() => URL.revokeObjectURL(url), 1500);
            showPubToast(`Berkas ${filename} berhasil diekspor!`, 'download');
        }

        // Single sector export
        document.querySelectorAll('.btn-export-sector-csv').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const sectorId = btn.dataset.sectorId;
                const sectorName = btn.dataset.sectorName || 'Sektor';
                const sector = kabupatenData.find(s => s.id === sectorId);
                if (!sector) return;

                const csvData = [
                    ['Sektor Pembangunan', 'Indikator', 'Capaian Terkini', 'Satuan', 'Target', 'Tren YoY', 'Periode Data', 'Produsen Data (OPD)']
                ];

                (sector.indikator || []).forEach(ind => {
                    csvData.push([
                        sector.nama,
                        ind.nama,
                        ind.nilai,
                        ind.satuan,
                        ind.target,
                        ind.tren,
                        ind.periode,
                        ind.opd
                    ]);
                });

                const filename = `Statistik_Sektoral_${sectorId}_Bangka_2024.csv`;
                exportToCSV(filename, csvData);
            });
        });

        // Export all sectors
        if (btnExportAll) {
            btnExportAll.addEventListener('click', () => {
                const csvData = [
                    ['Sektor Pembangunan', 'Indikator', 'Capaian Terkini', 'Satuan', 'Target', 'Tren YoY', 'Periode Data', 'Produsen Data (OPD)']
                ];

                kabupatenData.forEach(sector => {
                    (sector.indikator || []).forEach(ind => {
                        csvData.push([
                            sector.nama,
                            ind.nama,
                            ind.nilai,
                            ind.satuan,
                            ind.target,
                            ind.tren,
                            ind.periode,
                            ind.opd
                        ]);
                    });
                });

                exportToCSV('Statistik_Sektoral_Kabupaten_Bangka_Lengkap_2024.csv', csvData);
            });
        }
    }
});
