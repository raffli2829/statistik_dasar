export type SectorId =
  | "kependudukan"
  | "perekonomian"
  | "ketenagakerjaan"
  | "kesehatan"
  | "pendidikan"
  | "pertanian"
  | "sosial";

export interface TrendPoint {
  year: number;
  value: number;
}

export interface IndicatorMetadata {
  produsen: string;
  definisi: string;
  satuan: string;
  metodologi: string;
  jadwalRilis: string;
}

export interface StatisticIndicator {
  id: string;
  name: string;
  shortName: string;
  sector: SectorId;
  value: number;
  unit: string;
  yoyChange: number;
  /** true when a decrease is a good thing (e.g. poverty) */
  lowerIsBetter: boolean;
  trend: TrendPoint[];
  metadata: IndicatorMetadata;
}

export interface KecamatanData {
  id: string;
  name: string;
  population: number;
  povertyRate: number;
  laborForce: number;
  employmentRate: number;
  lifeExpectancy: number;
  meanYearsSchooling: number;
  grdpPerCapita: number;
  riceFieldArea: number; // Ha
  socialAssistanceBeneficiaries: number; // Keluarga Penerima Manfaat
}

export interface DatasetItem {
  id: string;
  title: string;
  category: string;
  opd: string;
  formats: ("CSV" | "XLSX" | "PDF" | "JSON")[];
  year: number;
  views: number;
  downloads: number;
  updatedAt: string;
  url: string;
}

export interface EcosystemLink {
  title: string;
  description: string;
  category: "Portal Pemkab" | "Integrasi SDI" | "Mitra Statistik";
  url: string;
  badge: string;
}

export const YEARS = [2022, 2023, 2024, 2025, 2026] as const;
export type Year = (typeof YEARS)[number];

export const SECTORS: { id: SectorId; label: string; iconName: string; color: string }[] = [
  { id: "kependudukan", label: "Kependudukan", iconName: "Users", color: "from-blue-500/20 to-teal-500/10" },
  { id: "perekonomian", label: "Perekonomian", iconName: "TrendingUp", color: "from-emerald-500/20 to-teal-500/10" },
  { id: "ketenagakerjaan", label: "Ketenagakerjaan", iconName: "Briefcase", color: "from-amber-500/20 to-orange-500/10" },
  { id: "kesehatan", label: "Kesehatan", iconName: "HeartPulse", color: "from-rose-500/20 to-pink-500/10" },
  { id: "pendidikan", label: "Pendidikan", iconName: "GraduationCap", color: "from-indigo-500/20 to-sky-500/10" },
  { id: "pertanian", label: "Pertanian & Pangan", iconName: "Wheat", color: "from-green-500/20 to-emerald-500/10" },
  { id: "sosial", label: "Sosial & Kesejahteraan", iconName: "ShieldCheck", color: "from-purple-500/20 to-indigo-500/10" },
];

const trend = (values: number[]): TrendPoint[] =>
  YEARS.map((year, i) => ({ year, value: values[i]! }));

