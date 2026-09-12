<header class="top-navbar" id="top-navbar">
    <div class="container navbar-container">


        <!-- Desktop Navigation Menu -->
        <nav class="nav-menu" aria-label="Menu Utama">
            <!-- Statistik Dasar -->
            <a href="{{ route('statistik.index') }}" 
               class="nav-link {{ request()->routeIs('statistik.*') && !request()->is('publikasi*') ? 'is-active' : '' }}">
                Statistik Dasar
            </a>

            <!-- Dropdown Publikasi -->
            <div class="nav-dropdown" id="nav-dropdown-publikasi">
                <a href="{{ route('publikasi.berita') }}" 
                   class="nav-link nav-dropdown-trigger {{ request()->is('publikasi*') ? 'is-active' : '' }}" 
                   id="btn-dropdown-publikasi"
                   aria-expanded="false" 
                   aria-haspopup="true">
                    <span>Publikasi</span>
                    <i data-lucide="chevron-down" class="icon-xs dropdown-caret"></i>
                </a>

                <!-- Mega Dropdown Panel -->
                <div class="dropdown-menu-mega" id="menu-dropdown-publikasi" role="menu">
                    <div class="dropdown-mega-grid">
                        <!-- Berita -->
                        <a href="{{ route('publikasi.berita') }}" 
                           class="dropdown-mega-item {{ request()->routeIs('publikasi.berita') ? 'item-active' : '' }}" 
                           role="menuitem">
                            <div class="mega-item-icon">
                                <i data-lucide="newspaper" class="icon-sm"></i>
                            </div>
                            <div class="mega-item-body">
                                <span class="mega-item-title">Berita</span>
                                <span class="mega-item-desc">Informasi dan berita terkini seputar data.</span>
                            </div>
                        </a>

                        <!-- Artikel -->
                        <a href="{{ route('publikasi.artikel') }}" 
                           class="dropdown-mega-item {{ request()->routeIs('publikasi.artikel') ? 'item-active' : '' }}" 
                           role="menuitem">
                            <div class="mega-item-icon">
                                <i data-lucide="file-text" class="icon-sm"></i>
                            </div>
                            <div class="mega-item-body">
                                <span class="mega-item-title">Artikel</span>
                                <span class="mega-item-desc">Tulisan dan analisis berbasis data.</span>
                            </div>
                        </a>

                        <!-- Infografis -->
                        <a href="{{ route('publikasi.infografis') }}" 
                           class="dropdown-mega-item {{ request()->routeIs('publikasi.infografis') ? 'item-active' : '' }}" 
                           role="menuitem">
                            <div class="mega-item-icon">
                                <i data-lucide="pie-chart" class="icon-sm"></i>
                            </div>
                            <div class="mega-item-body">
                                <span class="mega-item-title">Infografis</span>
                                <span class="mega-item-desc">Visualisasi data dalam bentuk grafik.</span>
                            </div>
                        </a>

                        <!-- Statistik Sektoral OPD -->
                        <a href="{{ route('publikasi.statistik-sektoral-opd') }}" 
                           class="dropdown-mega-item {{ request()->routeIs('publikasi.statistik-sektoral-opd') ? 'item-active' : '' }}" 
                           role="menuitem">
                            <div class="mega-item-icon">
                                <i data-lucide="layers" class="icon-sm"></i>
                            </div>
                            <div class="mega-item-body">
                                <span class="mega-item-title">Statistik Sektoral OPD</span>
                                <span class="mega-item-desc">Publikasi statistik sektoral dari OPD.</span>
                            </div>
                        </a>

                        <!-- Statistik Sektoral Kabupaten Bangka -->
                        <a href="{{ route('publikasi.statistik-sektoral-kabupaten') }}" 
                           class="dropdown-mega-item {{ request()->routeIs('publikasi.statistik-sektoral-kabupaten') ? 'item-active' : '' }}" 
                           role="menuitem">
                            <div class="mega-item-icon">
                                <i data-lucide="bar-chart-3" class="icon-sm"></i>
                            </div>
                            <div class="mega-item-body">
                                <span class="mega-item-title">Statistik Sektoral Kabupaten Bangka</span>
                                <span class="mega-item-desc">Data sektoral lintas OPD tingkat kabupaten.</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Right Side Actions: Theme Switcher & Mobile Toggle -->
        <div class="nav-actions">
            <!-- Global Theme Switcher -->
            <button type="button" 
                    id="topbar-theme-toggle" 
                    class="btn-icon-topbar" 
                    title="Ubah Mode Gelap / Terang"
                    aria-label="Ubah Mode Gelap / Terang">
                <i data-lucide="moon" class="icon-sm" id="topbar-theme-icon"></i>
            </button>

            <!-- Mobile Hamburger Toggle -->
            <button type="button" 
                    id="mobile-menu-toggle" 
                    class="btn-icon-topbar btn-mobile-menu" 
                    aria-label="Toggle menu navigasi"
                    aria-expanded="false">
                <i data-lucide="menu" class="icon-sm" id="mobile-menu-icon"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div class="mobile-menu-drawer" id="mobile-menu-drawer" aria-hidden="true">
        <div class="mobile-menu-container">
            <a href="{{ route('statistik.index') }}" class="mobile-nav-link {{ request()->routeIs('statistik.*') && !request()->is('publikasi*') ? 'is-active' : '' }}">
                <i data-lucide="database" class="icon-xs text-primary"></i>
                <span>Statistik Dasar</span>
            </a>

            <div class="mobile-nav-divider"></div>
            <div class="mobile-nav-heading">Publikasi</div>

            <a href="{{ route('publikasi.berita') }}" class="mobile-nav-link {{ request()->routeIs('publikasi.berita') ? 'is-active' : '' }}">
                <i data-lucide="newspaper" class="icon-xs text-primary"></i>
                <span>Berita</span>
            </a>
            <a href="{{ route('publikasi.artikel') }}" class="mobile-nav-link {{ request()->routeIs('publikasi.artikel') ? 'is-active' : '' }}">
                <i data-lucide="file-text" class="icon-xs text-primary"></i>
                <span>Artikel</span>
            </a>
            <a href="{{ route('publikasi.infografis') }}" class="mobile-nav-link {{ request()->routeIs('publikasi.infografis') ? 'is-active' : '' }}">
                <i data-lucide="pie-chart" class="icon-xs text-primary"></i>
                <span>Infografis</span>
            </a>
            <a href="{{ route('publikasi.statistik-sektoral-opd') }}" class="mobile-nav-link {{ request()->routeIs('publikasi.statistik-sektoral-opd') ? 'is-active' : '' }}">
                <i data-lucide="layers" class="icon-xs text-primary"></i>
                <span>Statistik Sektoral OPD</span>
            </a>
            <a href="{{ route('publikasi.statistik-sektoral-kabupaten') }}" class="mobile-nav-link {{ request()->routeIs('publikasi.statistik-sektoral-kabupaten') ? 'is-active' : '' }}">
                <i data-lucide="bar-chart-3" class="icon-xs text-primary"></i>
                <span>Statistik Sektoral Kab. Bangka</span>
            </a>
        </div>
    </div>
</header>
