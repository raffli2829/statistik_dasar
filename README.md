# Statistik Dasar - Satu Data Kabupaten Bangka (Laravel Edition)

Sub-halaman resmi **Statistik Dasar** ([satudata.bangka.go.id/statistik-dasar](https://satudata.bangka.go.id/statistik-dasar)) Pemerintah Kabupaten Bangka yang dibangun menggunakan **PHP (Laravel 12)**, **Vanilla CSS**, dan **JavaScript (Chart.js)**.

---

## 🏛️ Sumber Rujukan Data Resmi

Data statistik makro, sektoral, dan kewilayahan bersumber resmi dari:
- **Badan Pusat Statistik (BPS) Kabupaten Bangka** ([bangkakab.bps.go.id](https://bangkakab.bps.go.id))
- **Publikasi Resmi**: *Kabupaten Bangka Dalam Angka 2024*, *Berita Resmi Statistik (BRS)*, *Susenas 2024*, dan *Sakernas 2023*.

### Indikator Makro Utama (Realisasi Terbaru)
1. **Indeks Pembangunan Manusia (IPM)**: `74,66 Poin` (2024, BPS Kab. Bangka)
2. **Persentase Penduduk Miskin**: `4,55%` (2024, BPS Provinsi Kep. Babel / Kab. Bangka)
3. **Laju Pertumbuhan Ekonomi**: `4,38%` (2023, BPS Kab. Bangka)
4. **Tingkat Pengangguran Terbuka (TPT)**: `5,03%` (2023, BPS Kab. Bangka - Sakernas)
5. **Jumlah Penduduk Total**: `342.058 Jiwa` (2024, BPS Kab. Bangka & Disdukcapil)

---

## 🚀 Fitur Utama

- **Panel Admin Terproteksi (`/admin`)**: Manajemen data indikator makro, data 8 kecamatan, dan tren tahunan langsung dari antarmuka web yang modern.
- **Sistem Data Dinamis Berbasis Database**: Seluruh data indikator tersimpan di database (SQLite / MySQL) dan langsung terhubung dinamis ke halaman publik serta API internal.
- **Import Massal Berkas CSV**: Fitur unggah file CSV untuk pembaruan cepat ratusan titik data indikator dan kecamatan, dilengkapi tombol unduh format template.
- **Sinkronisasi Langsung CKAN API**: Terintegrasi dinamis ke API Satu Data Pemkab Bangka (`manajemen-satudata.bangka.go.id`) untuk memuat berkas unduhan publik secara *live*.
- **Sub-Modul Bersih Tanpa Duplikasi Layout**: Tanpa header/footer portal berlebih, siap diintegrasikan sebagai sub-halaman di `satudata.bangka.go.id`.
- **Tema Warna Merah Resmi**: Menggunakan palet merah brand Satu Data Bangka (`#DC2626` / `#E11D48`).
- **4 Headline KPI Cards**: Dilengkapi mini sparkline canvas dan indikator *YoY trend change*.
- **Ruang Kerja Statistik Sektoral**: 7 urusan (Kependudukan, Perekonomian, Ketenagakerjaan, Kesehatan, Pendidikan, Pertanian & Pangan, Sosial) dengan grafik Chart.js 3-mode (**Area**, **Garis**, **Batang**).
- **Matriks 8 Kecamatan**: Data spasial Sungailiat, Belinyu, Mendo Barat, Pemali, Merawang, Riau Silip, Puding Besar, dan Bakam dengan live search, sorting kolom, bar proporsi, dan ekspor **CSV** & **JSON**.
- **Drawer Metadata SDI**: Definisi operasional indikator, produsen data, satuan ukur, jadwal rilis, metodologi, dan data historis 5 tahun.
- **Mode Gelap / Terang**: Dukungan dark mode dengan persistensi tema.

---

## 🔐 Kredensial Akses Panel Admin

* **URL Login Admin**: `http://127.0.0.1:8000/admin/login`
* **Email**: `admin@bangka.go.id`
* **Kata Sandi**: `adminbangka2025`

---

## 🛠️ Stack Teknologi

- **Backend**: Laravel 12 (PHP 8.5)
- **Frontend**: Blade Templates + Vanilla CSS + JavaScript
- **Charting**: Chart.js 4.4
- **Icons**: Lucide Icons
- **Typography**: Google Fonts (*Plus Jakarta Sans* & *JetBrains Mono*)

---

## 💻 Cara Menjalankan

1. Clone repository:
   ```bash
   git clone https://github.com/raffli2829/statistik_dasar.git
   cd statistik_dasar
   ```

2. Install dependensi Composer:
   ```bash
   composer install
   ```

3. Salin file environment & generate key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

5. Buka di browser:
   👉 **http://127.0.0.1:8000/**