export const HEADLINE_INDICATORS: StatisticIndicator[] = [
  {
    id: "ipm",
    name: "Indeks Pembangunan Manusia (IPM)",
    shortName: "IPM",
    sector: "pendidikan",
    value: 73.84,
    unit: "indeks",
    yoyChange: 0.52,
    lowerIsBetter: false,
    trend: trend([71.62, 72.31, 72.96, 73.46, 73.84]),
    metadata: {
      produsen: "Badan Pusat Statistik (BPS) Kabupaten Bangka",
      definisi:
        "Ukuran capaian pembangunan manusia berbasis dimensi umur panjang dan hidup sehat, pengetahuan, serta standar hidup layak.",
      satuan: "Indeks (0–100)",
      metodologi: "Metode agregasi rata-rata geometrik dari tiga indeks dimensi sesuai standar UNDP & BPS.",
      jadwalRilis: "Tahunan, November",
    },
  },
  {
    id: "kemiskinan",
    name: "Persentase Penduduk Miskin",
    shortName: "Kemiskinan",
    sector: "perekonomian",
    value: 4.52,
    unit: "%",
    yoyChange: -0.28,
    lowerIsBetter: true,
    trend: trend([5.36, 5.12, 4.91, 4.8, 4.52]),
    metadata: {
      produsen: "BPS Kabupaten Bangka & Bappeda Kab. Bangka",
      definisi:
        "Persentase penduduk dengan pengeluaran per kapita per bulan di bawah garis kemiskinan (GK).",
      satuan: "Persen (%)",
      metodologi: "Survei Sosial Ekonomi Nasional (Susenas) Maret.",
      jadwalRilis: "Tahunan, Juli",
    },
  },
  {
    id: "pertumbuhan-ekonomi",
    name: "Laju Pertumbuhan Ekonomi",
    shortName: "Pertumbuhan Ekonomi",
    sector: "perekonomian",
    value: 4.21,
    unit: "%",
    yoyChange: 0.35,
    lowerIsBetter: false,
    trend: trend([3.42, 3.68, 3.86, 3.86, 4.21]),
    metadata: {
      produsen: "BPS Kabupaten Bangka",
      definisi:
        "Perubahan Produk Domestik Regional Bruto atas dasar harga konstan dibanding tahun sebelumnya.",
      satuan: "Persen (%)",
      metodologi: "Penghitungan PDRB pendekatan produksi, tahun dasar 2010.",
      jadwalRilis: "Tahunan, Februari",
    },
  },
  {
    id: "tpt",
    name: "Tingkat Pengangguran Terbuka (TPT)",
    shortName: "TPT",
    sector: "ketenagakerjaan",
    value: 4.1,
    unit: "%",
    yoyChange: -0.45,
    lowerIsBetter: true,
    trend: trend([5.28, 4.97, 4.72, 4.55, 4.1]),
    metadata: {
      produsen: "BPS Kabupaten Bangka & Dinakerprindkop Kab. Bangka",
      definisi:
        "Persentase pengangguran terhadap jumlah total angkatan kerja pada periode survei.",
      satuan: "Persen (%)",
      metodologi: "Survei Angkatan Kerja Nasional (Sakernas) Agustus.",
      jadwalRilis: "Tahunan, November",
    },
  },
];

