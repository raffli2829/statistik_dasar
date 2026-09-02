/**
 * STATISTIK DASAR - SATU DATA KABUPATEN BANGKA
 * Vanilla JavaScript Engine (Chart.js + Interactive Table & Metadata)
 */

document.addEventListener('DOMContentLoaded', () => {
    const config = window.STATISTIK_CONFIG || {};
    let currentChartMode = 'area';
    let currentSectorId = config.selectedSector || 'kependudukan';
    let currentYear = config.selectedYear || 2024;
    let mainChartInstance = null;
    let sparklineInstances = {};

    const PRIMARY_RED = '#DC2626';
    const PRIMARY_RED_LIGHT = 'rgba(220, 38, 38, 0.2)';

    // ==========================================
    // 1. Inisialisasi Sparklines untuk 4 Headline KPI
    // ==========================================
    function initSparklines() {
        if (!config.headlineIndicators) return;

        config.headlineIndicators.forEach(ind => {
            const canvas = document.getElementById(`spark-${ind.id}`);
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 40);
            gradient.addColorStop(0, 'rgba(220, 38, 38, 0.35)');
            gradient.addColorStop(1, 'rgba(220, 38, 38, 0.0)');

            const labels = ind.trend.map(t => t.year);
            const values = ind.trend.map(t => t.value);

            if (sparklineInstances[ind.id]) {
                sparklineInstances[ind.id].destroy();
            }

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

    // ==========================================
    // 2. Inisialisasi Main Sektoral Chart
    // ==========================================
    function initMainChart() {
        const canvas = document.getElementById('sektoralMainChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const sectorData = config.sectorIndicators[currentSectorId] || config.sectorIndicators['kependudukan'];
        const isDarkMode = document.documentElement.classList.contains('dark');

        const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.06)';
        const textColor = isDarkMode ? '#A1A1AA' : '#71717A';

        const labels = sectorData.trend.map(t => String(t.year));
        const values = sectorData.trend.map(t => t.value);

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
                    label: sectorData.short_name,
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
                            label: (context) => ` ${sectorData.name}: ${formatNumber(context.raw, sectorData.column.digits || 2)} ${sectorData.unit}`
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

    // ==========================================
    // 3. Update Tampilan Sektor
    // ==========================================
    function switchSector(sectorId) {
        currentSectorId = sectorId;
        const sectorData = config.sectorIndicators[sectorId];
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
        const elStat = document.getElementById('chart-current-stat');
        const elAnalysis = document.getElementById('chart-analysis-text');
        const elTableLabel = document.getElementById('table-indicator-label');
        const elThMetric = document.getElementById('th-metric-header');
        const elExportCsv = document.getElementById('btn-export-csv');
        const elExportJson = document.getElementById('btn-export-json');

        if (elName) elName.textContent = sectorData.name;
        if (elProducer) elProducer.textContent = sectorData.metadata.produsen;
        if (elUnit) elUnit.textContent = sectorData.unit;
        if (elStat) {
            elStat.textContent = `Thn ${currentYear}: ${formatNumber(sectorData.value, sectorData.column.digits || 2)} ${sectorData.unit}`;
        }
        if (elTableLabel) elTableLabel.textContent = sectorData.column.label;
        if (elThMetric) elThMetric.textContent = `${sectorData.column.label} (${sectorData.column.unit})`;

        if (elExportCsv) {
            elExportCsv.href = `${config.routes.downloadCsv}/${sectorId}/${currentYear}`;
        }
        if (elExportJson) {
            elExportJson.href = `${config.routes.downloadJson}/${sectorId}/${currentYear}`;
        }

        if (elAnalysis) {
            const isPos = sectorData.yoy_change >= 0;
            const sign = sectorData.yoy_change > 0 ? '+' : '';
            elAnalysis.innerHTML = `<strong>Analisis Tren:</strong> Indikator <strong>${sectorData.name}</strong> mengalami perubahan <strong class="${isPos ? 'text-emerald-600' : 'text-rose-600'}">${sign}${formatNumber(sectorData.yoy_change, 2)}%</strong> secara tahunan dengan rujukan resmi ${sectorData.metadata.produsen}.`;
        }

        // Re-render chart
        initMainChart();

        // Update Table Rows
        updateTableForSector(sectorId);
    }

    // ==========================================
    // 4. Update Tabel Kecamatan
    // ==========================================
    function updateTableForSector(sectorId) {
        const sectorData = config.sectorIndicators[sectorId];
        if (!sectorData || !config.allKecamatan) return;

        const col = sectorData.column;
        const years = config.years;
        const yearIndex = Math.max(0, years.indexOf(Number(currentYear)));
        const yearFactor = 1 - (years.length - 1 - yearIndex) * 0.02;

        let maxVal = 1;
        const rowsData = config.allKecamatan.map(k => {
            const baseVal = k[col.key] || 0;
            const currentVal = baseVal * yearFactor;
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

        // Render rows
        const query = (document.getElementById('input-kecamatan-search')?.value || '').toLowerCase();
        tbody.innerHTML = '';

        rowsData
            .filter(r => r.name.toLowerCase().includes(query) || r.capital.toLowerCase().includes(query))
            .forEach((r, idx) => {
                const prop = Math.min(100, (r.value / maxVal) * 100);
                const tr = document.createElement('tr');
                tr.setAttribute('data-kecamatan-id', r.id);
                tr.setAttribute('data-name', r.name.toLowerCase());
                tr.setAttribute('data-capital', r.capital.toLowerCase());
                tr.setAttribute('data-value', r.value);

                tr.innerHTML = `
                    <td class="td-center font-mono td-rank-val">${idx + 1}</td>
                    <td class="td-name">
                        <div class="kecamatan-identity">
                            <span class="kecamatan-badge">${r.name.slice(0, 2).toUpperCase()}</span>
                            <span class="font-semibold text-foreground">Kecamatan ${r.name}</span>
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
                                <div class="proportion-bar-fill" style="width: ${prop}%"></div>
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
    // 5. Search & Sort Tabel Kecamatan
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
    // 6. Chart Mode Switcher (Area / Line / Bar)
    // ==========================================
    document.querySelectorAll('.chart-mode-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.chart-mode-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentChartMode = btn.getAttribute('data-mode');
            initMainChart();
        });
    });

    // ==========================================
    // 7. Sektor Tab Switcher
    // ==========================================
    document.querySelectorAll('.sektor-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const sectorId = btn.getAttribute('data-sector');
            switchSector(sectorId);
        });
    });

    // ==========================================
    // 8. Filter Tahun & Wilayah
    // ==========================================
    const selectYear = document.getElementById('select-year');
    if (selectYear) {
        selectYear.addEventListener('change', (e) => {
            currentYear = e.target.value;
            switchSector(currentSectorId);
        });
    }

    const selectWilayah = document.getElementById('select-wilayah');
    if (selectWilayah) {
        selectWilayah.addEventListener('change', (e) => {
            const val = e.target.value;
            const rows = document.querySelectorAll('#tbody-kecamatan tr');
            rows.forEach(tr => {
                const id = tr.getAttribute('data-kecamatan-id');
                if (val === 'kabupaten' || id === val) {
                    tr.style.display = '';
                } else {
                    tr.style.display = 'none';
                }
            });
        });
    }

    // ==========================================
    // 9. Theme Toggle (Dark / Light)
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
    // 10. Tombol Share (Copy URL)
    // ==========================================
    const btnShare = document.getElementById('btn-share');
    const shareText = document.getElementById('share-text');
    if (btnShare) {
        btnShare.addEventListener('click', () => {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(window.location.href);
                if (shareText) shareText.textContent = 'Tersalin!';
                setTimeout(() => {
                    if (shareText) shareText.textContent = 'Bagikan';
                }, 2000);
            }
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

    if (!indicator) return;

    document.getElementById('modal-title').textContent = indicator.name;
    document.getElementById('modal-stat').textContent = `Nilai Realisasi: ${indicator.value} ${indicator.unit} · Tahun ${config.selectedYear || 2024}`;
    document.getElementById('modal-producer').textContent = indicator.metadata.produsen || 'BPS Kabupaten Bangka';
    document.getElementById('modal-definition').textContent = indicator.metadata.definisi || '-';
    document.getElementById('modal-unit').textContent = indicator.metadata.satuan || indicator.unit;
    document.getElementById('modal-schedule').textContent = indicator.metadata.jadwal_rilis || 'Tahunan';
    document.getElementById('modal-methodology').textContent = indicator.metadata.metodologi || '-';

    // Populate History Grid
    const historyGrid = document.getElementById('modal-history-grid');
    if (historyGrid && indicator.trend) {
        historyGrid.innerHTML = '';
        indicator.trend.forEach(t => {
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
