<nav class="pub-subnav-container" aria-label="Navigasi Sub Publikasi">
    <div class="pub-subnav-scroll">
        <ul class="pub-subnav-list">
            <!-- 1. Berita -->
            <li>
                <a href="{{ route('publikasi.berita') }}" 
                   class="pub-subnav-link {{ request()->routeIs('publikasi.berita') ? 'active' : '' }}">
                    <i data-lucide="newspaper" class="icon-xs"></i>
                    <span>Berita</span>
                    <span class="pub-subnav-badge">6</span>
                </a>
            </li>

            <!-- 2. Artikel -->
            <li>
                <a href="{{ route('publikasi.artikel') }}" 
                   class="pub-subnav-link {{ request()->routeIs('publikasi.artikel') ? 'active' : '' }}">
                    <i data-lucide="file-text" class="icon-xs"></i>
                    <span>Artikel</span>
                    <span class="pub-subnav-badge">6</span>
                </a>
            </li>

            <!-- 3. Infografis -->
            <li>
                <a href="{{ route('publikasi.infografis') }}" 
                   class="pub-subnav-link {{ request()->routeIs('publikasi.infografis') ? 'active' : '' }}">
                    <i data-lucide="pie-chart" class="icon-xs"></i>
                    <span>Infografis</span>
                    <span class="pub-subnav-badge">6</span>
                </a>
            </li>

            <!-- 4. Statistik Sektoral OPD -->
            <li>
                <a href="{{ route('publikasi.statistik-sektoral-opd') }}" 
                   class="pub-subnav-link {{ request()->routeIs('publikasi.statistik-sektoral-opd') ? 'active' : '' }}">
                    <i data-lucide="layers" class="icon-xs"></i>
                    <span>Statistik Sektoral OPD</span>
                    <span class="pub-subnav-badge">6 OPD</span>
                </a>
            </li>

            <!-- 5. Statistik Sektoral Kab. Bangka -->
            <li>
                <a href="{{ route('publikasi.statistik-sektoral-kabupaten') }}" 
                   class="pub-subnav-link {{ request()->routeIs('publikasi.statistik-sektoral-kabupaten') ? 'active' : '' }}">
                    <i data-lucide="bar-chart-3" class="icon-xs"></i>
                    <span>Statistik Sektoral Kab. Bangka</span>
                    <span class="pub-subnav-badge">4 Sektor</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