export const SECTOR_INDICATORS: Record<SectorId, StatisticIndicator> = {
  kependudukan: {
    id: "jumlah-penduduk",
    name: "Jumlah Penduduk Terdaftar",
    shortName: "Penduduk",
    sector: "kependudukan",
    value: 336420,
    unit: "jiwa",
    yoyChange: 0.94,
    lowerIsBetter: false,
    trend: trend([325180, 328640, 331420, 333290, 336420]),
    metadata: {
      produsen: "Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) Kab. Bangka",
      definisi: "Jumlah penduduk resmi tercatat dalam sistem administrasi kependudukan (SIAK).",
      satuan: "Jiwa",
      metodologi: "Proyeksi hasil Sensus Penduduk dan konsolidasi data bersih Adminduk Kemendagri.",
      jadwalRilis: "Semesteran / Tahunan",
    },
  },
  perekonomian: {
    id: "pdrb-per-kapita",
    name: "PDRB per Kapita (ADHB)",
    shortName: "PDRB per Kapita",
    sector: "perekonomian",
    value: 58.32,
    unit: "juta Rp",
    yoyChange: 3.12,
    lowerIsBetter: false,
    trend: trend([49.84, 52.16, 54.38, 56.56, 58.32]),
    metadata: {
      produsen: "BPS Kabupaten Bangka & Bappeda Kab. Bangka",
      definisi: "Nilai Produk Domestik Regional Bruto atas dasar harga berlaku dibagi rata-rata penduduk.",
      satuan: "Juta Rupiah per jiwa",
      metodologi: "Penghitungan PDRB 17 lapangan usaha pendekatan produksi.",
      jadwalRilis: "Tahunan, Februari",
    },
  },
  ketenagakerjaan: {
    id: "tpak",
    name: "Tingkat Partisipasi Angkatan Kerja (TPAK)",
    shortName: "TPAK",
    sector: "ketenagakerjaan",
    value: 69.42,
    unit: "%",
    yoyChange: 0.61,
    lowerIsBetter: false,
    trend: trend([66.85, 67.54, 68.23, 68.81, 69.42]),
    metadata: {
      produsen: "BPS Kabupaten Bangka",
      definisi: "Persentase angkatan kerja terhadap penduduk usia produktif (15 tahun ke atas).",
      satuan: "Persen (%)",
      metodologi: "Survei Angkatan Kerja Nasional (Sakernas) Agustus.",
      jadwalRilis: "Tahunan, November",
    },
  },
  kesehatan: {
    id: "usia-harapan-hidup",
    name: "Umur Harapan Hidup saat Lahir (UHH)",
    shortName: "UHH",
    sector: "kesehatan",
    value: 71.24,
    unit: "tahun",
    yoyChange: 0.31,
    lowerIsBetter: false,
    trend: trend([70.12, 70.44, 70.72, 71.02, 71.24]),
    metadata: {
      produsen: "Dinas Kesehatan Kab. Bangka & BPS",
      definisi: "Perkiraan rata-rata lama hidup seorang bayi yang baru lahir dengan pola mortalitas saat ini.",
      satuan: "Tahun",
      metodologi: "Estimasi demografi metode Brass–Trussell dari data Susenas.",
      jadwalRilis: "Tahunan, November",
    },
  },
  pendidikan: {
    id: "rata-lama-sekolah",
    name: "Rata-rata Lama Sekolah (RLS)",
    shortName: "RLS",
    sector: "pendidikan",
    value: 8.42,
    unit: "tahun",
    yoyChange: 0.28,
    lowerIsBetter: false,
    trend: trend([7.86, 8.02, 8.18, 8.29, 8.42]),
    metadata: {
      produsen: "Dinas Pendidikan, Kepemudaan dan Olahraga Kab. Bangka & BPS",
      definisi: "Jumlah tahun formal yang diselesaikan penduduk usia 25 tahun ke atas.",
      satuan: "Tahun",
      metodologi: "Susenas Maret, penghitungan jenjang tertinggi yang ditamatkan.",
      jadwalRilis: "Tahunan, November",
    },
  },
  pertanian: {
    id: "luas-lahan-sawah",
    name: "Luas Lahan Sawah Produktif",
    shortName: "Lahan Sawah",
    sector: "pertanian",
    value: 3840,
    unit: "Ha",
    yoyChange: 2.15,
    lowerIsBetter: false,
    trend: trend([3520, 3610, 3705, 3760, 3840]),
    metadata: {
      produsen: "Dinas Pangan dan Pertanian Kabupaten Bangka",
      definisi: "Luas lahan baku sawah irigasi dan tadah hujan yang aktif ditanami komoditas padi/pangan.",
      satuan: "Hektar (Ha)",
      metodologi: "Pemetaan spasial GIS & verifikasi lapangan penyuluh pertanian lapangan (PPL).",
      jadwalRilis: "Tahunan, Triwulan IV",
    },
  },
  sosial: {
    id: "penerima-bantuan-sosial",
    name: "Keluarga Penerima Manfaat Bansos (KPM)",
    shortName: "Penerima Bansos",
    sector: "sosial",
    value: 12450,
    unit: "KPM",
    yoyChange: -3.85,
    lowerIsBetter: true,
    trend: trend([14820, 14210, 13600, 12950, 12450]),
    metadata: {
      produsen: "Dinas Sosial Kabupaten Bangka",
      definisi: "Keluarga miskin dan rentan penerima program bantuan sosial terpadu (PKH, BPNT, BLT).",
      satuan: "Keluarga Penerima Manfaat (KPM)",
      metodologi: "Data Terpadu Kesejahteraan Sosial (DTKS) termutakhirkan berkala.",
      jadwalRilis: "Semesteran",
    },
  },
};

