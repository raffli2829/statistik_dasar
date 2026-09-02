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
        <main id="main-content" class="flex-1">
            @yield('content')
        </main>
    </div>

    <!-- Custom JS -->
    <script src="{{ asset('js/statistik.js') }}"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>
