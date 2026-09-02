import { createFileRoute } from "@tanstack/react-router";
import { useMemo, useState } from "react";
import {
  ArrowDownRight,
  ArrowUpRight,
  ArrowUpDown,
  ExternalLink,
  Info,
  Search,
  Users,
  Briefcase,
  HeartPulse,
  GraduationCap,
  Wheat,
  ShieldCheck,
  TrendingUp,
  BarChart3,
  Layers,
  FileSpreadsheet,
  Code2,
  CheckCircle2,
  Share2,
  Sparkles,
  Database,
  Building2,
  MapPin,
  Activity,
  Calendar,
  FileText,
  type LucideIcon,
} from "lucide-react";
import {
  Area,
  AreaChart,
  Bar,
  BarChart,
  CartesianGrid,
  Line,
  LineChart,
  ResponsiveContainer,
  Tooltip,
  XAxis,
  YAxis,
} from "recharts";

import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import {
  Sheet,
  SheetContent,
  SheetDescription,
  SheetHeader,
  SheetTitle,
} from "@/components/ui/sheet";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Separator } from "@/components/ui/separator";
import {
  HEADLINE_INDICATORS,
  KECAMATAN,
  SECTORS,
  SECTOR_INDICATORS,
  SECTOR_TABLE_COLUMN,
  FEATURED_DATASETS,
  YEARS,
  formatNumber,
  type KecamatanData,
  type SectorId,
  type StatisticIndicator,
} from "@/data/bangka-statistics";

export const Route = createFileRoute("/")({
  head: () => ({
    meta: [
      { title: "Statistik Dasar - Open Data Portal Pemerintah Kabupaten Bangka" },
      {
        name: "description",
        content:
          "Halaman resmi Statistik Dasar Satu Data Kabupaten Bangka. Akses indikator makro pembangunan, statistik sektoral, dan perbandingan 8 kecamatan.",
      },
      { property: "og:title", content: "Statistik Dasar - Satu Data Kabupaten Bangka" },
      {
        property: "og:description",
        content:
          "Penyajian indikator makro pembangunan dan data statistik sektoral 8 kecamatan di Kabupaten Bangka.",
      },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary_large_image" },
    ],
  }),
  component: StatistikDasarSubPage,
});

const SECTOR_ICON_MAP: Record<SectorId, LucideIcon> = {
  kependudukan: Users,
  perekonomian: TrendingUp,
  ketenagakerjaan: Briefcase,
  kesehatan: HeartPulse,
  pendidikan: GraduationCap,
  pertanian: Wheat,
  sosial: ShieldCheck,
};

type ChartMode = "area" | "line" | "bar";
type SortKey = "name" | "value";
type SortDir = "asc" | "desc";

// Primary red palette constants for charts
const PRIMARY_RED = "#DC2626"; // Vibrant Red (Pemkab Bangka Red)

function TrendBadge({ change, lowerIsBetter }: { change: number; lowerIsBetter: boolean }) {
  const isPositiveChange = change > 0;
  const isGoodOutcome = lowerIsBetter ? change < 0 : change > 0;
  const Icon = change < 0 ? ArrowDownRight : ArrowUpRight;

  return (
    <span
      className={`inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold tabular-nums transition-colors ${
        isGoodOutcome
          ? "border border-emerald-500/25 bg-emerald-500/10 text-emerald-700 dark:text-emerald-300"
          : "border border-rose-500/25 bg-rose-500/10 text-rose-700 dark:text-rose-300"
      }`}
    >
      <Icon size={12} strokeWidth={2.2} />
      {isPositiveChange ? "+" : ""}
      {formatNumber(change, 2)}% YoY
    </span>
  );
}

function MiniSparkline({
  data,
  color = PRIMARY_RED,
}: {
  data: { year: number; value: number }[];
  color?: string | undefined;
}) {
  const strokeColor = color ?? PRIMARY_RED;
  return (
    <div className="h-10 w-full pt-1">
      <ResponsiveContainer width="100%" height="100%">
        <AreaChart data={data} margin={{ top: 2, right: 0, bottom: 0, left: 0 }}>
          <defs>
            <linearGradient
              id={`spark-grad-${strokeColor.replace(/[^a-zA-Z0-9]/g, "")}`}
              x1="0"
              y1="0"
              x2="0"
              y2="1"
            >
              <stop offset="0%" stopColor={strokeColor} stopOpacity={0.35} />
              <stop offset="100%" stopColor={strokeColor} stopOpacity={0.0} />
            </linearGradient>
          </defs>
          <Area
            type="monotone"
            dataKey="value"
            stroke={strokeColor}
            strokeWidth={2}
            fill={`url(#spark-grad-${strokeColor.replace(/[^a-zA-Z0-9]/g, "")})`}
            isAnimationActive={true}
            animationDuration={600}
          />
        </AreaChart>
      </ResponsiveContainer>
    </div>
  );
}

