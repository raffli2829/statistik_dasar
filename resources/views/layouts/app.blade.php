<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Statistik Dasar - Satu Data Kabupaten Bangka')</title>
    <meta name="description" content="@yield('meta_description', 'Penyajian indikator makro pembangunan, data statistik sektoral, dan perbandingan 8 kecamatan Kabupaten Bangka terverifikasi BPS.')">
    <meta property="og:title" content="Statistik Dasar - Satu Data Kabupaten Bangka">
    <meta property="og:description" content="Penyajian indikator makro pembangunan dan data statistik sektoral 8 kecamatan di Kabupaten Bangka.">
    <meta property="og:type" content="website">

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/statistik.css') }}">

    <script>
        // Init dark mode immediately to avoid flash
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="antialiased">
    <!-- Ambient Background Lights & Subtle Grid matching satudata.bangka.go.id -->
    <div class="ambient-glows" aria-hidden="true">
        <div class="glow-orb glow-orb-1"></div>
        <div class="glow-orb glow-orb-2"></div>
        <div class="glow-orb glow-orb-3"></div>
    </div>
    <div class="grid-overlay" aria-hidden="true"></div>

    <!-- Main Content Container -->
    <div class="min-h-screen flex flex-col">
        @include('layouts.navbar')

        <main id="main-content" class="flex-1">
            @yield('content')
        </main>
    </div>

    <!-- Custom JS -->
    <script src="{{ asset('js/statistik.js') }}"></script>
    <script src="{{ asset('js/publikasi.js') }}"></script>
    <script>
        // Initialize Lucide Icons
        if (window.lucide) {
            lucide.createIcons();
        }

        // Global Topbar Interactivity
        document.addEventListener('DOMContentLoaded', () => {
            // Theme switcher
            const topbarThemeBtn = document.getElementById('topbar-theme-toggle');
            const topbarThemeIcon = document.getElementById('topbar-theme-icon');

            function syncThemeIcon() {
                const isDark = document.documentElement.classList.contains('dark');
                if (topbarThemeIcon) {
                    topbarThemeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
                }
                const pageThemeIcon = document.getElementById('theme-icon');
                if (pageThemeIcon) {
                    pageThemeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
                }
                if (window.lucide) lucide.createIcons();
            }

            if (topbarThemeBtn) {
                topbarThemeBtn.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    syncThemeIcon();

                    // If chart instances exist, trigger refresh
                    if (window.dispatchEvent) {
                        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark } }));
                    }
                });
            }

            syncThemeIcon();

            // Mobile menu toggle
            const mobileBtn = document.getElementById('mobile-menu-toggle');
            const mobileDrawer = document.getElementById('mobile-menu-drawer');
            const mobileIcon = document.getElementById('mobile-menu-icon');

            if (mobileBtn && mobileDrawer) {
                mobileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isOpen = mobileDrawer.classList.toggle('is-open');
                    mobileBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    if (mobileIcon) {
                        mobileIcon.setAttribute('data-lucide', isOpen ? 'x' : 'menu');
                        if (window.lucide) lucide.createIcons();
                    }
                });

                // Close drawer on click outside
                document.addEventListener('click', (e) => {
                    if (!mobileDrawer.contains(e.target) && !mobileBtn.contains(e.target)) {
                        mobileDrawer.classList.remove('is-open');
                        mobileBtn.setAttribute('aria-expanded', 'false');
                        if (mobileIcon) {
                            mobileIcon.setAttribute('data-lucide', 'menu');
                            if (window.lucide) lucide.createIcons();
                        }
                    }
                });
            }

            // Allow clicking Publikasi to navigate directly to /publikasi
            // Hover opens the mega menu via CSS, but clicking navigates to the page
            const navDropdown = document.getElementById('nav-dropdown-publikasi');
            const btnDropdown = document.getElementById('btn-dropdown-publikasi');
            if (btnDropdown) {
                btnDropdown.addEventListener('click', (e) => {
                    const targetHref = btnDropdown.getAttribute('href');
                    if (targetHref && targetHref !== '#') {
                        window.location.href = targetHref;
                    }
                });
            }
            if (navDropdown) {
                document.addEventListener('click', (e) => {
                    if (!navDropdown.contains(e.target)) {
                        navDropdown.classList.remove('is-open');
                    }
                });
            }
        });
    </script>
</body>
</html>
