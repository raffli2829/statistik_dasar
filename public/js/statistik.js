/**
 * STATISTIK DASAR - SATU DATA KABUPATEN BANGKA
 * Vanilla JavaScript Engine (Chart.js + Interactive Filter & Reactive Kecamatan Data)
 */

document.addEventListener('DOMContentLoaded', () => {
    const config = window.STATISTIK_CONFIG || {};
    let currentChartMode = 'area';
    let currentSectorId = config.selectedSector || 'kependudukan';
    let currentYear = config.selectedYear || 2024;
    let currentWilayah = config.selectedWilayah || 'kabupaten';
    let currentTimeOrder = 'asc'; // Kronologis: 2020 -> 2024
    
    let mainChartInstance = null;
    let sparklineInstances = {};

    const PRIMARY_RED = '#DC2626';

    // ==========================================
    // 1. Inisialisasi / Re-render Sparklines untuk 4 Headline KPI Cards
    // ==========================================
    function initSparklines(headlineData) {
        const indicators = headlineData || getActiveKPIIndicators();
        if (!indicators || !indicators.length) return;

        // Clean up previous sparklines
        Object.keys(sparklineInstances).forEach(k => {
            if (sparklineInstances[k]) {
                sparklineInstances[k].destroy();
            }
        });
        sparklineInstances = {};

        indicators.forEach(ind => {
            const canvas = document.getElementById(`spark-${ind.id}`);
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 40);
            gradient.addColorStop(0, 'rgba(220, 38, 38, 0.35)');
            gradient.addColorStop(1, 'rgba(220, 38, 38, 0.0)');

            // Handle trend direction
            let trendData = ind.trend ? [...ind.trend] : [];
            if (currentTimeOrder === 'asc') {
                trendData.sort((a, b) => a.year - b.year);
            } else {
                trendData.sort((a, b) => b.year - a.year);
            }

            const labels = trendData.map(t => t.year);
            const values = trendData.map(t => t.value);

            sparklineInstances[ind.id] = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        borderColor: PRIMARY_RED,
                        borderWidth: 2,
                        fill: true,
                        backgroundColor: gradient,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 4,
                        pointHoverBackgroundColor: PRIMARY_RED
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            enabled: true,
                            displayColors: false,
                            callbacks: {
                                label: (context) => `${context.raw} ${ind.unit}`
                            }
                        }
                    },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    }
                }
            });
        });
    }

    // Mendapatkan 4 KPI cards yang aktif (Kabupaten vs Kecamatan terpilih)
    function getActiveKPIIndicators() {
        if (currentWilayah === 'kabupaten') {
            return config.kabupatenHeadlines || config.headlineIndicators || [];
        }

        const kec = (config.allKecamatan || []).find(k => k.id === currentWilayah);
        if (kec && kec.kpi_cards) {
            return kec.kpi_cards;
        }

        return config.kabupatenHeadlines || [];
    }

    // ==========================================
    // 2. Inisialisasi Main Sektoral Chart (Chart.js)
    // ==========================================
    function initMainChart() {
        const canvas = document.getElementById('sektoralMainChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const sectorData = getActiveSectorData();
        const isDarkMode = document.documentElement.classList.contains('dark');

        const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.06)';
        const textColor = isDarkMode ? '#A1A1AA' : '#71717A';

        // Urutkan tahun sesuai mode (desc = 2024 -> 2020, asc = 2020 -> 2024)
        let trend = sectorData.trend ? [...sectorData.trend] : [];
        if (currentTimeOrder === 'asc') {
            trend.sort((a, b) => a.year - b.year);
        } else {
            trend.sort((a, b) => b.year - a.year);
        }

        const labels = trend.map(t => String(t.year));
        const values = trend.map(t => t.value);

        if (mainChartInstance) {
            mainChartInstance.destroy();
        }

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(220, 38, 38, 0.35)');
        gradient.addColorStop(1, 'rgba(220, 38, 38, 0.0)');

        let chartConfig = {
            type: currentChartMode === 'bar' ? 'bar' : 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: sectorData.name,
                    data: values,
                    borderColor: PRIMARY_RED,
                    borderWidth: currentChartMode === 'bar' ? 0 : 2.5,
                    backgroundColor: currentChartMode === 'bar' ? PRIMARY_RED : (currentChartMode === 'area' ? gradient : 'transparent'),
                    fill: currentChartMode === 'area',
                    tension: 0.35,
                    pointRadius: currentChartMode === 'bar' ? 0 : 5,
                    pointBackgroundColor: '#FFFFFF',
                    pointBorderColor: PRIMARY_RED,
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    borderRadius: currentChartMode === 'bar' ? 6 : 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDarkMode ? '#27272A' : '#FFFFFF',
                        titleColor: isDarkMode ? '#FAFAFA' : '#18181B',
                        bodyColor: isDarkMode ? '#A1A1AA' : '#71717A',
                        borderColor: isDarkMode ? '#3F3F46' : '#E4E4E7',
                        borderWidth: 1,
                        padding: 10,
                        boxPadding: 4,
                        callbacks: {
                            label: (context) => ` ${sectorData.name}: ${formatNumber(context.raw, sectorData.column?.digits || 2)} ${sectorData.unit}`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor, font: { family: 'JetBrains Mono', size: 11 } }
                    },
                    y: {
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { color: textColor, font: { family: 'JetBrains Mono', size: 11 } }
                    }
                }
            }
        };

        mainChartInstance = new Chart(ctx, chartConfig);
    }

    // Mendapatkan data sektor aktif (Kabupaten vs Kecamatan terpilih)
    function getActiveSectorData() {
        const baseSector = config.sectorIndicators[currentSectorId] || config.sectorIndicators['kependudukan'];
        const copy = JSON.parse(JSON.stringify(baseSector));

        if (currentWilayah !== 'kabupaten') {
            const kec = (config.allKecamatan || []).find(k => k.id === currentWilayah);
            if (kec && kec.sector_trends && kec.sector_trends[currentSectorId]) {
                copy.name = `${copy.column.label} Kec. ${kec.name}`;
                copy.trend = kec.sector_trends[currentSectorId];
                const pt = copy.trend.find(t => t.year === Number(currentYear));
                copy.value = pt ? pt.value : (copy.trend[0]?.value || 0);
            }
        }

        return copy;
    }

    // ==========================================
    // 3. Update Dinamis Ketika Wilayah Berubah
    // ==========================================
    function updateWilayahView(wilayahId) {
        currentWilayah = wilayahId;
        const banner = document.getElementById('active-wilayah-banner');
        const kpiContainer = document.getElementById('kpi-grid-container');

        if (wilayahId === 'kabupaten') {
            if (banner) banner.classList.add('hidden');
            renderKPICards(config.kabupatenHeadlines);
        } else {
            const kec = (config.allKecamatan || []).find(k => k.id === wilayahId);
            if (kec) {
                if (banner) {
                    banner.classList.remove('hidden');
                    document.getElementById('active-wilayah-name').textContent = `Kecamatan ${kec.name}`;
                    document.getElementById('active-wilayah-capital').textContent = kec.capital;
                    document.getElementById('active-wilayah-area').textContent = formatNumber(kec.area_km2, 2);
                }
                renderKPICards(kec.kpi_cards);
            }
        }

        // Highlight baris tabel kecamatan
        highlightTableRow(wilayahId);

        // Update sektor view & chart
        switchSector(currentSectorId);
    }

    // Render 4 KPI cards secara dinamis
    function renderKPICards(indicators) {
        const container = document.getElementById('kpi-grid-container');
        if (!container || !indicators) return;

        container.innerHTML = '';

        indicators.forEach(ind => {
            const isGood = ind.lower_is_better ? (ind.yoy_change < 0) : (ind.yoy_change >= 0);
            const digits = (ind.unit === 'Poin' || ind.unit === '%' || (ind.unit && ind.unit.includes('Juta'))) ? 2 : 0;
            
            let iconName = 'trending-up';
            if (ind.id.includes('ipm') || ind.id.includes('area') || ind.id.includes('tani')) iconName = 'graduation-cap';
            else if (ind.id.includes('kemiskinan') || ind.id.includes('density')) iconName = 'trending-down';
            else if (ind.id.includes('pop') || ind.id.includes('penduduk')) iconName = 'users';
            else if (ind.id.includes('tpt') || ind.id.includes('kerja')) iconName = 'briefcase';

            const card = document.createElement('div');
            card.className = 'kpi-card';
            card.setAttribute('data-indicator-id', ind.id);

            card.innerHTML = `
                <div class="kpi-header">
                    <div class="kpi-title-wrap">
                        <div class="kpi-icon-wrap">
                            <i data-lucide="${iconName}" class="icon-md"></i>
                        </div>
                        <div>
                            <h3 class="kpi-name">${ind.short_name || ind.name}</h3>
                            <p class="kpi-sub">${ind.metadata ? ind.metadata.satuan : ind.unit}</p>
                        </div>
                    </div>

                    <button type="button" class="btn-info" onclick="openMetadataModal('${ind.id}')" title="Lihat Metadata SDI">
                        <i data-lucide="info" class="icon-sm"></i>
                    </button>
                </div>

                <div class="kpi-body">
                    <div class="kpi-value-row">
                        <span class="kpi-number font-mono" id="kpi-val-${ind.id}">
                            ${formatNumber(ind.value, digits)}
                        </span>
                        <span class="kpi-unit">${ind.unit}</span>
                    </div>

                    <div class="kpi-meta-row">
                        <span class="trend-badge ${isGood ? 'trend-positive' : 'trend-negative'}">
                            <i data-lucide="${ind.yoy_change < 0 ? 'arrow-down-right' : 'arrow-up-right'}" class="icon-xs"></i>
                            ${ind.yoy_change > 0 ? '+' : ''}${formatNumber(ind.yoy_change, 2)}% YoY
                        </span>
                        <span class="kpi-year-label font-mono">Tahun ${currentYear}</span>
                    </div>

                    <div class="kpi-sparkline-wrap">
                        <canvas id="spark-${ind.id}" class="kpi-sparkline" width="220" height="40"></canvas>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

        if (window.lucide) window.lucide.createIcons();
        initSparklines(indicators);
    }

    // Highlight baris tabel kecamatan terpilih
    function highlightTableRow(wilayahId) {
        document.querySelectorAll('#tbody-kecamatan tr').forEach(tr => {
            const id = tr.getAttribute('data-kecamatan-id');
            const badge = tr.querySelector('.kecamatan-badge');
            const fill = tr.querySelector('.proportion-bar-fill');
            const nameStack = tr.querySelector('.kecamatan-name-stack');
            
            // Remove existing badge-fokus-wilayah
            const existingFocus = tr.querySelector('.badge-fokus-wilayah');
            if (existingFocus) existingFocus.remove();

            if (wilayahId !== 'kabupaten' && id === wilayahId) {
                tr.classList.add('row-selected-highlight');
                if (badge) badge.classList.add('badge-active');
                if (fill) fill.classList.add('fill-active');
                if (nameStack) {
                    const span = document.createElement('span');
                    span.className = 'badge-fokus-wilayah';
                    span.textContent = 'Wilayah Terpilih';
                    nameStack.appendChild(span);
                }
            } else {
                tr.classList.remove('row-selected-highlight');
                if (badge) badge.classList.remove('badge-active');
                if (fill) fill.classList.remove('fill-active');
            }
        });
    }

    // ==========================================
    // 4. Update Tampilan Sektor & Chart
    // ==========================================
    function switchSector(sectorId) {
        currentSectorId = sectorId;
        const sectorData = getActiveSectorData();
        if (!sectorData) return;

        // Update Tab active state
        document.querySelectorAll('.sektor-tab-btn').forEach(btn => {
            if (btn.getAttribute('data-sector') === sectorId) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // Update Card Details
        const elName = document.getElementById('chart-indicator-name');
        const elProducer = document.getElementById('chart-producer');
        const elUnit = document.getElementById('chart-unit');
        const elWilayah = document.getElementById('chart-wilayah-name');
        const elStat = document.getElementById('chart-current-stat');
        const elAnalysis = document.getElementById('chart-analysis-text');
        const elTableLabel = document.getElementById('table-indicator-label');
        const elThMetric = document.getElementById('th-metric-header');
        const elExportCsv = document.getElementById('btn-export-csv');

        const activeKec = (config.allKecamatan || []).find(k => k.id === currentWilayah);
        const wilayahLabel = activeKec ? `Kec. ${activeKec.name}` : 'Kabupaten Bangka';

        if (elName) elName.textContent = sectorData.name;
        if (elProducer) elProducer.textContent = sectorData.metadata.produsen;
        if (elUnit) elUnit.textContent = sectorData.unit;
        if (elWilayah) elWilayah.textContent = wilayahLabel;
        if (elStat) {
            elStat.textContent = `Thn ${currentYear}: ${formatNumber(sectorData.value, sectorData.column?.digits || 2)} ${sectorData.unit}`;
        }
        if (elTableLabel) elTableLabel.textContent = sectorData.column.label;
        if (elThMetric) elThMetric.textContent = `${sectorData.column.label} (${sectorData.column.unit})`;

        if (elExportCsv) {
            elExportCsv.href = `${config.routes.downloadCsv}/${sectorId}/${currentYear}`;
        }

        if (elAnalysis) {
            const isPos = sectorData.yoy_change >= 0;
            const sign = sectorData.yoy_change > 0 ? '+' : '';
            elAnalysis.innerHTML = `<strong>Analisis Tren:</strong> Indikator <strong>${sectorData.name}</strong> di <strong>${wilayahLabel}</strong> tercatat sebesar <strong>${formatNumber(sectorData.value, sectorData.column?.digits || 2)} ${sectorData.unit}</strong> pada tahun ${currentYear} dengan rujukan resmi ${sectorData.metadata.produsen}.`;
        }

        // Re-render chart
        initMainChart();

        // Update Table Rows
        updateTableForSector(sectorId);
    }

    // ==========================================
    // 5. Update Tabel Kecamatan
    // ==========================================
    function updateTableForSector(sectorId) {
        const sectorData = config.sectorIndicators[sectorId];
        if (!sectorData || !config.allKecamatan) return;

        const col = sectorData.column;
        let maxVal = 1;

        const rowsData = config.allKecamatan.map(k => {
            let currentVal = k[col.key] || 0;
            if (k.sector_trends && k.sector_trends[sectorId]) {
                const pt = k.sector_trends[sectorId].find(t => t.year === Number(currentYear));
                if (pt) currentVal = pt.value;
            }

            if (currentVal > maxVal) maxVal = currentVal;
            return {
                id: k.id,
                name: k.name,
                capital: k.capital,
                value: currentVal,
                area: k.area_km2
            };
        });

        const tbody = document.getElementById('tbody-kecamatan');
        if (!tbody) return;

        const query = (document.getElementById('input-kecamatan-search')?.value || '').toLowerCase();
        tbody.innerHTML = '';

        rowsData
            .filter(r => r.name.toLowerCase().includes(query) || r.capital.toLowerCase().includes(query))
            .forEach((r, idx) => {
                const prop = Math.min(100, (r.value / maxVal) * 100);
                const isSelected = (currentWilayah === r.id);

                const tr = document.createElement('tr');
                tr.setAttribute('data-kecamatan-id', r.id);
                tr.setAttribute('data-name', r.name.toLowerCase());
                tr.setAttribute('data-capital', r.capital.toLowerCase());
                tr.setAttribute('data-value', r.value);
                if (isSelected) tr.className = 'row-selected-highlight';

                tr.innerHTML = `
                    <td class="td-center font-mono td-rank-val">${idx + 1}</td>
                    <td class="td-name">
                        <div class="kecamatan-identity">
                            <span class="kecamatan-badge ${isSelected ? 'badge-active' : ''}">${r.name.slice(0, 2).toUpperCase()}</span>
                            <div class="kecamatan-name-stack">
                                <span class="font-semibold text-foreground">Kecamatan ${r.name}</span>
                                ${isSelected ? '<span class="badge-fokus-wilayah">Wilayah Terpilih</span>' : ''}
                            </div>
                        </div>
                    </td>
                    <td class="td-center text-muted-foreground">${r.capital}</td>
                    <td class="td-right font-mono font-bold td-value">
                        ${formatNumber(r.value, col.digits || 0)}
                        <span class="td-unit">${col.unit}</span>
                    </td>
                    <td class="td-bar">
                        <div class="proportion-bar-wrap">
                            <div class="proportion-bar-track">
                                <div class="proportion-bar-fill ${isSelected ? 'fill-active' : ''}" style="width: ${prop}%"></div>
                            </div>
                            <span class="proportion-pct font-mono">${Math.round(prop)}%</span>
                        </div>
                    </td>
                    <td class="td-center font-mono text-muted-foreground">${formatNumber(r.area, 2)}</td>
                `;
                tbody.appendChild(tr);
            });

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    // ==========================================
    // 6. Search & Sort Tabel Kecamatan
    // ==========================================
    const searchInput = document.getElementById('input-kecamatan-search');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#tbody-kecamatan tr');
            rows.forEach(tr => {
                const name = tr.getAttribute('data-name') || '';
                const capital = tr.getAttribute('data-capital') || '';
                if (name.includes(query) || capital.includes(query)) {
                    tr.style.display = '';
                } else {
                    tr.style.display = 'none';
                }
            });
        });
    }

    let sortState = { key: 'value', dir: 'desc' };
    document.querySelectorAll('.th-sortable').forEach(th => {
        th.addEventListener('click', () => {
            const sortKey = th.getAttribute('data-sort');
            if (sortState.key === sortKey) {
                sortState.dir = sortState.dir === 'asc' ? 'desc' : 'asc';
            } else {
                sortState.key = sortKey;
                sortState.dir = sortKey === 'name' ? 'asc' : 'desc';
            }

            const tbody = document.getElementById('tbody-kecamatan');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                let valA, valB;
                if (sortKey === 'name') {
                    valA = a.getAttribute('data-name');
                    valB = b.getAttribute('data-name');
                    return sortState.dir === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                } else {
                    valA = parseFloat(a.getAttribute('data-value')) || 0;
                    valB = parseFloat(b.getAttribute('data-value')) || 0;
                    return sortState.dir === 'asc' ? valA - valB : valB - valA;
                }
            });

            tbody.innerHTML = '';
            rows.forEach((r, idx) => {
                const rankCell = r.querySelector('.td-rank-val');
                if (rankCell) rankCell.textContent = idx + 1;
                tbody.appendChild(r);
            });
        });
    });

    // ==========================================
    // 7. Chart Mode Switcher (Area / Line / Bar)
    // ==========================================
    document.querySelectorAll('.chart-mode-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.chart-mode-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentChartMode = btn.getAttribute('data-mode');
            initMainChart();
        });
    });

    // Urutan Waktu (Terbaru 2024 -> 2020 vs Kronologis 2020 -> 2024)
    window.setChartTimeOrder = function(order) {
        currentTimeOrder = order;
        const btnDesc = document.getElementById('btn-order-desc');
        const btnAsc = document.getElementById('btn-order-asc');

        if (order === 'desc') {
            btnDesc?.classList.add('active');
            btnAsc?.classList.remove('active');
        } else {
            btnAsc?.classList.add('active');
            btnDesc?.classList.remove('active');
        }

        initMainChart();
        initSparklines();
    };

    // ==========================================
    // 8. Sektor Tab Switcher
    // ==========================================
    document.querySelectorAll('.sektor-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const sectorId = btn.getAttribute('data-sector');
            switchSector(sectorId);
        });
    });

    // ==========================================
    // 9. Filter Tahun & Wilayah Listeners
    // ==========================================
    const selectYear = document.getElementById('select-year');
    if (selectYear) {
        selectYear.addEventListener('change', (e) => {
            currentYear = e.target.value;
            switchSector(currentSectorId);
            const kpiData = getActiveKPIIndicators();
            initSparklines(kpiData);
        });
    }

    const selectWilayah = document.getElementById('select-wilayah');
    if (selectWilayah) {
        selectWilayah.addEventListener('change', (e) => {
            updateWilayahView(e.target.value);
        });
    }

    window.resetToKabupaten = function() {
        if (selectWilayah) {
            selectWilayah.value = 'kabupaten';
        }
        updateWilayahView('kabupaten');
    };

    // ==========================================
    // 10. Theme Toggle (Dark / Light)
    // ==========================================
    const btnTheme = document.getElementById('btn-theme');
    const themeIcon = document.getElementById('theme-icon');

    function updateThemeIcon() {
        if (!themeIcon) return;
        const isDark = document.documentElement.classList.contains('dark');
        themeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
        if (window.lucide) window.lucide.createIcons();
    }

    if (btnTheme) {
        btnTheme.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon();
            initMainChart();
            initSparklines();
        });
    }

    // ==========================================
    // Helper Format Number
    // ==========================================
    function formatNumber(val, decimals = 2) {
        const num = parseFloat(val);
        if (isNaN(num)) return val;
        return num.toLocaleString('id-ID', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }

    // Initializations
    initSparklines();
    initMainChart();
    updateThemeIcon();
});

// ==========================================
// 11. Global Metadata Modal Handlers
// ==========================================
window.openMetadataModal = function(id) {
    const modal = document.getElementById('modal-metadata');
    if (!modal) return;

    const config = window.STATISTIK_CONFIG || {};
    let indicator = null;

    // Cari di Headline Indicators
    if (config.headlineIndicators) {
        indicator = config.headlineIndicators.find(i => i.id === id);
    }

    // Cari di Sektor Indicators
    if (!indicator && config.sectorIndicators && config.sectorIndicators[id]) {
        indicator = config.sectorIndicators[id];
    }

    // Cari di Kecamatan KPI cards
    if (!indicator && config.allKecamatan) {
        config.allKecamatan.forEach(k => {
            if (k.kpi_cards) {
                const found = k.kpi_cards.find(c => c.id === id);
                if (found) indicator = found;
            }
        });
    }

    if (!indicator) return;

    document.getElementById('modal-title').textContent = indicator.name;
    document.getElementById('modal-stat').textContent = `Nilai Realisasi: ${indicator.value} ${indicator.unit} · Tahun ${config.selectedYear || 2024}`;
    document.getElementById('modal-producer').textContent = indicator.metadata ? indicator.metadata.produsen : 'BPS Kabupaten Bangka';
    document.getElementById('modal-definition').textContent = indicator.metadata ? indicator.metadata.definisi : 'Indikator resmi statistik daerah.';
    document.getElementById('modal-unit').textContent = indicator.metadata ? indicator.metadata.satuan : indicator.unit;
    document.getElementById('modal-schedule').textContent = indicator.metadata ? indicator.metadata.jadwal_rilis : 'Tahunan';
    document.getElementById('modal-methodology').textContent = indicator.metadata ? indicator.metadata.metodologi : 'Survei dan sensus resmi BPS.';

    // Populate History Grid (Terurut dari tahun terbaru)
    const historyGrid = document.getElementById('modal-history-grid');
    if (historyGrid && indicator.trend) {
        historyGrid.innerHTML = '';
        const sortedTrend = [...indicator.trend].sort((a, b) => b.year - a.year);
        sortedTrend.forEach(t => {
            const cell = document.createElement('div');
            cell.className = 'history-cell';
            cell.innerHTML = `
                <div class="history-year font-mono">${t.year}</div>
                <div class="history-val font-mono">${t.value}</div>
            `;
            historyGrid.appendChild(cell);
        });
    }

    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');

    if (window.lucide) window.lucide.createIcons();
};

window.closeMetadataModal = function() {
    const modal = document.getElementById('modal-metadata');
    if (modal) {
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
    }
};
