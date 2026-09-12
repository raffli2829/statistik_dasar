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

        // Download actions
        function triggerDownloadSimulation(title, ext) {
            showPubToast(`Menyiapkan pengunduhan ${title.substring(0, 30)}... (.${ext})`, 'download');
            setTimeout(() => {
                showPubToast(`Berkas infografis (.${ext}) berhasil diunduh!`, 'check-circle-2');
            }, 1000);
        }

        document.querySelectorAll('.btn-download-infografis').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const title = btn.dataset.title || 'Infografis Bangka';
                triggerDownloadSimulation(title, 'png');
            });
        });

        if (btnModalDownloadPng) {
            btnModalDownloadPng.addEventListener('click', () => {
                if (currentModalInfo) {
                    triggerDownloadSimulation(currentModalInfo.judul, 'png');
                }
            });
        }

        if (btnModalDownloadPdf) {
            btnModalDownloadPdf.addEventListener('click', () => {
                if (currentModalInfo) {
                    triggerDownloadSimulation(currentModalInfo.judul, 'pdf');
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

            // Attach download handlers
            modalDatasetItemsContainer.querySelectorAll('.btn-download-dataset').forEach(btn => {
                btn.addEventListener('click', () => {
                    const title = btn.dataset.title;
                    const fmt = btn.dataset.fmt;
                    showPubToast(`Mengunduh dataset: ${title.substring(0, 30)}... (.${fmt.toLowerCase()})`, 'download');
                    setTimeout(() => {
                        showPubToast(`Dataset ${fmt} berhasil diunduh!`, 'check-circle-2');
                    }, 1000);
                });
            });
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
            const csvContent = 'data:text/csv;charset=utf-8,\uFEFF' + rows.map(e => e.map(cell => `"${(cell || '').toString().replace(/"/g, '""')}"`).join(',')).join('\n');
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
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