function StatistikDasarSubPage() {
  const [year, setYear] = useState<string>("2026");
  const [wilayah, setWilayah] = useState<string>("kabupaten");
  const [sector, setSector] = useState<SectorId>("kependudukan");
  const [chartMode, setChartMode] = useState<ChartMode>("area");
  const [kecamatanQuery, setKecamatanQuery] = useState("");
  const [datasetSearch, setDatasetSearch] = useState("");
  const [sortKey, setSortKey] = useState<SortKey>("value");
  const [sortDir, setSortDir] = useState<SortDir>("desc");
  const [sheetIndicator, setSheetIndicator] = useState<StatisticIndicator | null>(null);
  const [copiedLink, setCopiedLink] = useState(false);

  const selectedYear = Number(year);
  const yearIndex = Math.max(0, YEARS.indexOf(selectedYear as (typeof YEARS)[number]));
  const sectorIndicator = SECTOR_INDICATORS[sector] || SECTOR_INDICATORS.kependudukan;
  const column = SECTOR_TABLE_COLUMN[sector] || SECTOR_TABLE_COLUMN.kependudukan;
  const SectorIcon = SECTOR_ICON_MAP[sector] || Users;

  // Scale kecamatan values dynamically per selected year
  const yearFactor = 1 - (YEARS.length - 1 - yearIndex) * 0.018;

  const kecamatanRows = useMemo(() => {
    const rawList = KECAMATAN.filter((k) => wilayah === "kabupaten" || k.id === wilayah).map(
      (k: KecamatanData) => {
        const baseValue = (k[column.key] as number) || 0;
        return {
          id: k.id,
          name: k.name,
          value: baseValue * yearFactor,
          rawValue: baseValue,
        };
      },
    );

    const filtered = rawList.filter((r) =>
      r.name.toLowerCase().includes(kecamatanQuery.trim().toLowerCase()),
    );

    return filtered.sort((a, b) => {
      const cmp = sortKey === "name" ? a.name.localeCompare(b.name) : a.value - b.value;
      return sortDir === "asc" ? cmp : -cmp;
    });
  }, [column.key, kecamatanQuery, sortDir, sortKey, wilayah, yearFactor]);

  const maxKecamatanVal = useMemo(() => {
    if (kecamatanRows.length === 0) return 1;
    return Math.max(...kecamatanRows.map((r) => r.value));
  }, [kecamatanRows]);

  const chartData = useMemo(() => {
    return sectorIndicator.trend.map((p) => ({
      ...p,
      label: String(p.year),
      displayVal: p.value,
    }));
  }, [sectorIndicator]);

  const filteredDatasets = useMemo(() => {
    if (!datasetSearch.trim()) return FEATURED_DATASETS;
    const q = datasetSearch.toLowerCase();
    return FEATURED_DATASETS.filter(
      (d) =>
        d.title.toLowerCase().includes(q) ||
        d.category.toLowerCase().includes(q) ||
        d.opd.toLowerCase().includes(q),
    );
  }, [datasetSearch]);

  const toggleSort = (key: SortKey) => {
    if (key === sortKey) {
      setSortDir((d) => (d === "asc" ? "desc" : "asc"));
    } else {
      setSortKey(key);
      setSortDir(key === "name" ? "asc" : "desc");
    }
  };

  const downloadCsv = () => {
    const header = `Peringkat,Kecamatan,${column.label} (${column.unit}),Tahun,Wilayah,Sumber\n`;
    const body = kecamatanRows
      .map(
        (r, idx) =>
          `${idx + 1},${r.name},${r.value.toFixed(column.digits)},${selectedYear},Kabupaten Bangka,"${sectorIndicator.metadata.produsen}"`,
      )
      .join("\n");
    const blob = new Blob([header + body], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = `satudata-bangka-${sector}-${selectedYear}.csv`;
    a.click();
    URL.revokeObjectURL(url);
  };

  const downloadJson = () => {
    const exportPayload = {
      portal: "Satu Data Kabupaten Bangka",
      halaman: "Statistik Dasar",
      sektor: sector,
      indikator: sectorIndicator.name,
      satuan: sectorIndicator.unit,
      tahun: selectedYear,
      produsenData: sectorIndicator.metadata.produsen,
      tanggalUnduh: new Date().toISOString(),
      kecamatan: kecamatanRows.map((r, idx) => ({
        peringkat: idx + 1,
        nama: r.name,
        nilai: Number(r.value.toFixed(column.digits)),
        satuan: column.unit,
      })),
    };
    const blob = new Blob([JSON.stringify(exportPayload, null, 2)], {
      type: "application/json;charset=utf-8;",
    });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = `satudata-bangka-${sector}-${selectedYear}.json`;
    a.click();
    URL.revokeObjectURL(url);
  };

  const handleShare = () => {
    if (typeof navigator !== "undefined" && navigator.clipboard) {
      navigator.clipboard.writeText(window.location.href);
      setCopiedLink(true);
      setTimeout(() => setCopiedLink(false), 2000);
    }
  };

  return (
    <div className="relative flex min-h-dvh flex-col bg-background font-sans antialiased text-foreground">
      {/* Background Ambient Red Glows & Subtle Grid matching satudata.bangka.go.id */}
      <div className="pointer-events-none fixed inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div className="absolute -left-1/4 -top-1/4 h-[500px] w-[500px] rounded-full bg-primary/10 blur-3xl" />
        <div className="absolute -bottom-1/4 -right-1/4 h-[500px] w-[500px] rounded-full bg-rose-500/10 blur-3xl" />
        <div className="absolute left-1/2 top-1/2 h-[400px] w-[400px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-orange-500/5 blur-3xl" />
      </div>
      <div
        className="pointer-events-none fixed inset-0 -z-10 opacity-[0.015] dark:opacity-[0.025]"
        aria-hidden="true"
        style={{
          backgroundImage: `linear-gradient(to right, rgb(0 0 0 / 0.1) 1px, transparent 1px), linear-gradient(to bottom, rgb(0 0 0 / 0.1) 1px, transparent 1px)`,
          backgroundSize: "64px 64px",
        }}
      />

      {/* MAIN CONTENT WRAPPER (SUB-HALAMAN STATISTIK DASAR) */}
      <main id="main-content" className="relative flex-1" role="main">
        {/* 1. HERO SECTION / SUBPAGE HEADER */}
        <section
          id="statistik-dasar"
          className="bg-gradient-to-b from-primary/5 via-background to-background py-8 sm:py-12"
        >
          <div className="container mx-auto px-4">
            <div className="mx-auto max-w-4xl text-center space-y-4">
              {/* Breadcrumb Sesuai Struktur Portal */}
              <nav aria-label="Breadcrumb" className="inline-flex items-center gap-1.5 text-xs text-muted-foreground">
                <a href="https://satudata.bangka.go.id" className="hover:text-primary transition-colors">
                  Beranda
                </a>
                <span>/</span>
                <span>Sektoral</span>
                <span>/</span>
                <span className="font-semibold text-primary">Statistik Dasar</span>
              </nav>

              <h1 className="text-3xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl text-foreground">
                Statistik Dasar
                <br />
                <span className="text-primary">Pemerintah Kabupaten Bangka</span>
              </h1>

              <p className="mx-auto max-w-2xl text-sm leading-relaxed text-muted-foreground sm:text-base md:text-lg">
                Penyajian indikator makro pembangunan, data statistik sektoral, dan perbandingan
                kewilayahan 8 kecamatan di Kabupaten Bangka terverifikasi BPS &amp; Walidata Daerah.
              </p>

              {/* Filter Controls (Tahun & Wilayah) */}
              <div className="mx-auto flex flex-wrap items-center justify-center gap-3 pt-2">
                <div className="flex items-center gap-2 rounded-full border border-border/80 bg-card px-3 py-1 shadow-sm">
                  <Calendar size={14} className="text-primary" />
                  <span className="text-xs font-medium text-muted-foreground">Tahun:</span>
                  <Select value={year} onValueChange={setYear}>
                    <SelectTrigger className="h-7 w-20 border-none bg-transparent font-mono text-xs font-bold focus:ring-0 p-0">
                      <SelectValue placeholder="Tahun" />
                    </SelectTrigger>
                    <SelectContent>
                      {YEARS.map((y) => (
                        <SelectItem key={y} value={String(y)} className="font-mono text-xs">
                          {y}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                <div className="flex items-center gap-2 rounded-full border border-border/80 bg-card px-3 py-1 shadow-sm">
                  <MapPin size={14} className="text-primary" />
                  <span className="text-xs font-medium text-muted-foreground">Wilayah:</span>
                  <Select value={wilayah} onValueChange={setWilayah}>
                    <SelectTrigger className="h-7 w-40 border-none bg-transparent text-xs font-bold focus:ring-0 p-0">
                      <SelectValue placeholder="Wilayah" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="kabupaten">Kabupaten Bangka</SelectItem>
                      {KECAMATAN.map((k) => (
                        <SelectItem key={k.id} value={k.id}>
                          Kec. {k.name}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                <Button
                  variant="outline"
                  size="sm"
                  onClick={handleShare}
                  className="h-8 gap-1 rounded-full text-xs font-medium"
                >
                  {copiedLink ? (
                    <>
                      <CheckCircle2 size={13} className="text-emerald-500" />
                      <span className="text-emerald-600">Tersalin!</span>
                    </>
                  ) : (
                    <>
                      <Share2 size={13} />
                      <span>Bagikan</span>
                    </>
                  )}
                </Button>
              </div>

              {/* 4 KPI Cards (DENGAN TEMA WARNA MERAH SATUDATA BANGKA) */}
              <div className="grid grid-cols-1 gap-4 pt-6 sm:grid-cols-2 lg:grid-cols-4">
                {HEADLINE_INDICATORS.map((ind) => {
                  const Icon = SECTOR_ICON_MAP[ind.sector] || TrendingUp;
                  const displayed = ind.trend[yearIndex]?.value ?? ind.value;

                  return (
                    <div
                      key={ind.id}
                      className="bg-card text-card-foreground flex flex-col justify-between rounded-xl border p-5 shadow-sm transition-all duration-200 hover:shadow-lg hover:border-primary/50 text-left"
                    >
                      <div className="flex items-start justify-between gap-2">
                        <div className="flex items-center gap-3">
                          <div className="rounded-full bg-primary/10 p-2.5 text-primary">
                            <Icon size={18} />
                          </div>
                          <div>
                            <p className="text-xs font-bold text-muted-foreground">{ind.shortName}</p>
                            <p className="text-[10px] text-muted-foreground/80">{ind.metadata.satuan}</p>
                          </div>
                        </div>

                        <button
                          type="button"
                          onClick={() => setSheetIndicator(ind)}
                          className="rounded-lg p-1 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
                          title="Lihat Metadata SDI"
                        >
                          <Info size={14} />
                        </button>
                      </div>

                      <div className="mt-3 space-y-1">
                        <div className="flex items-baseline gap-1.5">
                          <span className="font-mono text-2xl font-bold tracking-tight text-foreground sm:text-3xl">
                            {formatNumber(displayed, 2)}
                          </span>
                          <span className="text-xs font-medium text-muted-foreground">{ind.unit}</span>
                        </div>

                        <div className="flex items-center justify-between pt-1">
                          <TrendBadge change={ind.yoyChange} lowerIsBetter={ind.lowerIsBetter} />
                          <span className="text-[10px] font-mono text-muted-foreground">Tahun {selectedYear}</span>
                        </div>

                        <MiniSparkline data={ind.trend} color={PRIMARY_RED} />
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>
          </div>
        </section>

        {/* 2. RUANG KERJA STATISTIK SEKTORAL */}
        <section className="py-12 bg-background border-t">
          <div className="container mx-auto px-4">
            <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
              <div>
                <h2 className="text-2xl sm:text-3xl font-bold tracking-tight flex items-center gap-2">
                  <TrendingUp className="h-6 w-6 text-primary" />
                  Eksplorasi Statistik Sektoral
                </h2>
                <p className="text-muted-foreground text-sm mt-1">
                  Tren perkembangan data 5 tahun terakhir (2022–2026) menurut bidang urusan pemerintahan.
                </p>
              </div>

              {/* Chart Mode Switcher */}
              <div className="flex items-center gap-1 rounded-xl border bg-card p-1 shadow-xs">
                <button
                  type="button"
                  onClick={() => setChartMode("area")}
                  className={`flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-all ${
                    chartMode === "area"
                      ? "bg-primary text-primary-foreground shadow-xs"
                      : "text-muted-foreground hover:text-foreground"
                  }`}
                >
                  <Layers size={13} />
                  <span>Area</span>
                </button>
                <button
                  type="button"
                  onClick={() => setChartMode("line")}
                  className={`flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-all ${
                    chartMode === "line"
                      ? "bg-primary text-primary-foreground shadow-xs"
                      : "text-muted-foreground hover:text-foreground"
                  }`}
                >
                  <Activity size={13} />
                  <span>Garis</span>
                </button>
                <button
                  type="button"
                  onClick={() => setChartMode("bar")}
                  className={`flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-all ${
                    chartMode === "bar"
                      ? "bg-primary text-primary-foreground shadow-xs"
                      : "text-muted-foreground hover:text-foreground"
                  }`}
                >
                  <BarChart3 size={13} />
                  <span>Batang</span>
                </button>
              </div>
            </div>

            {/* Sektoral Category Selector Tabs */}
            <div className="flex flex-wrap gap-2 mb-6">
              {SECTORS.map((s) => {
                const Icon = SECTOR_ICON_MAP[s.id] || Users;
                const isActive = sector === s.id;
                return (
                  <button
                    key={s.id}
                    onClick={() => setSector(s.id)}
                    className={`flex items-center gap-2 rounded-xl border px-3.5 py-2 text-xs font-semibold transition-all ${
                      isActive
                        ? "border-primary bg-primary text-primary-foreground shadow-sm"
                        : "border-border bg-card text-muted-foreground hover:bg-accent hover:text-accent-foreground"
                    }`}
                  >
                    <Icon size={14} />
                    <span>{s.label}</span>
                  </button>
                );
              })}
            </div>

            {/* Interactive Sektoral Chart */}
            <div className="bg-card text-card-foreground rounded-xl border p-6 shadow-sm">
              <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-6 border-b">
                <div className="flex items-center gap-3">
                  <div className="rounded-full bg-primary/10 p-2.5 text-primary">
                    <SectorIcon size={20} />
                  </div>
                  <div>
                    <h3 className="text-lg font-bold text-foreground">{sectorIndicator.name}</h3>
                    <p className="text-xs text-muted-foreground">
                      Produsen: {sectorIndicator.metadata.produsen} · Satuan:{" "}
                      <span className="font-semibold text-foreground">{sectorIndicator.unit}</span>
                    </p>
                  </div>
                </div>

                <div className="flex items-center gap-2">
                  <span className="rounded-md bg-primary/10 px-2.5 py-1 text-xs font-bold text-primary font-mono">
                    Thn {selectedYear}:{" "}
                    {formatNumber(sectorIndicator.trend[yearIndex]?.value ?? sectorIndicator.value, 2)}{" "}
                    {sectorIndicator.unit}
                  </span>
                  <Button
                    variant="outline"
                    size="sm"
                    onClick={() => setSheetIndicator(sectorIndicator)}
                    className="h-8 gap-1 text-xs"
                  >
                    <Info size={13} />
                    <span>Metadata</span>
                  </Button>
                </div>
              </div>

              <div className="h-[320px] w-full pt-6">
                <ResponsiveContainer width="100%" height="100%">
                  {chartMode === "area" ? (
                    <AreaChart data={chartData} margin={{ top: 10, right: 10, bottom: 0, left: -10 }}>
                      <defs>
                        <linearGradient id="mainAreaGrad" x1="0" y1="0" x2="0" y2="1">
                          <stop offset="5%" stopColor={PRIMARY_RED} stopOpacity={0.35} />
                          <stop offset="95%" stopColor={PRIMARY_RED} stopOpacity={0.0} />
                        </linearGradient>
                      </defs>
                      <CartesianGrid strokeDasharray="3 3" className="stroke-border/40" vertical={false} />
                      <XAxis
                        dataKey="label"
                        tickLine={false}
                        axisLine={false}
                        tick={{ fill: "var(--muted-foreground)", fontFamily: "var(--font-mono)", fontSize: 12 }}
                      />
                      <YAxis
                        tickLine={false}
                        axisLine={false}
                        width={60}
                        domain={["auto", "auto"]}
                        tick={{ fill: "var(--muted-foreground)", fontFamily: "var(--font-mono)", fontSize: 12 }}
                      />
                      <Tooltip
                        contentStyle={{
                          background: "var(--popover)",
                          color: "var(--popover-foreground)",
                          border: "1px solid var(--border)",
                          borderRadius: "10px",
                          fontSize: "12px",
                        }}
                        formatter={(val: number | string) => [
                          `${formatNumber(Number(val), 2)} ${sectorIndicator.unit}`,
                          sectorIndicator.shortName,
                        ]}
                      />
                      <Area
                        type="monotone"
                        dataKey="displayVal"
                        stroke={PRIMARY_RED}
                        strokeWidth={2.5}
                        fill="url(#mainAreaGrad)"
                        isAnimationActive={true}
                      />
                    </AreaChart>
                  ) : chartMode === "line" ? (
                    <LineChart data={chartData} margin={{ top: 10, right: 10, bottom: 0, left: -10 }}>
                      <CartesianGrid strokeDasharray="3 3" className="stroke-border/40" vertical={false} />
                      <XAxis
                        dataKey="label"
                        tickLine={false}
                        axisLine={false}
                        tick={{ fill: "var(--muted-foreground)", fontFamily: "var(--font-mono)", fontSize: 12 }}
                      />
                      <YAxis
                        tickLine={false}
                        axisLine={false}
                        width={60}
                        domain={["auto", "auto"]}
                        tick={{ fill: "var(--muted-foreground)", fontFamily: "var(--font-mono)", fontSize: 12 }}
                      />
                      <Tooltip
                        contentStyle={{
                          background: "var(--popover)",
                          color: "var(--popover-foreground)",
                          border: "1px solid var(--border)",
                          borderRadius: "10px",
                          fontSize: "12px",
                        }}
                        formatter={(val: number | string) => [
                          `${formatNumber(Number(val), 2)} ${sectorIndicator.unit}`,
                          sectorIndicator.shortName,
                        ]}
                      />
                      <Line
                        type="monotone"
                        dataKey="displayVal"
                        stroke={PRIMARY_RED}
                        strokeWidth={3}
                        dot={{ r: 4, strokeWidth: 2, fill: "#ffffff", stroke: PRIMARY_RED }}
                        activeDot={{ r: 6, stroke: PRIMARY_RED, strokeWidth: 2 }}
                        isAnimationActive={true}
                      />
                    </LineChart>
                  ) : (
                    <BarChart data={chartData} margin={{ top: 10, right: 10, bottom: 0, left: -10 }}>
                      <CartesianGrid strokeDasharray="3 3" className="stroke-border/40" vertical={false} />
                      <XAxis
                        dataKey="label"
                        tickLine={false}
                        axisLine={false}
                        tick={{ fill: "var(--muted-foreground)", fontFamily: "var(--font-mono)", fontSize: 12 }}
                      />
                      <YAxis
                        tickLine={false}
                        axisLine={false}
                        width={60}
                        domain={["auto", "auto"]}
                        tick={{ fill: "var(--muted-foreground)", fontFamily: "var(--font-mono)", fontSize: 12 }}
                      />
                      <Tooltip
                        contentStyle={{
                          background: "var(--popover)",
                          color: "var(--popover-foreground)",
                          border: "1px solid var(--border)",
                          borderRadius: "10px",
                          fontSize: "12px",
                        }}
                        formatter={(val: number | string) => [
                          `${formatNumber(Number(val), 2)} ${sectorIndicator.unit}`,
                          sectorIndicator.shortName,
                        ]}
                      />
                      <Bar dataKey="displayVal" fill={PRIMARY_RED} radius={[6, 6, 0, 0]} isAnimationActive={true} />
                    </BarChart>
                  )}
                </ResponsiveContainer>
              </div>

              <div className="mt-4 flex items-center justify-between rounded-lg border bg-muted/40 p-3 text-xs text-muted-foreground">
                <div className="flex items-center gap-2">
                  <Sparkles size={14} className="text-primary" />
                  <span>
                    <strong className="text-foreground">Analisis Tren:</strong> Indikator{" "}
                    <strong className="text-foreground">{sectorIndicator.name}</strong> mengalami perubahan{" "}
                    <strong
                      className={
                        sectorIndicator.yoyChange >= 0
                          ? "text-emerald-600 dark:text-emerald-400"
                          : "text-rose-600 dark:text-rose-400"
                      }
                    >
                      {sectorIndicator.yoyChange > 0 ? "+" : ""}
                      {formatNumber(sectorIndicator.yoyChange, 2)}%
                    </strong>{" "}
                    secara tahunan dengan sumber resmi {sectorIndicator.metadata.produsen}.
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* 3. MATRIKS PERBANDINGAN 8 KECAMATAN */}
        <section className="py-12 bg-muted/20 border-t">
          <div className="container mx-auto px-4">
            <div className="bg-card text-card-foreground rounded-xl border shadow-sm">
              <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-6 border-b">
                <div>
                  <h3 className="text-lg font-bold text-foreground flex items-center gap-2">
                    <MapPin className="h-5 w-5 text-primary" />
                    Distribusi 8 Kecamatan se-Kabupaten Bangka
                  </h3>
                  <p className="text-xs text-muted-foreground mt-1">
                    Capaian indikator <strong className="text-foreground">{column.label}</strong> per kecamatan pada tahun{" "}
                    {selectedYear}.
                  </p>
                </div>

                <div className="flex flex-wrap items-center gap-2">
                  <div className="relative w-full sm:w-52">
                    <Search size={13} className="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground" />
                    <Input
                      value={kecamatanQuery}
                      onChange={(e) => setKecamatanQuery(e.target.value)}
                      placeholder="Cari kecamatan..."
                      className="h-8 rounded-lg pl-8 text-xs"
                    />
                  </div>

                  <Button
                    variant="outline"
                    size="sm"
                    onClick={downloadCsv}
                    className="h-8 gap-1 text-xs font-medium"
                  >
                    <FileSpreadsheet size={13} className="text-rose-600" />
                    <span>CSV</span>
                  </Button>

                  <Button
                    variant="outline"
                    size="sm"
                    onClick={downloadJson}
                    className="h-8 gap-1 text-xs font-medium"
                  >
                    <Code2 size={13} className="text-red-600" />
                    <span>JSON</span>
                  </Button>
                </div>
              </div>

              <div className="overflow-x-auto">
                <Table>
                  <TableHeader>
                    <TableRow className="bg-muted/40">
                      <TableHead className="w-16 text-center text-xs">Peringkat</TableHead>
                      <TableHead>
                        <button
                          type="button"
                          onClick={() => toggleSort("name")}
                          className="inline-flex items-center gap-1 text-xs font-bold text-foreground hover:text-primary"
                        >
                          <span>Kecamatan</span>
                          <ArrowUpDown size={11} />
                        </button>
                      </TableHead>
                      <TableHead className="text-right">
                        <button
                          type="button"
                          onClick={() => toggleSort("value")}
                          className="inline-flex items-center gap-1 text-xs font-bold text-foreground hover:text-primary"
                        >
                          <span>
                            {column.label} ({column.unit})
                          </span>
                          <ArrowUpDown size={11} />
                        </button>
                      </TableHead>
                      <TableHead className="hidden w-[35%] sm:table-cell">Distribusi Proporsi</TableHead>
                      <TableHead className="w-14 text-right text-xs">Aksi</TableHead>
                    </TableRow>
                  </TableHeader>
                  <TableBody>
                    {kecamatanRows.length === 0 ? (
                      <TableRow>
                        <TableCell colSpan={5} className="py-8 text-center text-xs text-muted-foreground">
                          Tidak ditemukan kecamatan dengan kata kunci "{kecamatanQuery}".
                        </TableCell>
                      </TableRow>
                    ) : (
                      kecamatanRows.map((r, idx) => {
                        const proportionPct = Math.min(100, (r.value / maxKecamatanVal) * 100);
                        return (
                          <TableRow key={r.id} className="transition-colors hover:bg-muted/40">
                            <TableCell className="text-center font-mono text-xs font-semibold text-muted-foreground">
                              {idx + 1}
                            </TableCell>
                            <TableCell className="font-semibold text-foreground">
                              <div className="flex items-center gap-2">
                                <span className="flex h-6 w-6 items-center justify-center rounded-md bg-primary/10 text-[10px] font-bold text-primary">
                                  {r.name.slice(0, 2).toUpperCase()}
                                </span>
                                <span>Kecamatan {r.name}</span>
                              </div>
                            </TableCell>
                            <TableCell className="text-right font-mono text-xs font-bold tabular-nums text-foreground sm:text-sm">
                              {formatNumber(r.value, column.digits)}{" "}
                              <span className="text-xs font-normal text-muted-foreground">{column.unit}</span>
                            </TableCell>
                            <TableCell className="hidden sm:table-cell">
                              <div className="flex items-center gap-2">
                                <div className="h-1.5 w-full overflow-hidden rounded-full bg-muted">
                                  <div
                                    className="h-full rounded-full bg-gradient-to-r from-red-500 to-rose-600 transition-all duration-500"
                                    style={{ width: `${proportionPct}%` }}
                                  />
                                </div>
                                <span className="font-mono text-[10px] text-muted-foreground">
                                  {proportionPct.toFixed(0)}%
                                </span>
                              </div>
                            </TableCell>
                            <TableCell className="text-right">
                              <Button
                                variant="ghost"
                                size="icon"
                                onClick={() => setSheetIndicator(sectorIndicator)}
                                aria-label={`Detail metadata ${r.name}`}
                                className="h-7 w-7 text-muted-foreground hover:text-foreground"
                              >
                                <Info size={13} />
                              </Button>
                            </TableCell>
                          </TableRow>
                        );
                      })
                    )}
                  </TableBody>
                </Table>
              </div>
            </div>
          </div>
        </section>

        {/* 4. DATASET TERKAIT DI KATALOG SATU DATA BANGKA */}
        <section className="py-12 bg-background border-t">
          <div className="container mx-auto px-4">
            <div className="flex items-center justify-between mb-8">
              <div>
                <h2 className="text-2xl sm:text-3xl font-bold tracking-tight flex items-center gap-2">
                  <Database className="h-6 w-6 text-primary" />
                  Dataset Terkait Statistik Dasar
                </h2>
                <p className="text-muted-foreground text-sm mt-1">
                  Dataset rujukan resmi yang dipublikasikan di Open Data Portal Kabupaten Bangka.
                </p>
              </div>

              <a
                href="https://satudata.bangka.go.id/dataset"
                target="_blank"
                rel="noreferrer"
                className="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border bg-background shadow-xs hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2"
              >
                Lihat Semua
                <FileText className="ml-1 h-4 w-4" />
              </a>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {filteredDatasets.slice(0, 3).map((ds) => (
                <div
                  key={ds.id}
                  className="bg-card text-card-foreground gap-4 rounded-xl border py-6 shadow-sm h-full flex flex-col hover:shadow-lg transition-shadow"
                >
                  <div className="px-6 flex items-start justify-between gap-2">
                    <h4 className="font-semibold line-clamp-2 text-base">
                      <a href={ds.url} target="_blank" rel="noreferrer" className="hover:text-primary transition-colors">
                        {ds.title}
                      </a>
                    </h4>
                    <span className="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap border-transparent bg-secondary text-secondary-foreground shrink-0">
                      1 file
                    </span>
                  </div>

                  <div className="px-6 flex-1">
                    <p className="text-muted-foreground text-xs line-clamp-2 mb-3">
                      Dataset sektoral terverifikasi untuk perencanaan dan evaluasi pembangunan daerah.
                    </p>
                    <div className="flex flex-wrap gap-1.5">
                      <span className="inline-flex items-center rounded-md border px-2 py-0.5 text-[11px] font-medium text-foreground">
                        {ds.category.toUpperCase()}
                      </span>
                      <span className="inline-flex items-center rounded-md border px-2 py-0.5 text-[11px] font-medium text-foreground">
                        STATISTIK
                      </span>
                    </div>
                  </div>

                  <div className="px-6 border-t pt-4 flex flex-col gap-2 text-xs text-muted-foreground">
                    <div className="flex items-center gap-2 w-full">
                      <Building2 className="h-4 w-4 shrink-0 text-primary" />
                      <span className="truncate">{ds.opd}</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <Calendar className="h-4 w-4 shrink-0 text-primary" />
                      <span>Diperbarui {ds.updatedAt}</span>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>
      </main>

      {/* 5. DRAWER METADATA OPERASIONAL SDI */}
      <Sheet open={sheetIndicator !== null} onOpenChange={(o) => !o && setSheetIndicator(null)}>
        <SheetContent className="w-full overflow-y-auto sm:max-w-lg">
          {sheetIndicator && (
            <div className="space-y-5">
              <SheetHeader>
                <div className="inline-flex items-center gap-1.5 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                  <Info size={12} />
                  <span>Metadata Indikator Resmi SDI</span>
                </div>
                <SheetTitle className="text-base font-bold text-foreground">
                  {sheetIndicator.name}
                </SheetTitle>
                <SheetDescription className="font-mono text-xs tabular-nums text-muted-foreground">
                  Nilai Realisasi: {formatNumber(sheetIndicator.value, 2)} {sheetIndicator.unit} · Tahun {selectedYear}
                </SheetDescription>
              </SheetHeader>

              <div className="space-y-3.5 text-xs">
                <div className="rounded-xl border bg-muted/40 p-3 space-y-1">
                  <p className="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">
                    Produsen Data
                  </p>
                  <p className="font-semibold text-foreground">
                    {sheetIndicator.metadata.produsen}
                  </p>
                </div>

                <div className="rounded-xl border bg-muted/40 p-3 space-y-1">
                  <p className="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">
                    Definisi Operasional
                  </p>
                  <p className="leading-relaxed text-foreground">
                    {sheetIndicator.metadata.definisi}
                  </p>
                </div>

                <div className="grid grid-cols-2 gap-2">
                  <div className="rounded-xl border bg-muted/40 p-3 space-y-1">
                    <p className="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">
                      Satuan Ukur
                    </p>
                    <p className="font-semibold text-foreground">
                      {sheetIndicator.metadata.satuan}
                    </p>
                  </div>

                  <div className="rounded-xl border bg-muted/40 p-3 space-y-1">
                    <p className="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">
                      Jadwal Rilis
                    </p>
                    <p className="font-semibold text-foreground">
                      {sheetIndicator.metadata.jadwalRilis}
                    </p>
                  </div>
                </div>

                <div className="rounded-xl border bg-muted/40 p-3 space-y-1">
                  <p className="text-[10px] font-bold uppercase tracking-wider text-muted-foreground">
                    Metodologi Pengumpulan
                  </p>
                  <p className="leading-relaxed text-foreground">
                    {sheetIndicator.metadata.metodologi}
                  </p>
                </div>

                <div className="rounded-xl border bg-card p-3">
                  <p className="mb-2 text-[10px] font-bold uppercase tracking-wider text-muted-foreground">
                    Data Historis 5 Tahun (2022–2026)
                  </p>
                  <div className="grid grid-cols-5 gap-1 text-center font-mono">
                    {sheetIndicator.trend.map((pt) => (
                      <div key={pt.year} className="rounded-lg bg-muted/50 p-1.5">
                        <p className="text-[9px] text-muted-foreground">{pt.year}</p>
                        <p className="text-[11px] font-bold text-foreground">
                          {formatNumber(pt.value, 2)}
                        </p>
                      </div>
                    ))}
                  </div>
                </div>

                <Separator />

                <Button asChild className="w-full text-xs font-semibold">
                  <a href="https://satudata.bangka.go.id/dataset" target="_blank" rel="noreferrer">
                    <span>Lihat di Katalog Satu Data Bangka</span>
                    <ExternalLink size={13} className="ml-1.5" />
                  </a>
                </Button>
              </div>
            </div>
          )}
        </SheetContent>
      </Sheet>
    </div>
  );
}