export const KECAMATAN: KecamatanData[] = [
  {
    id: "sungailiat",
    name: "Sungailiat",
    population: 96420,
    povertyRate: 3.68,
    laborForce: 52140,
    employmentRate: 96.42,
    lifeExpectancy: 72.31,
    meanYearsSchooling: 9.42,
    grdpPerCapita: 72.14,
    riceFieldArea: 420,
    socialAssistanceBeneficiaries: 2450,
  },
  {
    id: "belinyu",
    name: "Belinyu",
    population: 46180,
    povertyRate: 5.12,
    laborForce: 24380,
    employmentRate: 95.28,
    lifeExpectancy: 70.86,
    meanYearsSchooling: 8.14,
    grdpPerCapita: 54.62,
    riceFieldArea: 380,
    socialAssistanceBeneficiaries: 1890,
  },
  {
    id: "pemali",
    name: "Pemali",
    population: 28940,
    povertyRate: 4.36,
    laborForce: 15620,
    employmentRate: 95.94,
    lifeExpectancy: 71.12,
    meanYearsSchooling: 8.36,
    grdpPerCapita: 56.28,
    riceFieldArea: 640,
    socialAssistanceBeneficiaries: 1120,
  },
  {
    id: "merawang",
    name: "Merawang",
    population: 32760,
    povertyRate: 4.21,
    laborForce: 17840,
    employmentRate: 96.05,
    lifeExpectancy: 71.34,
    meanYearsSchooling: 8.52,
    grdpPerCapita: 58.94,
    riceFieldArea: 510,
    socialAssistanceBeneficiaries: 1350,
  },
  {
    id: "mendo-barat",
    name: "Mendo Barat",
    population: 45320,
    povertyRate: 5.48,
    laborForce: 23960,
    employmentRate: 95.12,
    lifeExpectancy: 70.42,
    meanYearsSchooling: 7.86,
    grdpPerCapita: 49.36,
    riceFieldArea: 950,
    socialAssistanceBeneficiaries: 2180,
  },
  {
    id: "riau-silip",
    name: "Riau Silip",
    population: 21480,
    povertyRate: 5.74,
    laborForce: 11240,
    employmentRate: 94.86,
    lifeExpectancy: 70.18,
    meanYearsSchooling: 7.64,
    grdpPerCapita: 46.82,
    riceFieldArea: 480,
    socialAssistanceBeneficiaries: 1240,
  },
  {
    id: "bakam",
    name: "Bakam",
    population: 18260,
    povertyRate: 5.92,
    laborForce: 9640,
    employmentRate: 94.61,
    lifeExpectancy: 69.94,
    meanYearsSchooling: 7.48,
    grdpPerCapita: 45.18,
    riceFieldArea: 290,
    socialAssistanceBeneficiaries: 1180,
  },
  {
    id: "puding-besar",
    name: "Puding Besar",
    population: 17060,
    povertyRate: 6.14,
    laborForce: 8920,
    employmentRate: 94.32,
    lifeExpectancy: 69.72,
    meanYearsSchooling: 7.32,
    grdpPerCapita: 43.74,
    riceFieldArea: 170,
    socialAssistanceBeneficiaries: 1040,
  },
];

export interface SectorTableColumn {
  key: keyof KecamatanData;
  label: string;
  unit: string;
  digits: number;
}

export const SECTOR_TABLE_COLUMN: Record<SectorId, SectorTableColumn> = {
  kependudukan: { key: "population", label: "Jumlah Penduduk", unit: "jiwa", digits: 0 },
  perekonomian: { key: "grdpPerCapita", label: "PDRB per Kapita", unit: "juta Rp", digits: 2 },
  ketenagakerjaan: { key: "laborForce", label: "Angkatan Kerja", unit: "orang", digits: 0 },
  kesehatan: { key: "lifeExpectancy", label: "Umur Harapan Hidup", unit: "tahun", digits: 2 },
  pendidikan: { key: "meanYearsSchooling", label: "Rata-rata Lama Sekolah", unit: "tahun", digits: 2 },
  pertanian: { key: "riceFieldArea", label: "Luas Lahan Sawah", unit: "Ha", digits: 0 },
  sosial: { key: "socialAssistanceBeneficiaries", label: "Penerima Manfaat Bansos", unit: "KPM", digits: 0 },
};

