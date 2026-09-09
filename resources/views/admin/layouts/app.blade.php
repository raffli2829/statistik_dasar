<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Panel Admin Statistik Dasar Satu Data Bangka</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --primary: #DC2626;
            --primary-hover: #B91C1C;
            --primary-subtle: #FEE2E2;
            --primary-dark: #991B1B;
            --bg-main: #F8FAFC;
            --bg-card: #FFFFFF;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --sidebar-bg: #0F172A;
            --sidebar-text: #E2E8F0;
            --sidebar-hover: #1E293B;
            --sidebar-active: #DC2626;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 270px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo-badge {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #DC2626, #991B1B);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
        }

        .brand-text h2 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #FFFFFF;
            line-height: 1.2;
        }

        .brand-text span {
            font-size: 0.75rem;
            color: #94A3B8;
            font-weight: 500;
        }

        .sidebar-menu {
            padding: 20px 12px;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748B;
            font-weight: 700;
            padding: 12px 12px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #94A3B8;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background-color: var(--sidebar-hover);
            color: #FFFFFF;
        }

        .nav-item.active {
            background-color: var(--sidebar-active);
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            background-color: rgba(0,0,0,0.2);
        }

        .user-pill {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .user-info {
            overflow: hidden;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #F8FAFC;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 0.72rem;
            color: #94A3B8;
        }

        /* Main Content Area */
        .admin-main {
            margin-left: 270px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-header {
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .header-title h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0F172A;
        }

        .header-title p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-body {
            padding: 32px;
            flex: 1;
        }

        /* UI Elements */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        }

        .btn-secondary {
            background-color: #F1F5F9;
            color: #334155;
            border: 1px solid var(--border-color);
        }
        .btn-secondary:hover {
            background-color: #E2E8F0;
            color: #0F172A;
        }

        .btn-danger {
            background-color: #EF4444;
            color: white;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0F172A;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Alert notifications */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.88rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #DCFCE7;
            border: 1px solid #86EFAC;
            color: #166534;
        }

        .alert-danger {
            background-color: #FEE2E2;
            border: 1px solid #FCA5A5;
            color: #991B1B;
        }

        .alert-info {
            background-color: #E0F2FE;
            border: 1px solid #7DD3FC;
            color: #0369A1;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
        }

        .data-table th {
            background-color: #F8FAFC;
            padding: 12px 16px;
            text-align: left;
            font-weight: 700;
            color: #475569;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            color: #1E293B;
            vertical-align: middle;
        }

        .data-table tr:hover td {
            background-color: #F8FAFC;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success { background-color: #DCFCE7; color: #15803D; }
        .badge-primary { background-color: #FEE2E2; color: #DC2626; }
        .badge-secondary { background-color: #F1F5F9; color: #475569; }

        /* Form Inputs */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #CBD5E1;
            font-family: inherit;
            font-size: 0.88rem;
            color: #0F172A;
            background: #FFFFFF;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }

        .form-hint {
            font-size: 0.75rem;
            color: #64748B;
            margin-top: 4px;
        }

        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo-badge">
                <i data-lucide="database" style="width: 20px; height: 20px;"></i>
            </div>
            <div class="brand-text">
                <h2>Panel Admin</h2>
                <span>Statistik Dasar Bangka</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard" style="width: 18px; height: 18px;"></i>
                <span>Dashboard Ringkasan</span>
            </a>
            <a href="{{ route('admin.indicators') }}" class="nav-item {{ request()->routeIs('admin.indicators*') ? 'active' : '' }}">
                <i data-lucide="trending-up" style="width: 18px; height: 18px;"></i>
                <span>Kelola Indikator Makro</span>
            </a>
            <a href="{{ route('admin.kecamatan') }}" class="nav-item {{ request()->routeIs('admin.kecamatan*') ? 'active' : '' }}">
                <i data-lucide="map-pin" style="width: 18px; height: 18px;"></i>
                <span>Data 8 Kecamatan</span>
            </a>

            <div class="menu-label" style="margin-top: 10px;">Integrasi & Import</div>
            <a href="{{ route('admin.import') }}" class="nav-item {{ request()->routeIs('admin.import*') ? 'active' : '' }}">
                <i data-lucide="file-spreadsheet" style="width: 18px; height: 18px;"></i>
                <span>Import CSV & Sync API</span>
            </a>

            <div class="menu-label" style="margin-top: 10px;">Tautan Luar</div>
            <a href="{{ route('statistik.index') }}" target="_blank" class="nav-item">
                <i data-lucide="external-link" style="width: 18px; height: 18px;"></i>
                <span>Buka Portal Publik</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-pill">
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="user-role">{{ Auth::user()->email ?? 'admin@bangka.go.id' }}</div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar" style="background: none; border: none; color: #94A3B8; cursor: pointer; padding: 6px; border-radius: 6px; display: flex; align-items: center;">
                        <i data-lucide="log-out" style="width: 18px; height: 18px;"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <header class="admin-header">
            <div class="header-title">
                <h1>@yield('header_title', 'Dashboard')</h1>
                <p>@yield('header_subtitle', 'Sistem Manajemen Statistik Dasar Kabupaten Bangka')</p>
            </div>
            <div class="header-actions">
                @yield('header_actions')
            </div>
        </header>

        <main class="admin-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <i data-lucide="check-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">
                    <i data-lucide="info" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                    <div>
                        <div style="font-weight: 700; margin-bottom: 4px;">Harap periksa kesalahan input berikut:</div>
                        <ul style="padding-left: 18px;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
