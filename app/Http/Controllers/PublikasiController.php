<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PublikasiController extends Controller
{
    /**
     * Alihkan halaman utama publikasi langsung ke halaman Berita.
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('publikasi.berita');
    }

    /**
     * Halaman daftar berita terkini seputar data statistik.
     */
    public function berita(): View
    {
        $items = [
            [
                'id' => 'kemiskinan-semester-1-2024',
                'tanggal' => '28 Agustus 2024',
                'judul' => 'Rilis Data Kemiskinan Kabupaten Bangka Semester I 2024: Tren Menurun Sebesar 0,32 Persen Poin',
                'ringkasan' => 'BPS Kabupaten Bangka secara resmi merilis profil kemiskinan terbaru. Intervensi program perlindungan sosial daerah dan stabilitas harga pangan pokok berkontribusi positif menekan angka kemiskinan hingga 4,21 persen.',
                'isi' => "Badan Pusat Statistik (BPS) Kabupaten Bangka resmi merilis data profil kemiskinan per Semester I 2024. Persentase penduduk miskin di Kabupaten Bangka tercatat sebesar 4,21 persen, mengalami penurunan sebesar 0,32 persen poin dibandingkan periode yang sama tahun sebelumnya (4,53 persen).\n\nPenurunan ini didorong oleh penguatan daya beli masyarakat perdesaan, stabilitas harga komoditas pangan strategis seperti beras dan ikan, serta akselerasi program bantuan sosial tunai dan bantuan pangan dari Pemerintah Daerah Kabupaten Bangka.\n\nGaris Kemiskinan (GK) pada Semester I 2024 tercatat sebesar Rp 612.450 per kapita/bulan, didominasi oleh pengeluaran makanan sebesar 73,4 persen. BPS menggarisbawahi pentingnya menjaga stabilitas harga sembako dan memperluas kesempatan kerja sektor informal untuk mempertahankan tren positif ini.",
                'kategori' => 'Rilis Data',
                'waktu_baca' => '3 Menit Baca',
                'sumber' => 'BPS Kabupaten Bangka & Diskominfo',
                'is_headline' => true,
                'tags' => ['Kemiskinan', 'Rilis Resmi', 'Bansos', 'Ekonomi Rakyat'],
                'ikon' => 'trending-down',
            ],
            [
                'id' => 'sosialisasi-satu-data-indonesia',
                'tanggal' => '15 Juli 2024',
                'judul' => 'Sosialisasi Pemutakhiran Data Satu Data Indonesia (SDI) Tingkat Kabupaten Bangka',
                'ringkasan' => 'Pemerintah Kabupaten Bangka melalui Dinas Komunikasi, Informatika dan Statistik menghelat bimtek standardisasi metadata statistik sektoral bersama 28 Organisasi Perangkat Daerah.',
                'isi' => "Dinas Kominfotik Kabupaten Bangka menyelenggarakan bimbingan teknis implementasi Perpres No. 39 Tahun 2019 tentang Satu Data Indonesia. Kegiatan ini menghadirkan BPS Kabupaten Bangka sebagai Pembina Data Statistik dan Bappeda Litbang sebagai Koordinator Forum Satu Data.\n\nDalam forum ini ditegaskan komitmen seluruh Organisasi Perangkat Daerah (OPD) selaku Produsen Data untuk menyusun Standar Data, Metadata Statistik Sektoral (MS-Kegiatan, MS-Variabel, MS-Indikator), serta interoperabilitas data melalui portal portal satudata.bangka.go.id.\n\nDengan adanya standardisasi ini, seluruh data sektoral yang dipublikasikan dijamin memenuhi kaidah validitas, akurasi, dan ketertelusuran yang dapat diandalkan oleh perencana kebijakan maupun masyarakat.",
                'kategori' => 'Kegiatan',
                'waktu_baca' => '4 Menit Baca',
                'sumber' => 'Dinkominfotik Kab. Bangka',
                'is_headline' => false,
                'tags' => ['Satu Data', 'Metadata', 'Bimtek OPD', 'SDI'],
                'ikon' => 'users-round',
            ],
            [
                'id' => 'bangka-dalam-angka-2024',
                'tanggal' => '2 Juni 2024',
                'judul' => 'Publikasi Tahunan "Kabupaten Bangka Dalam Angka 2024" Resmi Diluncurkan',
                'ringkasan' => 'Buku kompendium data paling komprehensif memuat 450+ tabel indikator strategis sosial, demografi, dan ekonomi di 8 kecamatan kini tersedia lengkap dalam format digital interaktif.',
                'isi' => "Buku publikasi induk tahunan 'Kabupaten Bangka Dalam Angka 2024' telah terbit dan dapat diunduh bebas oleh publik. Publikasi ini menyajikan rangkuman data agregat tahun 2023 hingga kuartal pertama 2024.\n\nCakupan publikasi meliputi geografi dan iklim, kependudukan dan ketenagakerjaan, sosial dan kesejahteraan rakyat, pertanian, pertambangan, industri pengolahan, perdagangan, serta keuangan daerah di 8 kecamatan: Sungailiat, Belinyu, Merawang, Mendo Barat, Pemali, Bakam, Riau Silip, dan Puding Besar.\n\nKepala BPS Kabupaten Bangka menyampaikan apresiasi kepada seluruh instansi dinas yang telah berkolaborasi aktif dalam penyusunan publikasi komprehensif ini.",
                'kategori' => 'Publikasi',
                'waktu_baca' => '5 Menit Baca',
                'sumber' => 'BPS Kabupaten Bangka',
                'is_headline' => false,
                'tags' => ['Buku Publikasi', 'Bangka Dalam Angka', 'Tabel Data'],
                'ikon' => 'book-open',
            ],
            [
                'id' => 'pertumbuhan-ekonomi-triwulan-ii-2024',
                'tanggal' => '10 Agustus 2024',
                'judul' => 'Pertumbuhan Ekonomi Triwulan II-2024 Ditopang Sektor Pertanian dan Industri Kelapa Sawit',
                'ringkasan' => 'PDRB Kabupaten Bangka tumbuh 4,12 persen (y-on-y). Sektor pertanian, perkebunan kelapa sawit, dan hilirisasi CPO menjadi motor utama penggerak pertumbuhan ekonomi daerah.',
                'isi' => "Pertumbuhan ekonomi Kabupaten Bangka pada triwulan II-2024 menunjukkan ketahanan positif di tengah fluktuasi harga komoditas timah global. Sektor Pertanian, Kehutanan, dan Perikanan menyumbang kontribusi terbesar terhadap pembentukan PDRB sebesar 21,8 persen.\n\nKenaikan produksi kelapa sawit rakyat dan peningkatan kapasitas pabrik pengolahan CPO di wilayah Belinyu dan Mendo Barat memberikan efek pengganda (multiplier effect) yang nyata terhadap penyerapan tenaga kerja lokal dan pendapatan rumah tangga perdesaan.",
                'kategori' => 'Rilis Data',
                'waktu_baca' => '3 Menit Baca',
                'sumber' => 'Tim Neraca Wilayah BPS',
                'is_headline' => false,
                'tags' => ['PDRB', 'Pertumbuhan Ekonomi', 'Pertanian', 'Sawit'],
                'ikon' => 'bar-chart-2',
            ],
            [
                'id' => 'survei-angkatan-kerja-sakernas-2024',
                'tanggal' => '18 Juli 2024',
                'judul' => 'Pelaksanaan Sakernas 2024: Menakar Partisipasi Angkatan Kerja dan Kualitas Lapangan Usaha',
                'ringkasan' => 'Petugas statistik BPS turun serentak mendata sampel rumah tangga di 8 kecamatan guna mengukur Tingkat Pengangguran Terbuka (TPT) dan pergeseran struktur ketenagakerjaan.',
                'isi' => "Survei Angkatan Kerja Nasional (Sakernas) periode Agustus 2024 dilaksanakan serentak oleh BPS Kabupaten Bangka dengan menerapkan metode Computer-Assisted Personal Interviewing (CAPI) berbasis gawai pintar.\n\nSurvei ini bertujuan untuk menangkap dinamika ketenagakerjaan terkini, mencakup Tingkat Partisipasi Angkatan Kerja (TPAK), pengangguran terdidik, serta pertumbuhan pekerja di sektor informal dan ekonomi digital.",
                'kategori' => 'Kegiatan',
                'waktu_baca' => '3 Menit Baca',
                'sumber' => 'BPS Kabupaten Bangka',
                'is_headline' => false,
                'tags' => ['Ketenagakerjaan', 'Sakernas', 'TPT', 'Survei'],
                'ikon' => 'briefcase',
            ],
            [
                'id' => 'pemantauan-inflasi-stabilitas-pasar',
                'tanggal' => '5 Mei 2024',
                'judul' => 'Rapat TPID Kabupaten Bangka: Sinergi Menjaga Keterjangkauan Harga Pasca Hari Raya',
                'ringkasan' => 'Tim Pengendalian Inflasi Daerah (TPID) Bangka memperkuat monitoring pasokan cabai, beras, dan daging ayam antarpulau guna mencegah lonjakan indeks harga konsumen.',
                'isi' => "Pemerintah Daerah bersama BPS dan instansi vertikal menggelar evaluasi mingguan Tim Pengendalian Inflasi Daerah (TPID). Berdasarkan pantauan Sistem Pemantauan Pasar dan Kebutuhan Pokok (SP2KP), indeks perkembangan harga (IPH) di Kabupaten Bangka berada dalam batas aman terkendali di angka 2,1 persen.\n\nLangkah konkret yang terus dijalankan meliputi operasi pasar murah di kecamatan prioritas, subsidi ongkos angkut komoditas holtikultura, dan penguatan pasokan melalui kerjasama antardaerah (KAD).",
                'kategori' => 'Kegiatan',
                'waktu_baca' => '4 Menit Baca',
                'sumber' => 'TPID Kabupaten Bangka',
                'is_headline' => false,
                'tags' => ['Inflasi', 'TPID', 'Pangan', 'Pasar Murah'],
                'ikon' => 'shopping-cart',
            ],
        ];

        $kategoriList = ['Semua', 'Rilis Data', 'Kegiatan', 'Publikasi'];

        return view('publikasi.berita', [
            'items' => $items,
            'kategoriList' => $kategoriList,
        ]);
    }

    /**
     * Halaman daftar artikel analisis berbasis data.
     */
    public function artikel(): View
    {
        $items = [
            [
                'id' => 'transformasi-struktur-ekonomi-bangka',
                'tanggal' => '20 Agustus 2024',
                'judul' => 'Transformasi Struktur Ekonomi Kabupaten Bangka: Pergeseran dari Pertambangan ke Perkebunan & Agroindustri',
                'ringkasan' => 'Kajian mendalam mengenai evolusi lanskap ekonomi Kabupaten Bangka selama satu dekade terakhir, mengupas tantangan pasca-tambang dan peluang diversifikasi komoditas perkebunan.',
                'penulis' => 'Dr. Hendra Wijaya, M.Si (Tim Analisis Data SDI Bangka)',
                'kategori' => 'Ekonomi',
                'waktu_baca' => '6 Menit Baca',
                'views' => 1420,
                'poin_kunci' => [
                    'Pangsa sektor pertambangan turun dari 24,1% (2014) menjadi 13,2% (2024).',
                    'Sektor perkebunan kelapa sawit tumbuh rata-rata 6,4% per tahun dan menyerap 34% tenaga kerja perdesaan.',
                    'Diversifikasi ke sektor pariwisata bahari dan industri olahan menjadi kunci keberlanjutan PDRB.',
                ],
                'isi' => "Kabupaten Bangka berada pada fase penting transisi ekonomi pasca-kejayaan era penambangan timah darat. Selama lebih dari satu abad, pertambangan menjadi denyut utama penyerapan tenaga kerja dan pendapatan asli daerah.\n\nNamun, data PDRB sepuluh tahun terakhir (2014–2024) mencatat penurunan kontribusi sektor ekstraktif secara struktural. Sebaliknya, sektor pertanian dan perkebunan—khususnya kelapa sawit dan lada putih—menunjukkan resiliensi luar biasa. Nilai Tukar Petani (NTP) di wilayah sentra seperti Mendo Barat dan Bakam konsisten berada di atas angka 110, mencerminkan perbaikan kesejahteraan petani.\n\nPemerintah Daerah perlu memperkuat hilirisasi produk turunan kelapa sawit dan mengembangkan klaster Usaha Mikro, Kecil, dan Menengah (UMKM) berbasis kelautan guna menampung angkatan kerja muda berpendidikan menengah ke atas.",
                'rekomendasi' => 'Peningkatan investasi pabrik pengolahan biomassa limbah sawit, perbaikan infrastruktur jalan sentra produksi pertanian, dan digitalisasi rantai pasok pemasaran komoditas unggulan lokal.',
            ],
            [
                'id' => 'potret-disparitas-ipm-kecamatan',
                'tanggal' => '5 Juli 2024',
                'judul' => 'Potret Indeks Pembangunan Manusia (IPM) Antar-Kecamatan: Membedah Tantangan Pemerataan Kualitas Hidup',
                'ringkasan' => 'Analisis komparatif komponen IPM di 8 kecamatan Kabupaten Bangka mengungkapkan kesenjangan antara Sungailiat sebagai pusat perkotaan dengan kecamatan pedalaman seperti Bakam dan Riau Silip.',
                'penulis' => 'Tim Neraca Sosial BPS Kabupaten Bangka',
                'kategori' => 'Sosial',
                'waktu_baca' => '5 Menit Baca',
                'views' => 980,
                'poin_kunci' => [
                    'IPM Kabupaten Bangka mencapai 73,42 (kategori Tinggi), namun disparitas antar-kecamatan mencapai rentang 6,8 poin.',
                    'Kecamatan Sungailiat mencatat IPM tertinggi (78,10), sedangkan Bakam berada pada 71,25.',
                    'Rata-rata Lama Sekolah (RLS) menjadi variabel penentu utama yang memerlukan intervensi beasiswa tuntas.',
                ],
                'isi' => "Capaian Indeks Pembangunan Manusia (IPM) Kabupaten Bangka menunjukkan kemajuan konsisten dalam kurun waktu 5 tahun terakhir. Kendati demikian, angka agregat kabupaten kerap menyamarkan variasi capaian di tingkat wilayah kecamatan.\n\nKecamatan Sungailiat dan Pemali memiliki akses fasilitas pendidikan lanjutan dan sarana kesehatan rujukan yang sangat memadai, sehingga mendongkrak Angka Harapan Hidup (AHH) dan Harapan Lama Sekolah (HLS). Di sisi lain, kecamatan dengan karakteristik perdesaan agraris seperti Bakam menghadapi kendala angka putus sekolah pada jenjang SMA/SMK sederajat akibat tarikan masuk langsung ke lapangan kerja informal perkebunan.\n\nTemuan ini mengindikasikan bahwa alokasi anggaran pembangunan sosial tidak dapat disamaratakan melainkan harus berbasis kebutuhan asimetris wilayah.",
                'rekomendasi' => 'Penambahan unit sekolah menengah baru atau moda transportasi bus sekolah terpadu di kecamatan pedalaman, serta perluasan program kejar paket C berbasis keahlian vokasional.',
            ],
            [
                'id' => 'dinamika-demografi-dan-bonus-demografi',
                'tanggal' => '18 Juni 2024',
                'judul' => 'Dinamika Kependudukan dan Peluang Emas Pemanfaatan Bonus Demografi Kabupaten Bangka',
                'ringkasan' => 'Dengan 68,4 persen penduduk berada pada usia produktif (15–64 tahun), Kabupaten Bangka memasuki jendela peluang bonus demografi yang menuntut penciptaan lapangan kerja bermutu.',
                'penulis' => 'Dra. Ratna Sari (Analis Kependudukan Bappeda Bangka)',
                'kategori' => 'Kependudukan',
                'waktu_baca' => '5 Menit Baca',
                'views' => 840,
                'poin_kunci' => [
                    'Rasio ketergantungan (dependency ratio) mencapai titik terendah sebesar 46,2 per 100 penduduk usia produktif.',
                    'Konsentrasi penduduk usia muda tertinggi berpusat di Sungailiat dan Belinyu.',
                    'Tantangan utama adalah peningkatan keterampilan vokasi teknologi informasi dan kewirausahaan mandiri.',
                ],
                'isi' => "Transisi demografi Kabupaten Bangka menghasilkan struktur piramida penduduk bertipe ekspansif menuju stasioner, dengan proporsi usia produktif mencapai puncak tertinggi dalam sejarah pencatatan demografi daerah.\n\nKondisi ini merupakan berkah pembangunan yang hanya datang satu kali dalam beberapa generasi. Namun demikian, bonus demografi dapat berbalik menjadi beban sosial apabila tidak diimbangi dengan daya serap industri dan ekosistem wirausaha yang dinamis.\n\nSinergi antara perguruan tinggi di Bangka dengan balai latihan kerja (BLK) harus diarahkan pada pemenuhan kompetensi masa depan seperti logistik digital, mekanisasi pertanian modern, dan pariwisata ramah lingkungan.",
                'rekomendasi' => 'Revitalisasi kurikulum BLK Kabupaten Bangka, insentif perizinan bagi start-up pemuda lokal, dan fasilitasi akses permodalan tanpa agunan bagi pelaku wirausaha muda.',
            ],
            [
                'id' => 'pola-inflasi-dan-ketahanan-pangan-lokal',
                'tanggal' => '12 Mei 2024',
                'judul' => 'Pola Musiman Inflasi Daerah: Strategi Penguatan Rantai Pasok Pangan Berkelanjutan',
                'ringkasan' => 'Ketergantungan terhadap pasokan pangan dari luar Pulau Bangka menjadikan inflasi lokal sensitif terhadap cuaca laut dan tarif angkutan penyeberangan kapal roro.',
                'penulis' => 'Tim Pengkaji Ekonomi SDI Bangka',
                'kategori' => 'Ekonomi',
                'waktu_baca' => '4 Menit Baca',
                'views' => 715,
                'poin_kunci' => [
                    'Komoditas cabai merah, bawang merah, dan daging ayam ras berkontribusi hingga 58% terhadap volatilitas inflasi tahunan.',
                    'Gelombang tinggi di Selat Bangka pada bulan Desember–Februari secara historis memicu lonjakan harga pangan.',
                    'Pengembangan sentra cabai lokal di Mendo Barat terbukti mampu meredam volatilitas harga hingga 1,8%.',
                ],
                'isi' => "Sebagai daerah kepulauan, Kabupaten Bangka menghadapi kerentanan struktural pada aspek distribusi komoditas bahan makanan segar. Jalur logistik antarpulau dari Sumatera Selatan dan Jawa menjadi urat nadi suplai harian masyarakat.\n\nKajian ekonometrika membuktikan adanya korelasi kuat antara tinggi gelombang laut di jalur penyeberangan Selat Bangka dengan lonjakan harga eceran komoditas hortikultura di pasar tradisional Sungailiat dan Belinyu.\n\nSolusi jangka panjang terletak pada penguatan kapasitas produksi subsisten mandiri di dalam daerah melalui program pemanfaatan lahan pekarangan dan intensifikasi lahan kering di sentra-sentra pertanian kecamatan.",
                'rekomendasi' => 'Pengembangan fasilitas penyimpanan berpendingin (cold storage) terpusat, penguatan BUMD pangan, dan pendampingan kelompok tani holtikultura dalam menerapkan teknologi irigasi tetes.',
            ],
            [
                'id' => 'keberlanjutan-lahan-pertanian-pangan',
                'tanggal' => '22 April 2024',
                'judul' => 'Urgensi Perlindungan Lahan Pertanian Pangan Berkelanjutan (LP2B) Menghadapi Tekanan Alih Fungsi',
                'ringkasan' => 'Kajian spasial mengenai risiko penyusutan sawah irigasi teknis akibat ekspansi perkebunan dan permukiman di koridor Merawang-Sungailiat.',
                'penulis' => 'Ir. M. Ridwan (Ahli Tata Ruang Wilayah)',
                'kategori' => 'Pertanian',
                'waktu_baca' => '5 Menit Baca',
                'views' => 620,
                'poin_kunci' => [
                    'Luas baku sawah beririgasi teknis di Kabupaten Bangka saat ini tercatat seluas 2.840 hektar.',
                    'Tingkat alih fungsi lahan sawah ke perkebunan sawit mencapai rata-rata 45 hektar per tahun.',
                    'Pemberian insentif PBB-P2 nol persen bagi petani pemilik lahan LP2B mendesak untuk disahkan.',
                ],
                'isi' => "Ketahanan pangan suatu daerah berpangkal pada ketersediaan lahan budidaya tanaman pangan yang terlindungi secara hukum. Di Kabupaten Bangka, tantangan mempertahankan areal persawahan menghadapi persaingan nilai ekonomi dengan komoditas kelapa sawit yang menjanjikan keuntungan tunai lebih cepat.\n\nIntegrasi peta LP2B ke dalam Rencana Tata Ruang Wilayah (RTRW) dan penyusunan Rencana Detail Tata Ruang (RDTR) digital berbasis geospasial menjadi benteng pertahanan terakhir untuk menjaga lumbung pangan lokal di Riau Silip dan Pemali.",
                'rekomendasi' => 'Penerbitan Peraturan Bupati tentang insentif bagi petani penggarap sawah LP2B serta jaminan sarana produksi pupuk bersubsidi tepat sasaran.',
            ],
            [
                'id' => 'efektivitas-bantuan-sosial-kemiskinan-ekstrem',
                'tanggal' => '10 Maret 2024',
                'judul' => 'Evaluasi Konvergensi Program Penanggulangan Kemiskinan Ekstrem Berbasis Data P3KE',
                'ringkasan' => 'Mengevaluasi efektivitas keterpaduan intervensi perlindungan sosial, peningkatan pendapatan, dan pengurangan kantong kemiskinan di 15 desa prioritas.',
                'penulis' => 'Dinas Sosial & Tim Koordinasi Penanggulangan Kemiskinan',
                'kategori' => 'Sosial',
                'waktu_baca' => '6 Menit Baca',
                'views' => 890,
                'poin_kunci' => [
                    'Tingkat kemiskinan ekstrem di Kabupaten Bangka berhasil ditekan hingga mendekati 0,18 persen.',
                    'Validasi data by name by address (BNBA) menggunakan data P3KE memangkas exclusion error hingga 40%.',
                    'Kombinasi bedah rumah layak huni dengan bantuan modal usaha produktif terbukti paling efektif memutus siklus kemiskinan.',
                ],
                'isi' => "Pendekatan konvergensi penanggulangan kemiskinan ekstrem di Kabupaten Bangka membuktikan bahwa kolaborasi lintas instansi merupakan prasyarat mutlak keberhasilan. Melalui penyelarasan Data Terpadu Kesejahteraan Sosial (DTKS) dan Pensasaran Percepatan Penghapusan Kemiskinan Ekstrem (P3KE), intervensi dapat disalurkan secara presisi.\n\nProgram terpadu yang memadukan bantuan pangan non-tunai, sambungan air bersih PDAM gratis, dan pelatihan keterampilan kerja bagi keluarga rentan telah mengangkat 420 kepala keluarga keluar dari jerat kemiskinan ekstrem.",
                'rekomendasi' => 'Pemutakhiran berkala data P3KE setiap kuartal oleh perangkat desa dan pendamping PKH untuk mencegah terjadinya pergeseran keluarga rentan kembali ke kategori miskin.',
            ],
        ];

        $kategoriList = ['Semua', 'Ekonomi', 'Sosial', 'Kependudukan', 'Pertanian'];

        return view('publikasi.artikel', [
            'items' => $items,
            'kategoriList' => $kategoriList,
        ]);
    }

    /**
     * Halaman galeri infografis visualisasi data.
     */
    public function infografis(): View
    {
        $items = [
            [
                'id' => 'info-kependudukan-2024',
                'judul' => 'Profil Kependudukan & Demografi Kabupaten Bangka 2024',
                'kategori' => 'Kependudukan',
                'deskripsi' => 'Visualisasi lengkap sebaran jumlah penduduk, rasio jenis kelamin, tingkat kepadatan per kecamatan, dan struktur piramida umur generasi produktif.',
                'warna' => '#2563EB',
                'ikon' => 'users',
                'angka_utama' => '324.512',
                'satuan_utama' => 'Jiwa Penduduk',
                'sub_metrik' => 'Kepadatan: 109 Jiwa/km²',
                'data_highlights' => [
                    ['label' => 'Laki-laki', 'value' => '165.810 Jiwa (51,1%)', 'icon' => 'user-check'],
                    ['label' => 'Perempuan', 'value' => '158.702 Jiwa (48,9%)', 'icon' => 'user'],
                    ['label' => 'Kecamatan Terpadat', 'value' => 'Sungailiat (92.400 Jiwa)', 'icon' => 'map-pin'],
                    ['label' => 'Usia Produktif (15-64)', 'value' => '68,4 Persen', 'icon' => 'sparkles'],
                ],
                'tanggal' => 'Juli 2024',
                'sumber' => 'BPS & Dinas Kependudukan dan Pencatatan Sipil Kab. Bangka',
            ],
            [
                'id' => 'info-kemiskinan-2024',
                'judul' => 'Peta Indikator Kemiskinan Kabupaten Bangka 2020–2024',
                'kategori' => 'Kemiskinan',
                'deskripsi' => 'Perkembangan tren penurunan angka kemiskinan, nilai Garis Kemiskinan (GK), serta perbandingan Indeks Kedalaman (P1) dan Keparahan Kemiskinan (P2).',
                'warna' => '#F59E0B',
                'ikon' => 'trending-down',
                'angka_utama' => '4,21%',
                'satuan_utama' => 'Tingkat Kemiskinan',
                'sub_metrik' => 'Turun 0,32% Poin (YoY)',
                'data_highlights' => [
                    ['label' => 'Jumlah Penduduk Miskin', 'value' => '13.660 Jiwa', 'icon' => 'user-minus'],
                    ['label' => 'Garis Kemiskinan (GK)', 'value' => 'Rp 612.450 /kapita/bln', 'icon' => 'wallet'],
                    ['label' => 'Indeks Kedalaman (P1)', 'value' => '0,48 (Terkategori Rendah)', 'icon' => 'arrow-down-right'],
                    ['label' => 'Pangsa Makanan GK', 'value' => '73,4 Persen', 'icon' => 'utensils'],
                ],
                'tanggal' => 'Agustus 2024',
                'sumber' => 'BPS Kabupaten Bangka',
            ],
            [
                'id' => 'info-ipm-2024',
                'judul' => 'Capaian Indeks Pembangunan Manusia (IPM) & Dimensinya',
                'kategori' => 'Sosial',
                'deskripsi' => 'Grafik perkembangan skor IPM Kabupaten Bangka serta capaian ketiga pilar pembentuknya: Umur Panjang & Hidup Sehat, Pengetahuan, dan Standar Hidup Layak.',
                'warna' => '#10B981',
                'ikon' => 'award',
                'angka_utama' => '73,42',
                'satuan_utama' => 'Skor IPM (Tinggi)',
                'sub_metrik' => 'Peringkat 3 di Provinsi Babel',
                'data_highlights' => [
                    ['label' => 'Angka Harapan Hidup (AHH)', 'value' => '73,18 Tahun', 'icon' => 'heart-pulse'],
                    ['label' => 'Harapan Lama Sekolah (HLS)', 'value' => '13,05 Tahun', 'icon' => 'graduation-cap'],
                    ['label' => 'Rata-rata Lama Sekolah (RLS)', 'value' => '8,52 Tahun', 'icon' => 'book-marked'],
                    ['label' => 'Pengeluaran Riil Disesuaikan', 'value' => 'Rp 11.480.000 /tahun', 'icon' => 'banknote'],
                ],
                'tanggal' => 'Juni 2024',
                'sumber' => 'BPS Kabupaten Bangka',
            ],
            [
                'id' => 'info-pdrb-ekonomi-2024',
                'judul' => 'Struktur PDRB & Pertumbuhan Ekonomi Lapangan Usaha',
                'kategori' => 'Ekonomi',
                'deskripsi' => 'Komposisi Produk Domestik Regional Bruto (PDRB) Kabupaten Bangka atas dasar harga berlaku (ADHB) dan sektor penyumbang kontribusi terbesar.',
                'warna' => '#06B6D4',
                'ikon' => 'pie-chart',
                'angka_utama' => 'Rp 16,84 T',
                'satuan_utama' => 'PDRB ADHB 2023/2024',
                'sub_metrik' => 'Pertumbuhan Ekonomi: 4,12%',
                'data_highlights' => [
                    ['label' => 'Pertanian & Perkebunan', 'value' => 'Pangsa 21,8% (Dominan)', 'icon' => 'sprout'],
                    ['label' => 'Industri Pengolahan', 'value' => 'Pangsa 18,4%', 'icon' => 'factory'],
                    ['label' => 'Perdagangan Besar & Eceran', 'value' => 'Pangsa 14,2%', 'icon' => 'shopping-bag'],
                    ['label' => 'Pertambangan & Penggalian', 'value' => 'Pangsa 13,2%', 'icon' => 'pickaxe'],
                ],
                'tanggal' => 'Mei 2024',
                'sumber' => 'Neraca Wilayah BPS Kabupaten Bangka',
            ],
            [
                'id' => 'info-ketenagakerjaan-2024',
                'judul' => 'Potret Ketenagakerjaan & Angkatan Kerja Daerah',
                'kategori' => 'Sosial',
                'deskripsi' => 'Tingkat Pengangguran Terbuka (TPT), Tingkat Partisipasi Angkatan Kerja (TPAK), dan profil pekerja formal vs informal di Kabupaten Bangka.',
                'warna' => '#8B5CF6',
                'ikon' => 'briefcase',
                'angka_utama' => '4,38%',
                'satuan_utama' => 'Tingkat Pengangguran (TPT)',
                'sub_metrik' => 'TPAK: 67,25%',
                'data_highlights' => [
                    ['label' => 'Total Angkatan Kerja', 'value' => '156.420 Jiwa', 'icon' => 'users-round'],
                    ['label' => 'Penduduk Bekerja', 'value' => '149.570 Jiwa', 'icon' => 'check-circle-2'],
                    ['label' => 'Pekerja Sektor Informal', 'value' => '54,2 Persen', 'icon' => 'store'],
                    ['label' => 'Pekerja Sektor Formal', 'value' => '45,8 Persen', 'icon' => 'building-2'],
                ],
                'tanggal' => 'Agustus 2024',
                'sumber' => 'Hasil Sakernas BPS Kab. Bangka',
            ],
            [
                'id' => 'info-pertanian-kelapa-sawit',
                'judul' => 'Statistik Perkebunan Rakyat: Kelapa Sawit & Lada',
                'kategori' => 'Ekonomi',
                'deskripsi' => 'Luas areal tanam, estimasi produksi Tandan Buah Segar (TBS) sawit, dan pemulihan komoditas lada putih (Muntok White Pepper) di 8 kecamatan.',
                'warna' => '#059669',
                'ikon' => 'sprout',
                'angka_utama' => '48.250 Ha',
                'satuan_utama' => 'Luas Areal Sawit Rakyat',
                'sub_metrik' => 'Produksi: 385.400 Ton/Tahun',
                'data_highlights' => [
                    ['label' => 'Pabrik Kelapa Sawit (PKS)', 'value' => '7 Unit Operasional', 'icon' => 'factory'],
                    ['label' => 'Luas Perkebunan Lada', 'value' => '6.420 Ha', 'icon' => 'leaf'],
                    ['label' => 'Nilai Tukar Petani (NTP)', 'value' => '114,8 (Surplus Petani)', 'icon' => 'trending-up'],
                    ['label' => 'Kecamatan Terluas Sawit', 'value' => 'Mendo Barat & Belinyu', 'icon' => 'map-pin'],
                ],
                'tanggal' => 'Juli 2024',
                'sumber' => 'Dinas Pertanian & Ketahanan Pangan Kab. Bangka',
            ],
        ];

        $kategoriList = ['Semua', 'Kependudukan', 'Kemiskinan', 'Sosial', 'Ekonomi'];

        return view('publikasi.infografis', [
            'items' => $items,
            'kategoriList' => $kategoriList,
        ]);
    }

    /**
     * Halaman publikasi statistik sektoral dari OPD.
     */
    public function statistikSektoralOpd(): View
    {
        $items = [
            [
                'id' => 'dinas-kesehatan',
                'nama' => 'Dinas Kesehatan Kabupaten Bangka',
                'akronim' => 'Dinkes',
                'klaster' => 'Kesehatan',
                'deskripsi' => 'Produsen data sektoral fasilitas pelayanan kesehatan, tenaga medis, cakupan imunisasi, prevalensi stunting balita, dan program SPM bidang kesehatan.',
                'alamat' => 'Jl. Jenderal Sudirman No. 12, Sungailiat',
                'jumlah_dataset' => 12,
                'terakhir_update' => 'Agustus 2024',
                'ikon' => 'heart-pulse',
                'warna' => '#EF4444',
                'datasets' => [
                    [
                        'judul' => 'Jumlah Fasilitas Kesehatan (RS, Puskesmas, Klinik) per Kecamatan',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX', 'PDF'],
                        'frekuensi' => 'Tahunan',
                        'unduhan' => 380,
                        'ringkasan' => 'Daftar rekapitulasi RSUD, RS Swasta, 12 Puskesmas, dan Poskesdes di 8 kecamatan.',
                    ],
                    [
                        'judul' => 'Prevalensi Stunting Balita Berdasarkan Pengukuran E-PPGBM',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX'],
                        'frekuensi' => 'Semesteran',
                        'unduhan' => 520,
                        'ringkasan' => 'Persentase balita stunted menurut wilayah kerja puskesmas Kabupaten Bangka.',
                    ],
                    [
                        'judul' => 'Cakupan Imunisasi Dasar Lengkap (IDL) Bayi per Wilayah',
                        'tahun' => '2023-2024',
                        'format' => ['CSV', 'PDF'],
                        'frekuensi' => 'Tahunan',
                        'unduhan' => 290,
                        'ringkasan' => 'Persentase pencapaian imunisasi wajib bagi bayi usia 0-11 bulan.',
                    ],
                    [
                        'judul' => 'Distribusi Dokter Spesialis, Dokter Umum, dan Perawat',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX'],
                        'frekuensi' => 'Tahunan',
                        'unduhan' => 310,
                        'ringkasan' => 'Rasio ketersediaan tenaga kesehatan per 10.000 penduduk di Kabupaten Bangka.',
                    ],
                ],
            ],
            [
                'id' => 'dinas-pendidikan',
                'nama' => 'Dinas Pendidikan dan Kebudayaan',
                'akronim' => 'Dindikbud',
                'klaster' => 'Pendidikan',
                'deskripsi' => 'Data statistik sekolah, rasio guru terhadap siswa, angka partisipasi sekolah (APS/APM/APK), sarana prasarana belajar, dan indeks mutu pendidikan.',
                'alamat' => 'Komplek Perkantoran Pemkab Bangka, Sungailiat',
                'jumlah_dataset' => 15,
                'terakhir_update' => 'Juli 2024',
                'ikon' => 'graduation-cap',
                'warna' => '#3B82F6',
                'datasets' => [
                    [
                        'judul' => 'Jumlah Satuan Pendidikan PAUD, SD, dan SMP Negeri/Swasta',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX', 'PDF'],
                        'frekuensi' => 'Tahunan',
                        'unduhan' => 450,
                        'ringkasan' => 'Data pokok pendidikan (Dapodik) jumlah sekolah dan status akreditasi per kecamatan.',
                    ],
                    [
                        'judul' => 'Angka Partisipasi Murni (APM) dan Kasar (APK) Jenjang SD-SMP',
                        'tahun' => '2023-2024',
                        'format' => ['CSV', 'XLSX'],
                        'frekuensi' => 'Tahunan',
                        'unduhan' => 610,
                        'ringkasan' => 'Indikator ketercapaian wajib belajar 9 tahun di Kabupaten Bangka.',
                    ],
                    [
                        'judul' => 'Rasio Jumlah Siswa per Guru Menurut Jenjang Pendidikan',
                        'tahun' => '2024',
                        'format' => ['CSV', 'PDF'],
                        'frekuensi' => 'Tahunan',
                        'unduhan' => 240,
                        'ringkasan' => 'Keseimbangan distribusi tenaga pendidik PNS, PPPK, dan honorer sekolah.',
                    ],
                    [
                        'judul' => 'Rekapitulasi Penerima Beasiswa Siswa Kurang Mampu Daerah',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX'],
                        'frekuensi' => 'Semesteran',
                        'unduhan' => 380,
                        'ringkasan' => 'Realisasi bantuan pendidikan dari APBD Kabupaten Bangka bagi siswa pra-sejahtera.',
                    ],
                ],
            ],
            [
                'id' => 'dinas-pertanian-pangan',
                'nama' => 'Dinas Pertanian dan Ketahanan Pangan',
                'akronim' => 'Distan-KP',
                'klaster' => 'Pertanian',
                'deskripsi' => 'Data produksi tanaman pangan, hortikultura, luas panen padi sawah, perkebunan kelapa sawit & lada, populasi ternak, dan ketersediaan stok pangan.',
                'alamat' => 'Jl. Pemuda No. 45, Sungailiat',
                'jumlah_dataset' => 11,
                'terakhir_update' => 'Agustus 2024',
                'ikon' => 'sprout',
                'warna' => '#10B981',
                'datasets' => [
                    [
                        'judul' => 'Luas Panen dan Produksi Padi Sawah & Padi Ladang',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX', 'PDF'],
                        'frekuensi' => 'Semesteran',
                        'unduhan' => 430,
                        'ringkasan' => 'Estimasi gabah kering panen (GKP) dan luas tanam di sentra persawahan Bangka.',
                    ],
                    [
                        'judul' => 'Produksi dan Luas Areal Perkebunan Kelapa Sawit Rakyat',
                        'tahun' => '2023-2024',
                        'format' => ['CSV', 'XLSX'],
                        'frekuensi' => 'Tahunan',
                        'unduhan' => 590,
                        'ringkasan' => 'Data luas tanaman menghasilkan (TM), belum menghasilkan (TBM), dan produksi TBS.',
                    ],
                    [
                        'judul' => 'Neraca Ketersediaan dan Kebutuhan Pangan Pokok Strategis',
                        'tahun' => '2024',
                        'format' => ['CSV', 'PDF'],
                        'frekuensi' => 'Bulanan',
                        'unduhan' => 320,
                        'ringkasan' => 'Surplus/defisit stok beras, minyak goreng, gula, dan aneka cabai.',
                    ],
                ],
            ],
            [
                'id' => 'dinas-dukcapil',
                'nama' => 'Dinas Kependudukan dan Catatan Sipil',
                'akronim' => 'Dukcapil',
                'klaster' => 'Kependudukan',
                'deskripsi' => 'Statistik agregat pendaftaran penduduk, kepemilikan dokumen administrasi (KTP-el, KIA, Akta Kelahiran), dan perpindahan mutasi warga.',
                'alamat' => 'Jl. Jenderal Sudirman Komplek Perkantoran, Sungailiat',
                'jumlah_dataset' => 9,
                'terakhir_update' => 'Juli 2024',
                'ikon' => 'id-card',
                'warna' => '#6366F1',
                'datasets' => [
                    [
                        'judul' => 'Jumlah Penduduk Berdasarkan Kelompok Umur dan Jenis Kelamin',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX', 'PDF'],
                        'frekuensi' => 'Semesteran',
                        'unduhan' => 740,
                        'ringkasan' => 'Data konsolidasi bersih (DKB) Kemendagri per kelurahan/desa Kabupaten Bangka.',
                    ],
                    [
                        'judul' => 'Cakupan Perekaman KTP Elektronik dan Kepemilikan KIA',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX'],
                        'frekuensi' => 'Bulanan',
                        'unduhan' => 410,
                        'ringkasan' => 'Persentase wajib KTP yang telah merekam biometrik dan aktivasi IKD.',
                    ],
                    [
                        'judul' => 'Rekapitulasi Penerbitan Akta Kelahiran dan Akta Kematian',
                        'tahun' => '2023-2024',
                        'format' => ['CSV', 'PDF'],
                        'frekuensi' => 'Semesteran',
                        'unduhan' => 280,
                        'ringkasan' => 'Statistik peristiwa vital kependudukan di 8 kecamatan.',
                    ],
                ],
            ],
            [
                'id' => 'dinas-sosial',
                'nama' => 'Dinas Sosial Kabupaten Bangka',
                'akronim' => 'Dinsos',
                'klaster' => 'Sosial',
                'deskripsi' => 'Data Terpadu Kesejahteraan Sosial (DTKS), penerima Program Keluarga Harapan (PKH), bantuan pangan sembako, dan penanganan PMKS daerah.',
                'alamat' => 'Jl. Imam Bonjol No. 08, Sungailiat',
                'jumlah_dataset' => 8,
                'terakhir_update' => 'Agustus 2024',
                'ikon' => 'users',
                'warna' => '#EC4899',
                'datasets' => [
                    [
                        'judul' => 'Data Penerima Bantuan Sosial PKH dan BPNT per Desa/Kelurahan',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX', 'PDF'],
                        'frekuensi' => 'Triwulanan',
                        'unduhan' => 670,
                        'ringkasan' => 'Daftar agregat keluarga penerima manfaat (KPM) bantuan perlindungan sosial.',
                    ],
                    [
                        'judul' => 'Sebaran Penyandang Masalah Kesejahteraan Sosial (PMKS)',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX'],
                        'frekuensi' => 'Tahunan',
                        'unduhan' => 310,
                        'ringkasan' => 'Data penyandang disabilitas, lansia terlantar, dan anak yatim penerima atensi sosial.',
                    ],
                ],
            ],
            [
                'id' => 'dinas-lingkungan-hidup',
                'nama' => 'Dinas Lingkungan Hidup',
                'akronim' => 'DLH',
                'klaster' => 'Lingkungan',
                'deskripsi' => 'Statistik timbulan sampah harian, capaian Indeks Kualitas Lingkungan Hidup (IKLH), kualitas air sungai, dan pengelolaan ruang terbuka hijau.',
                'alamat' => 'Jl. Pemuda Komplek Islamic Center, Sungailiat',
                'jumlah_dataset' => 7,
                'terakhir_update' => 'Juni 2024',
                'ikon' => 'trees',
                'warna' => '#059669',
                'datasets' => [
                    [
                        'judul' => 'Volume Timbulan Sampah dan Tingkat Pengurangan ke TPA',
                        'tahun' => '2024',
                        'format' => ['CSV', 'XLSX', 'PDF'],
                        'frekuensi' => 'Semesteran',
                        'unduhan' => 360,
                        'ringkasan' => 'Kapasitas angkut harian menuju TPA Kenanga dan bank sampah unit.',
                    ],
                    [
                        'judul' => 'Indeks Kualitas Lingkungan Hidup (IKLH) dan Kualitas Air Sungai',
                        'tahun' => '2023-2024',
                        'format' => ['CSV', 'PDF'],
                        'frekuensi' => 'Tahunan',
                        'unduhan' => 290,
                        'ringkasan' => 'Skor Indeks Kualitas Air (IKA), Kualitas Udara (IKU), dan Kualitas Lahan (IKL).',
                    ],
                ],
            ],
        ];

        $klasterList = ['Semua', 'Kesehatan', 'Pendidikan', 'Pertanian', 'Kependudukan', 'Sosial', 'Lingkungan'];

        return view('publikasi.statistik-sektoral-opd', [
            'items' => $items,
            'klasterList' => $klasterList,
        ]);
    }

    /**
     * Halaman data sektoral lintas OPD tingkat kabupaten.
     */
    public function statistikSektoralKabupaten(): View
    {
        $items = [
            [
                'id' => 'sosial-kependudukan',
                'nama' => 'Sosial dan Kependudukan',
                'deskripsi' => 'Indikator makro kesejahteraan masyarakat, penanggulangan kemiskinan, perlindungan sosial, mutu pendidikan, derajat kesehatan, dan dinamika kependudukan lintas OPD.',
                'jumlah_indikator' => 24,
                'ikon' => 'users-round',
                'warna' => '#3B82F6',
                'indikator' => [
                    [
                        'nama' => 'Persentase Penduduk Miskin (P0)',
                        'nilai' => '4,21',
                        'satuan' => '%',
                        'target' => '4,30',
                        'tren' => '-0,32%',
                        'tren_status' => 'baik',
                        'opd' => 'BPS & Dinsos Bangka',
                        'periode' => 'Semester I 2024',
                    ],
                    [
                        'nama' => 'Indeks Pembangunan Manusia (IPM)',
                        'nilai' => '73,42',
                        'satuan' => 'Poin',
                        'target' => '73,20',
                        'tren' => '+0,58 Poin',
                        'tren_status' => 'baik',
                        'opd' => 'Bappeda Litbang & BPS',
                        'periode' => 'Tahunan 2024',
                    ],
                    [
                        'nama' => 'Tingkat Pengangguran Terbuka (TPT)',
                        'nilai' => '4,38',
                        'satuan' => '%',
                        'target' => '4,50',
                        'tren' => '-0,24%',
                        'tren_status' => 'baik',
                        'opd' => 'Dinakerperindag & BPS',
                        'periode' => 'Semester I 2024',
                    ],
                    [
                        'nama' => 'Angka Harapan Hidup (AHH) saat Lahir',
                        'nilai' => '73,18',
                        'satuan' => 'Tahun',
                        'target' => '73,00',
                        'tren' => '+0,22 Tahun',
                        'tren_status' => 'baik',
                        'opd' => 'Dinas Kesehatan & BPS',
                        'periode' => 'Tahunan 2024',
                    ],
                    [
                        'nama' => 'Harapan Lama Sekolah (HLS)',
                        'nilai' => '13,05',
                        'satuan' => 'Tahun',
                        'target' => '13,00',
                        'tren' => '+0,08 Tahun',
                        'tren_status' => 'baik',
                        'opd' => 'Dindikbud & BPS',
                        'periode' => 'Tahunan 2024',
                    ],
                    [
                        'nama' => 'Prevalensi Stunting Balita',
                        'nilai' => '12,4',
                        'satuan' => '%',
                        'target' => '14,0',
                        'tren' => '-1,8%',
                        'tren_status' => 'baik',
                        'opd' => 'Dinkes Kab. Bangka',
                        'periode' => 'Semester I 2024',
                    ],
                ],
            ],
            [
                'id' => 'perekonomian-investasi',
                'nama' => 'Ekonomi, Keuangan & Investasi',
                'deskripsi' => 'Perkembangan Produk Domestik Regional Bruto (PDRB), laju inflasi daerah, realisasi investasi PMDN/PMA, kemandirian fiskal APBD, dan neraca perdagangan.',
                'jumlah_indikator' => 18,
                'ikon' => 'bar-chart-3',
                'warna' => '#10B981',
                'indikator' => [
                    [
                        'nama' => 'Laju Pertumbuhan Ekonomi (PDRB)',
                        'nilai' => '4,12',
                        'satuan' => '%',
                        'target' => '4,00',
                        'tren' => '+0,45%',
                        'tren_status' => 'baik',
                        'opd' => 'BPS & Bappeda Litbang',
                        'periode' => 'Triwulan II 2024',
                    ],
                    [
                        'nama' => 'Tingkat Inflasi Tahunan (YoY)',
                        'nilai' => '2,14',
                        'satuan' => '%',
                        'target' => '2,5 ± 1',
                        'tren' => '-0,42%',
                        'tren_status' => 'baik',
                        'opd' => 'TPID & BPS Bangka',
                        'periode' => 'Agustus 2024',
                    ],
                    [
                        'nama' => 'Realisasi Investasi Daerah (PMDN & PMA)',
                        'nilai' => '1,42',
                        'satuan' => 'Triliun Rp',
                        'target' => '1,20 Triliun',
                        'tren' => '+18,3%',
                        'tren_status' => 'baik',
                        'opd' => 'DPMPTSP Kab. Bangka',
                        'periode' => 'Semester I 2024',
                    ],
                    [
                        'nama' => 'Rasio Kemandirian Keuangan Daerah',
                        'nilai' => '16,8',
                        'satuan' => '%',
                        'target' => '16,0',
                        'tren' => '+1,2%',
                        'tren_status' => 'baik',
                        'opd' => 'BPKAD Kab. Bangka',
                        'periode' => 'Semester I 2024',
                    ],
                    [
                        'nama' => 'Nilai Tukar Petani (NTP) Lokal',
                        'nilai' => '114,8',
                        'satuan' => 'Indeks',
                        'target' => '105,0',
                        'tren' => '+3,4 Poin',
                        'tren_status' => 'baik',
                        'opd' => 'Distan-KP & BPS',
                        'periode' => 'Juli 2024',
                    ],
                ],
            ],
            [
                'id' => 'infrastruktur-lingkungan',
                'nama' => 'Infrastruktur dan Lingkungan Hidup',
                'deskripsi' => 'Kondisi kemantapan jalan kabupaten, cakupan akses air minum layak, sanitasi terkelola aman, elektrifikasi rumah tangga, dan Indeks Kualitas Lingkungan Hidup (IKLH).',
                'jumlah_indikator' => 14,
                'ikon' => 'building-2',
                'warna' => '#F59E0B',
                'indikator' => [
                    [
                        'nama' => 'Kemantapan Jalan Kabupaten',
                        'nilai' => '78,4',
                        'satuan' => '%',
                        'target' => '77,0',
                        'tren' => '+2,1%',
                        'tren_status' => 'baik',
                        'opd' => 'Dinas PUPR Bangka',
                        'periode' => 'Semester I 2024',
                    ],
                    [
                        'nama' => 'Akses Rumah Tangga ke Air Minum Layak',
                        'nilai' => '89,2',
                        'satuan' => '%',
                        'target' => '88,0',
                        'tren' => '+1,5%',
                        'tren_status' => 'baik',
                        'opd' => 'Perumda Tirta Bangka & PUPR',
                        'periode' => 'Tahunan 2024',
                    ],
                    [
                        'nama' => 'Akses Sanitasi Layak & Aman',
                        'nilai' => '84,6',
                        'satuan' => '%',
                        'target' => '82,0',
                        'tren' => '+2,3%',
                        'tren_status' => 'baik',
                        'opd' => 'Dinkes & Dinas PUPR',
                        'periode' => 'Tahunan 2024',
                    ],
                    [
                        'nama' => 'Indeks Kualitas Lingkungan Hidup (IKLH)',
                        'nilai' => '68,14',
                        'satuan' => 'Poin',
                        'target' => '67,00',
                        'tren' => '+1,14 Poin',
                        'tren_status' => 'baik',
                        'opd' => 'DLH Kab. Bangka',
                        'periode' => 'Tahunan 2023/2024',
                    ],
                ],
            ],
            [
                'id' => 'pemerintahan-hukum',
                'nama' => 'Pemerintahan, Hukum & Layanan Publik',
                'deskripsi' => 'Pengukuran Sistem Pemerintahan Berbasis Elektronik (SPBE), Indeks Kepuasan Masyarakat (IKM), Opini BPK atas Laporan Keuangan, dan Kepatuhan Pelayanan Publik.',
                'jumlah_indikator' => 10,
                'ikon' => 'landmark',
                'warna' => '#8B5CF6',
                'indikator' => [
                    [
                        'nama' => 'Indeks SPBE Kabupaten Bangka',
                        'nilai' => '3,48',
                        'satuan' => 'Skala 5 (Baik)',
                        'target' => '3,30',
                        'tren' => '+0,26 Poin',
                        'tren_status' => 'baik',
                        'opd' => 'Dinkominfotik Bangka',
                        'periode' => 'Evaluasi KemenPAN-RB',
                    ],
                    [
                        'nama' => 'Indeks Kepuasan Masyarakat (IKM)',
                        'nilai' => '88,40',
                        'satuan' => 'Nilai (Sangat Baik)',
                        'target' => '86,00',
                        'tren' => '+1,80 Poin',
                        'tren_status' => 'baik',
                        'opd' => 'Bagian Organisasi Setda',
                        'periode' => 'Semester I 2024',
                    ],
                    [
                        'nama' => 'Opini BPK atas LKPD Pemkab Bangka',
                        'nilai' => 'WTP',
                        'satuan' => 'Opini (Tanpa Pengecualian)',
                        'target' => 'WTP',
                        'tren' => 'Mempertahankan (Ke-7 Kali)',
                        'tren_status' => 'baik',
                        'opd' => 'Inspektorat & BPKAD',
                        'periode' => 'LKPD TA 2023',
                    ],
                    [
                        'nama' => 'Kepatuhan Standar Pelayanan Ombudsman',
                        'nilai' => '89,92',
                        'satuan' => 'Zona Hijau (Tinggi)',
                        'target' => '88,00',
                        'tren' => '+2,10 Poin',
                        'tren_status' => 'baik',
                        'opd' => 'Ombudsman RI & Setda Bangka',
                        'periode' => 'Tahunan 2024',
                    ],
                ],
            ],
        ];

        return view('publikasi.statistik-sektoral-kabupaten', ['items' => $items]);
    }
}