export const FEATURED_DATASETS: DatasetItem[] = [
  {
    id: "ds-1",
    title: "Luas Lahan Sawah Menurut Kecamatan di Kabupaten Bangka (Ha), 2025",
    category: "Pertanian & Ketahanan Pangan",
    opd: "Dinas Pangan dan Pertanian",
    formats: ["CSV", "XLSX", "JSON"],
    year: 2025,
    views: 1420,
    downloads: 388,
    updatedAt: "Februari 2025",
    url: "https://satudata.bangka.go.id/dataset/luas-lahan-sawah-menurut-kecamatan-di-kabupaten-bangka-ha-2025",
  },
  {
    id: "ds-2",
    title: "MASTER META DATA STATISTIK SEKTORAL KABUPATEN BANGKA",
    category: "Statistik & Tata Kelola",
    opd: "Dinas Kominfotik Kab. Bangka",
    formats: ["CSV", "PDF", "JSON"],
    year: 2025,
    views: 3120,
    downloads: 940,
    updatedAt: "Januari 2025",
    url: "https://satudata.bangka.go.id/dataset/master-meta-data-kabupaten-bangka",
  },
  {
    id: "ds-3",
    title: "Persentase Angka Kecukupan Energi di Kabupaten Bangka, 2022–2024",
    category: "Kesehatan & Gizi",
    opd: "Dinas Kesehatan",
    formats: ["CSV", "XLSX"],
    year: 2024,
    views: 980,
    downloads: 215,
    updatedAt: "Desember 2024",
    url: "https://satudata.bangka.go.id/dataset/presentase-angka-kecukupan-energi-di-kabupaten-bangka-2022-2024",
  },
  {
    id: "ds-4",
    title: "Stabilitas Harga dan Pasokan Pangan Strategis Kabupaten Bangka",
    category: "Perdagangan & Pangan",
    opd: "Dinakerprindkop & Ketahanan Pangan",
    formats: ["CSV", "XLSX", "PDF"],
    year: 2025,
    views: 1870,
    downloads: 512,
    updatedAt: "Maret 2025",
    url: "https://satudata.bangka.go.id/dataset/stabilitas-harga-dan-pasokan-pangan-di-kabupaten-bangka-2025",
  },
  {
    id: "ds-5",
    title: "Tersalurkannya Pangan Pokok dan Pangan Lainnya di Kabupaten Bangka",
    category: "Sosial & Pangan",
    opd: "Dinas Sosial & Pangan",
    formats: ["CSV", "XLSX"],
    year: 2025,
    views: 740,
    downloads: 180,
    updatedAt: "Januari 2025",
    url: "https://satudata.bangka.go.id/dataset/tersalurkannya-pangan-pokok-dan-pangan-lainnya-di-kabupaten-bangka-2025",
  },
  {
    id: "ds-6",
    title: "Perkembangan Jumlah Penduduk dan Kepadatan per Wilayah Kecamatan",
    category: "Kependudukan",
    opd: "Disdukcapil Kab. Bangka",
    formats: ["CSV", "XLSX", "JSON"],
    year: 2025,
    views: 2650,
    downloads: 720,
    updatedAt: "Januari 2025",
    url: "https://satudata.bangka.go.id/grup/kependudukan",
  },
];

export const ECOSYSTEM_LINKS: EcosystemLink[] = [
  {
    title: "Sedulang Data Dashboard",
    description: "Visualisasi analitik komprehensif data Kabupaten Bangka berbasis Google Looker Studio.",
    category: "Portal Pemkab",
    url: "https://datastudio.google.com/reporting/a2c2d7c6-b0a7-4405-9e3a-ffb28ec0bdcd",
    badge: "Looker Studio",
  },
  {
    title: "E-Walidata SIPD Kemendagri",
    description: "Sistem Informasi Pembangunan Daerah untuk data perencanaan dan penganggaran.",
    category: "Integrasi SDI",
    url: "https://sipd.go.id/ewalidata",
    badge: "SIPD RI",
  },
  {
    title: "BPS Kabupaten Bangka",
    description: "Badan Pusat Statistik Kabupaten Bangka sebagai pembina statistik sektoral daerah.",
    category: "Mitra Statistik",
    url: "https://bangkakab.bps.go.id",
    badge: "BPS Resmi",
  },
  {
    title: "Portal Satu Data Indonesia",
    description: "Interoperabilitas dan bagi-pakai data nasional melalui portal resmi data.go.id.",
    category: "Integrasi SDI",
    url: "https://data.go.id",
    badge: "Nasional",
  },
  {
    title: "Dinas Kominfotik Bangka",
    description: "Walidata resmi daerah pengelola infrastruktur open data Kabupaten Bangka.",
    category: "Portal Pemkab",
    url: "https://dinkominfotik.bangka.go.id",
    badge: "Walidata",
  },
  {
    title: "Bappeda Kabupaten Bangka",
    description: "Koordinator Forum Satu Data Indonesia tingkat Kabupaten Bangka.",
    category: "Portal Pemkab",
    url: "https://bappeda.bangka.go.id",
    badge: "Koordinator SDI",
  },
];

export const formatNumber = (value: number, digits = 2): string =>
  new Intl.NumberFormat("id-ID", {
    minimumFractionDigits: digits,
    maximumFractionDigits: digits,
  }).format(value);
