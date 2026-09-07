<?php

return [
    'years' => [
        0 => 2025,
        1 => 2024,
        2 => 2023,
        3 => 2022,
        4 => 2021,
        5 => 2020,
    ],
    'default_year' => 2025,
    'headline_indicators' => [
        0 => [
            'id' => 'ipm',
            'name' => 'Indeks Pembangunan Manusia (IPM)',
            'short_name' => 'IPM Bangka',
            'sector' => 'pendidikan',
            'value' => 75.02,
            'unit' => 'Poin',
            'yoy_change' => 0.36,
            'lower_is_better' => false,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 75.02,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 74.66,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 74.23,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 73.48,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 72.85,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 72.4,
                ],
            ],
            'metadata' => [
                'produsen' => 'BPS Kabupaten Bangka',
                'definisi' => 'Indeks komposit yang mengukur capaian pembangunan manusia berbasis tiga dimensi dasar: umur panjang dan hidup sehat, pengetahuan, serta standar hidup layak.',
                'satuan' => 'Poin Indeks (0-100)',
                'metodologi' => 'Metode baru BPS dengan agregasi rata-rata geometrik UHH, HLS, RLS, dan Pengeluaran Riil per Kapita disesuaikan.',
                'jadwal_rilis' => 'Tahunan (November/Desember)',
                'sumber_url' => 'https://bangkakab.bps.go.id',
            ],
        ],
        1 => [
            'id' => 'kemiskinan',
            'name' => 'Persentase Penduduk Miskin',
            'short_name' => 'Kemiskinan',
            'sector' => 'perekonomian',
            'value' => 4.32,
            'unit' => '%',
            'yoy_change' => -0.23,
            'lower_is_better' => true,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 4.32,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 4.55,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 4.8,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 4.91,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 5.12,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 5.36,
                ],
            ],
            'metadata' => [
                'produsen' => 'BPS Kabupaten Bangka & Bappeda Kab. Bangka',
                'definisi' => 'Persentase penduduk dengan pengeluaran per kapita per bulan di bawah Garis Kemiskinan (GK) Kabupaten Bangka.',
                'satuan' => 'Persen (%)',
                'metodologi' => 'Survei Sosial Ekonomi Nasional (Susenas) Modul Konsumsi/Pengeluaran periode Maret.',
                'jadwal_rilis' => 'Tahunan (Juli/Agustus)',
                'sumber_url' => 'https://bangkakab.bps.go.id',
            ],
        ],
        2 => [
            'id' => 'pertumbuhan-ekonomi',
            'name' => 'Laju Pertumbuhan Ekonomi (PDRB ADHK)',
            'short_name' => 'Pertumbuhan Ekonomi',
            'sector' => 'perekonomian',
            'value' => 4.42,
            'unit' => '%',
            'yoy_change' => 0.27,
            'lower_is_better' => false,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 4.42,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 4.15,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 4.38,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 4.03,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 4.25,
                ],
                5 => [
                    'year' => 2020,
                    'value' => -2.3,
                ],
            ],
            'metadata' => [
                'produsen' => 'BPS Kabupaten Bangka',
                'definisi' => 'Pertumbuhan Produk Domestik Regional Bruto (PDRB) atas dasar harga konstan 2010 yang mencerminkan pertumbuhan output riil barang dan jasa di Kab. Bangka.',
                'satuan' => 'Persen (%) per Tahun',
                'metodologi' => 'Penghitungan PDRB 17 Lapangan Usaha dan 6 Pengeluaran berdasarkan SNA 2008.',
                'jadwal_rilis' => 'Tahunan (Februari/Maret)',
                'sumber_url' => 'https://bangkakab.bps.go.id',
            ],
        ],
        3 => [
            'id' => 'tpt',
            'name' => 'Tingkat Pengangguran Terbuka (TPT)',
            'short_name' => 'TPT (Pengangguran)',
            'sector' => 'ketenagakerjaan',
            'value' => 4.65,
            'unit' => '%',
            'yoy_change' => -0.23,
            'lower_is_better' => true,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 4.65,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 4.88,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 5.03,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 5.39,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 5.56,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 5.82,
                ],
            ],
            'metadata' => [
                'produsen' => 'BPS Kabupaten Bangka & Dinakerperindag Kab. Bangka',
                'definisi' => 'Persentase jumlah penganggur terhadap jumlah total angkatan kerja di Kabupaten Bangka.',
                'satuan' => 'Persen (%)',
                'metodologi' => 'Survei Angkatan Kerja Nasional (Sakernas) periode Agustus.',
                'jadwal_rilis' => 'Tahunan (November)',
                'sumber_url' => 'https://bangkakab.bps.go.id',
            ],
        ],
    ],
    'sectors' => [
        0 => [
            'id' => 'kependudukan',
            'label' => 'Kependudukan',
            'icon' => 'users',
            'color' => '#DC2626',
        ],
        1 => [
            'id' => 'perekonomian',
            'label' => 'Perekonomian',
            'icon' => 'trending-up',
            'color' => '#E11D48',
        ],
        2 => [
            'id' => 'ketenagakerjaan',
            'label' => 'Ketenagakerjaan',
            'icon' => 'briefcase',
            'color' => '#BE123C',
        ],
        3 => [
            'id' => 'kesehatan',
            'label' => 'Kesehatan',
            'icon' => 'heart-pulse',
            'color' => '#991B1B',
        ],
        4 => [
            'id' => 'pendidikan',
            'label' => 'Pendidikan',
            'icon' => 'graduation-cap',
            'color' => '#B91C1C',
        ],
        5 => [
            'id' => 'pertanian',
            'label' => 'Pertanian & Pangan',
            'icon' => 'wheat',
            'color' => '#C2410C',
        ],
        6 => [
            'id' => 'sosial',
            'label' => 'Sosial & Kesejahteraan',
            'icon' => 'shield-check',
            'color' => '#7C2D12',
        ],
    ],
    'sector_indicators' => [
        'kependudukan' => [
            'name' => 'Jumlah Penduduk Kabupaten Bangka',
            'short_name' => 'Total Penduduk',
            'unit' => 'Jiwa',
            'value' => 345280,
            'yoy_change' => 1.03,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 345280,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 341760,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 338175,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 334220,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 330142,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 326265,
                ],
            ],
            'metadata' => [
                'produsen' => 'BPS Kabupaten Bangka & Dinas Dukcapil Kab. Bangka',
                'definisi' => 'Jumlah keseluruhan warga negara dan penduduk yang berdomisili resmi di wilayah Kabupaten Bangka.',
                'satuan' => 'Jiwa',
                'metodologi' => 'Sensus Penduduk & Proyeksi Penduduk Interim BPS - Ditjen Dukcapil.',
                'jadwal_rilis' => 'Tahunan (Semester II)',
            ],
            'column' => [
                'key' => 'population',
                'label' => 'Jumlah Penduduk',
                'unit' => 'Jiwa',
                'digits' => 0,
            ],
            'digits' => 0,
        ],
        'perekonomian' => [
            'name' => 'PDRB per Kapita Atas Dasar Harga Berlaku',
            'short_name' => 'PDRB per Kapita',
            'unit' => 'Juta Rp',
            'value' => 67.95,
            'yoy_change' => 4.83,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 67.95,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 64.82,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 62.4,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 59.8,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 56.15,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 52.3,
                ],
            ],
            'metadata' => [
                'produsen' => 'BPS Kabupaten Bangka',
                'definisi' => 'Nilai PDRB ADHB dibagi dengan jumlah penduduk pertengahan tahun yang mencerminkan pendapatan rata-rata per kapita.',
                'satuan' => 'Juta Rp',
                'metodologi' => 'Perhitungan PDRB Berdasarkan Sistem Neraca Nasional 2008.',
                'jadwal_rilis' => 'Tahunan (Maret)',
            ],
            'column' => [
                'key' => 'pdrb_kapita',
                'label' => 'Estimasi PDRB per Kapita',
                'unit' => 'Juta Rp',
                'digits' => 2,
            ],
            'digits' => 2,
        ],
        'ketenagakerjaan' => [
            'name' => 'Tingkat Partisipasi Angkatan Kerja (TPAK)',
            'short_name' => 'TPAK Bangka',
            'unit' => '%',
            'value' => 68.3,
            'yoy_change' => 0.45,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 68.3,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 67.85,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 67.23,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 66.9,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 66.12,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 65.4,
                ],
            ],
            'metadata' => [
                'produsen' => 'BPS Kabupaten Bangka',
                'definisi' => 'Persentase jumlah angkatan kerja (bekerja + menganggur) terhadap penduduk usia kerja (15 tahun ke atas).',
                'satuan' => '%',
                'metodologi' => 'Survei Angkatan Kerja Nasional (Sakernas) BPS.',
                'jadwal_rilis' => 'Tahunan (November)',
            ],
            'column' => [
                'key' => 'angkatan_kerja',
                'label' => 'Angkatan Kerja Aktif',
                'unit' => 'Jiwa',
                'digits' => 0,
            ],
            'digits' => 2,
        ],
        'kesehatan' => [
            'name' => 'Angka Harapan Hidup saat Lahir (UHH)',
            'short_name' => 'Usia Harapan Hidup',
            'unit' => 'Tahun',
            'value' => 73.38,
            'yoy_change' => 0.23,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 73.38,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 73.15,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 72.87,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 72.65,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 72.3,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 71.95,
                ],
            ],
            'metadata' => [
                'produsen' => 'BPS Kabupaten Bangka & Dinas Kesehatan Kab. Bangka',
                'definisi' => 'Rata-rata perkiraan banyak tahun yang dapat ditempuh oleh seseorang sejak lahir di Kabupaten Bangka.',
                'satuan' => 'Tahun',
                'metodologi' => 'Perhitungan tabel kematian (life table) dari data Susenas BPS & SP2020.',
                'jadwal_rilis' => 'Tahunan (Desember)',
            ],
            'column' => [
                'key' => 'puskesmas_faskes',
                'label' => 'Fasilitas Kesehatan Aktif',
                'unit' => 'Unit',
                'digits' => 0,
            ],
            'digits' => 2,
        ],
        'pendidikan' => [
            'name' => 'Harapan Lama Sekolah (HLS)',
            'short_name' => 'Harapan Lama Sekolah',
            'unit' => 'Tahun',
            'value' => 13.15,
            'yoy_change' => 0.07,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 13.15,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 13.08,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 13.02,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 12.92,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 12.78,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 12.65,
                ],
            ],
            'metadata' => [
                'produsen' => 'BPS Kabupaten Bangka & Dindikpora Kab. Bangka',
                'definisi' => 'Lamanya sekolah (dalam tahun) yang diharapkan akan dirasakan oleh anak pada umur 7 tahun di masa mendatang.',
                'satuan' => 'Tahun',
                'metodologi' => 'Survei Sosial Ekonomi Nasional (Susenas) BPS.',
                'jadwal_rilis' => 'Tahunan (Desember)',
            ],
            'column' => [
                'key' => 'sekolah_total',
                'label' => 'Sekolah (SD/SMP/SMA)',
                'unit' => 'Unit',
                'digits' => 0,
            ],
            'digits' => 2,
        ],
        'pertanian' => [
            'name' => 'Luas Lahan Sawah Baku Kabupaten Bangka',
            'short_name' => 'Lahan Sawah Baku',
            'unit' => 'Hektar',
            'value' => 2257.08,
            'yoy_change' => -25.8,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 2257.08,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 3043.91,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 3027.5,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 2985.0,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 2940.2,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 2890.1,
                ],
            ],
            'metadata' => [
                'produsen' => 'Dinas Pangan dan Pertanian (DINPANPERTAN) Kab. Bangka & BPS',
                'definisi' => 'Luas hamparan lahan pertanian basah (sawah irigasi dan tadah hujan) menurut 8 kecamatan di Kabupaten Bangka.',
                'satuan' => 'Hektar',
                'metodologi' => 'Pemetaan Spasial LBS (Lahan Baku Sawah) ATR/BPN, BPS, dan Dinas Pertanian.',
                'jadwal_rilis' => 'Tahunan',
            ],
            'column' => [
                'key' => 'lahan_tani',
                'label' => 'Luas Lahan Sawah',
                'unit' => 'Hektar',
                'digits' => 0,
            ],
            'digits' => 2,
        ],
        'sosial' => [
            'name' => 'Keluarga Fakir Miskin (Desil 1-5 Dinsos)',
            'short_name' => 'Fakir Miskin Desil 1-5',
            'unit' => 'Keluarga',
            'value' => 57978,
            'yoy_change' => 0.0,
            'trend' => [
                0 => [
                    'year' => 2025,
                    'value' => 57978,
                ],
                1 => [
                    'year' => 2024,
                    'value' => 57978,
                ],
                2 => [
                    'year' => 2023,
                    'value' => 59040,
                ],
                3 => [
                    'year' => 2022,
                    'value' => 60120,
                ],
                4 => [
                    'year' => 2021,
                    'value' => 61400,
                ],
                5 => [
                    'year' => 2020,
                    'value' => 62800,
                ],
            ],
            'metadata' => [
                'produsen' => 'Dinas Sosial Kabupaten Bangka',
                'definisi' => 'Jumlah kepala keluarga miskin terverifikasi desil 1 sampai dengan desil 5 dalam basis data P3KE / DTKS Kabupaten Bangka.',
                'satuan' => 'Keluarga',
                'metodologi' => 'Verifikasi dan Validasi Mandiri SIKS-NG Dinas Sosial berbasis NIK Dukcapil.',
                'jadwal_rilis' => 'Semesteran',
            ],
            'column' => [
                'key' => 'penerima_bansos',
                'label' => 'Keluarga Fakir Miskin',
                'unit' => 'Keluarga',
                'digits' => 0,
            ],
            'digits' => 0,
        ],
    ],
    'kecamatan' => [
        0 => [
            'id' => 'sungailiat',
            'name' => 'Sungailiat',
            'capital' => 'Sungailiat (Ibu Kota)',
            'area_km2' => 147.74,
            'population' => 98420,
            'density' => 666,
            'pdrb_kapita' => 80.2,
            'angkatan_kerja' => 49100,
            'puskesmas_faskes' => 19,
            'sekolah_total' => 65,
            'lahan_tani' => 0,
            'penerima_bansos' => 15243,
            'kpi_cards' => [
                0 => [
                    'id' => 'pop_sungailiat',
                    'name' => 'Jumlah Penduduk Sungailiat',
                    'short_name' => 'Penduduk Sungailiat',
                    'value' => 98420,
                    'unit' => 'Jiwa',
                    'yoy_change' => 1.18,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 98420,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 97317,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 94750,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 93600,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 92480,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 91390,
                        ],
                    ],
                    'digits' => 0,
                ],
                1 => [
                    'id' => 'density_sungailiat',
                    'name' => 'Kepadatan Penduduk',
                    'short_name' => 'Kepadatan Wilayah',
                    'value' => 666,
                    'unit' => 'Jiwa/Km²',
                    'yoy_change' => 1.22,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 666,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 659,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 656,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 648,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 640,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 633,
                        ],
                    ],
                    'digits' => 0,
                ],
                2 => [
                    'id' => 'area_sungailiat',
                    'name' => 'Luas Wilayah Kecamatan',
                    'short_name' => 'Luas Wilayah',
                    'value' => 147.74,
                    'unit' => 'Km²',
                    'yoy_change' => 0.0,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 147.74,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 147.74,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 144.38,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 144.38,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 144.38,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 144.38,
                        ],
                    ],
                    'digits' => 2,
                ],
                3 => [
                    'id' => 'pdrb_sungailiat',
                    'name' => 'Estimasi PDRB per Kapita',
                    'short_name' => 'PDRB per Kapita',
                    'value' => 80.2,
                    'unit' => 'Juta Rp',
                    'yoy_change' => 5.52,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 80.2,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 76.5,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 72.5,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 69.2,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 65.4,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 61.2,
                        ],
                    ],
                    'digits' => 2,
                ],
            ],
            'sector_trends' => [
                'kependudukan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 98420,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 97317,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 94750,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 93600,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 92480,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 91390,
                    ],
                ],
                'perekonomian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 80.2,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 76.5,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 72.5,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 69.2,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 65.4,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 61.2,
                    ],
                ],
                'ketenagakerjaan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 49100,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 48200,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 47400,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 46600,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 45800,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 45000,
                    ],
                ],
                'kesehatan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 19,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 18,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 17,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 17,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 16,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 15,
                    ],
                ],
                'pendidikan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 65,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 64,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 64,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 63,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 62,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 61,
                    ],
                ],
                'pertanian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 0,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 12,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 12,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 13,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 14,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 15,
                    ],
                ],
                'sosial' => [
                    0 => [
                        'year' => 2025,
                        'value' => 15243,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 15243,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 15520,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 15810,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 16140,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 16510,
                    ],
                ],
            ],
        ],
        1 => [
            'id' => 'belinyu',
            'name' => 'Belinyu',
            'capital' => 'Belinyu',
            'area_km2' => 546.49,
            'population' => 52480,
            'density' => 96,
            'pdrb_kapita' => 71.5,
            'angkatan_kerja' => 26900,
            'puskesmas_faskes' => 13,
            'sekolah_total' => 46,
            'lahan_tani' => 2.19,
            'penerima_bansos' => 10337,
            'kpi_cards' => [
                0 => [
                    'id' => 'pop_belinyu',
                    'name' => 'Jumlah Penduduk Belinyu',
                    'short_name' => 'Penduduk Belinyu',
                    'value' => 52480,
                    'unit' => 'Jiwa',
                    'yoy_change' => 1.05,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 52480,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 52041,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 51600,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 51050,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 50520,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 50010,
                        ],
                    ],
                    'digits' => 0,
                ],
                1 => [
                    'id' => 'density_belinyu',
                    'name' => 'Kepadatan Penduduk',
                    'short_name' => 'Kepadatan Wilayah',
                    'value' => 96,
                    'unit' => 'Jiwa/Km²',
                    'yoy_change' => 1.05,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 96,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 95,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 95,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 93,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 92,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 91,
                        ],
                    ],
                    'digits' => 0,
                ],
                2 => [
                    'id' => 'area_belinyu',
                    'name' => 'Luas Wilayah Kecamatan',
                    'short_name' => 'Luas Wilayah',
                    'value' => 546.49,
                    'unit' => 'Km²',
                    'yoy_change' => 0.0,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 546.49,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 546.49,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 545.92,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 545.92,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 545.92,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 545.92,
                        ],
                    ],
                    'digits' => 2,
                ],
                3 => [
                    'id' => 'pdrb_belinyu',
                    'name' => 'Estimasi PDRB per Kapita',
                    'short_name' => 'PDRB per Kapita',
                    'value' => 71.5,
                    'unit' => 'Juta Rp',
                    'yoy_change' => 5.25,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 71.5,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 68.2,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 64.8,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 61.9,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 58.6,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 54.8,
                        ],
                    ],
                    'digits' => 2,
                ],
            ],
            'sector_trends' => [
                'kependudukan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 52480,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 52041,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 51600,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 51050,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 50520,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 50010,
                    ],
                ],
                'perekonomian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 71.5,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 68.2,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 64.8,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 61.9,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 58.6,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 54.8,
                    ],
                ],
                'ketenagakerjaan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 26900,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 26400,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 26050,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 25700,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 25300,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 24900,
                    ],
                ],
                'kesehatan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 13,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 12,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 12,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 11,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 11,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 10,
                    ],
                ],
                'pendidikan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 46,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 45,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 45,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 44,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 43,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 42,
                    ],
                ],
                'pertanian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 2.19,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 95,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 94,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 93,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 91,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 89,
                    ],
                ],
                'sosial' => [
                    0 => [
                        'year' => 2025,
                        'value' => 10337,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 10337,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 10530,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 10720,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 10950,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 11200,
                    ],
                ],
            ],
        ],
        2 => [
            'id' => 'mendo-barat',
            'name' => 'Mendo Barat',
            'capital' => 'Petaling',
            'area_km2' => 583.44,
            'population' => 53950,
            'density' => 92,
            'pdrb_kapita' => 61.2,
            'angkatan_kerja' => 26300,
            'puskesmas_faskes' => 11,
            'sekolah_total' => 39,
            'lahan_tani' => 908.41,
            'penerima_bansos' => 10620,
            'kpi_cards' => [
                0 => [
                    'id' => 'pop_mendo',
                    'name' => 'Jumlah Penduduk Mendo Barat',
                    'short_name' => 'Penduduk Mendo Barat',
                    'value' => 53950,
                    'unit' => 'Jiwa',
                    'yoy_change' => 1.2,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 53950,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 53238,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 51300,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 50700,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 50100,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 49500,
                        ],
                    ],
                    'digits' => 0,
                ],
                1 => [
                    'id' => 'density_mendo',
                    'name' => 'Kepadatan Penduduk',
                    'short_name' => 'Kepadatan Wilayah',
                    'value' => 92,
                    'unit' => 'Jiwa/Km²',
                    'yoy_change' => 1.12,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 92,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 91,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 89,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 88,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 87,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 86,
                        ],
                    ],
                    'digits' => 0,
                ],
                2 => [
                    'id' => 'area_mendo',
                    'name' => 'Luas Wilayah Kecamatan',
                    'short_name' => 'Luas Wilayah',
                    'value' => 583.44,
                    'unit' => 'Km²',
                    'yoy_change' => 0.0,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 583.44,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 583.44,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 574.44,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 574.44,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 574.44,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 574.44,
                        ],
                    ],
                    'digits' => 2,
                ],
                3 => [
                    'id' => 'pdrb_mendo',
                    'name' => 'Estimasi PDRB per Kapita',
                    'short_name' => 'PDRB per Kapita',
                    'value' => 61.2,
                    'unit' => 'Juta Rp',
                    'digits' => 2,
                    'yoy_change' => 5.04,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 61.2,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 58.4,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 55.6,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 53.1,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 50.4,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 47.2,
                        ],
                    ],
                    'metadata' => [
                        'produsen' => 'BPS Kabupaten Bangka',
                        'definisi' => 'Estimasi nilai PDRB per kapita Kecamatan Mendo Barat atas dasar harga berlaku.',
                        'satuan' => 'Juta Rp / Tahun',
                        'metodologi' => 'Perhitungan agregat PDRB wilayah BPS Kabupaten Bangka.',
                        'jadwal_rilis' => 'Tahunan',
                    ],
                ],
            ],
            'sector_trends' => [
                'kependudukan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 53950,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 53238,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 51300,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 50700,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 50100,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 49500,
                    ],
                ],
                'perekonomian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 61.2,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 58.4,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 55.6,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 53.1,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 50.4,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 47.2,
                    ],
                ],
                'ketenagakerjaan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 26300,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 25800,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 25400,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 25000,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 24600,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 24200,
                    ],
                ],
                'kesehatan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 11,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 10,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 10,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 9,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 9,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 8,
                    ],
                ],
                'pendidikan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 39,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 38,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 38,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 37,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 36,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 35,
                    ],
                ],
                'pertanian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 908.41,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 1266,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 1255,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 1238,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 1215,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 1190,
                    ],
                ],
                'sosial' => [
                    0 => [
                        'year' => 2025,
                        'value' => 10620,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 10620,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 10810,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 11010,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 11240,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 11500,
                    ],
                ],
            ],
        ],
        3 => [
            'id' => 'pemali',
            'name' => 'Pemali',
            'capital' => 'Air Duren',
            'area_km2' => 128.62,
            'population' => 36850,
            'density' => 286,
            'pdrb_kapita' => 69.4,
            'angkatan_kerja' => 18200,
            'puskesmas_faskes' => 8,
            'sekolah_total' => 28,
            'lahan_tani' => 0,
            'penerima_bansos' => 4838,
            'kpi_cards' => [
                0 => [
                    'id' => 'pop_pemali',
                    'name' => 'Jumlah Penduduk Pemali',
                    'short_name' => 'Penduduk Pemali',
                    'value' => 36850,
                    'unit' => 'Jiwa',
                    'yoy_change' => 1.1,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 36850,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 36357,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 35400,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 35000,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 34600,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 34200,
                        ],
                    ],
                    'digits' => 0,
                ],
                1 => [
                    'id' => 'density_pemali',
                    'name' => 'Kepadatan Penduduk',
                    'short_name' => 'Kepadatan Wilayah',
                    'value' => 286,
                    'unit' => 'Jiwa/Km²',
                    'yoy_change' => 1.09,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 286,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 283,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 275,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 272,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 269,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 266,
                        ],
                    ],
                    'digits' => 0,
                ],
                2 => [
                    'id' => 'area_pemali',
                    'name' => 'Luas Wilayah Kecamatan',
                    'short_name' => 'Luas Wilayah',
                    'value' => 128.62,
                    'unit' => 'Km²',
                    'yoy_change' => 0.0,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 128.62,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 128.62,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 128.53,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 128.53,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 128.53,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 128.53,
                        ],
                    ],
                    'digits' => 2,
                ],
                3 => [
                    'id' => 'pdrb_pemali',
                    'name' => 'Estimasi PDRB per Kapita',
                    'short_name' => 'PDRB per Kapita',
                    'value' => 69.4,
                    'unit' => 'Juta Rp',
                    'yoy_change' => 5.15,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 69.4,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 66.1,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 62.8,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 59.9,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 56.7,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 53.1,
                        ],
                    ],
                    'digits' => 2,
                ],
            ],
            'sector_trends' => [
                'kependudukan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 36850,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 36357,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 35400,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 35000,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 34600,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 34200,
                    ],
                ],
                'perekonomian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 69.4,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 66.1,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 62.8,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 59.9,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 56.7,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 53.1,
                    ],
                ],
                'ketenagakerjaan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 18200,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 17900,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 17650,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 17400,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 17150,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 16900,
                    ],
                ],
                'kesehatan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 8,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 8,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 8,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 7,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 7,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 6,
                    ],
                ],
                'pendidikan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 28,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 28,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 28,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 27,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 26,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 25,
                    ],
                ],
                'pertanian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 0,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 0,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 0,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 0,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 0,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 0,
                    ],
                ],
                'sosial' => [
                    0 => [
                        'year' => 2025,
                        'value' => 4838,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 4838,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 4930,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 5020,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 5130,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 5250,
                    ],
                ],
            ],
        ],
        4 => [
            'id' => 'merawang',
            'name' => 'Merawang',
            'capital' => 'Baturusa',
            'area_km2' => 209.92,
            'population' => 32310,
            'density' => 154,
            'pdrb_kapita' => 68.9,
            'angkatan_kerja' => 16500,
            'puskesmas_faskes' => 10,
            'sekolah_total' => 30,
            'lahan_tani' => 457.16,
            'penerima_bansos' => 4484,
            'kpi_cards' => [
                0 => [
                    'id' => 'pop_merawang',
                    'name' => 'Jumlah Penduduk Merawang',
                    'short_name' => 'Penduduk Merawang',
                    'value' => 32310,
                    'unit' => 'Jiwa',
                    'yoy_change' => 1.15,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 32310,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 31869,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 32110,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 31750,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 31390,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 31020,
                        ],
                    ],
                    'digits' => 0,
                ],
                1 => [
                    'id' => 'density_merawang',
                    'name' => 'Kepadatan Penduduk',
                    'short_name' => 'Kepadatan Wilayah',
                    'value' => 154,
                    'unit' => 'Jiwa/Km²',
                    'yoy_change' => 1.27,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 154,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 152,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 157,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 155,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 153,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 151,
                        ],
                    ],
                    'digits' => 0,
                ],
                2 => [
                    'id' => 'area_merawang',
                    'name' => 'Luas Wilayah Kecamatan',
                    'short_name' => 'Luas Wilayah',
                    'value' => 209.92,
                    'unit' => 'Km²',
                    'yoy_change' => 0.0,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 209.92,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 209.92,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 204.93,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 204.93,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 204.93,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 204.93,
                        ],
                    ],
                    'digits' => 2,
                ],
                3 => [
                    'id' => 'pdrb_merawang',
                    'name' => 'Estimasi PDRB per Kapita',
                    'short_name' => 'PDRB per Kapita',
                    'value' => 68.9,
                    'unit' => 'Juta Rp',
                    'yoy_change' => 5.28,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 68.9,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 65.8,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 62.5,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 59.6,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 56.4,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 52.8,
                        ],
                    ],
                    'digits' => 2,
                ],
            ],
            'sector_trends' => [
                'kependudukan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 32310,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 31869,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 32110,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 31750,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 31390,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 31020,
                    ],
                ],
                'perekonomian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 68.9,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 65.8,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 62.5,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 59.6,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 56.4,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 52.8,
                    ],
                ],
                'ketenagakerjaan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 16500,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 16200,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 15980,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 15760,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 15540,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 15300,
                    ],
                ],
                'kesehatan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 10,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 9,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 9,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 8,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 8,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 7,
                    ],
                ],
                'pendidikan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 30,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 29,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 29,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 28,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 27,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 26,
                    ],
                ],
                'pertanian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 457.16,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 508,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 505,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 498,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 490,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 482,
                    ],
                ],
                'sosial' => [
                    0 => [
                        'year' => 2025,
                        'value' => 4484,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 4484,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 4570,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 4650,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 4750,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 4860,
                    ],
                ],
            ],
        ],
        5 => [
            'id' => 'riau-silip',
            'name' => 'Riau Silip',
            'capital' => 'Riau',
            'area_km2' => 521.8,
            'population' => 30680,
            'density' => 59,
            'pdrb_kapita' => 62.1,
            'angkatan_kerja' => 15100,
            'puskesmas_faskes' => 7,
            'sekolah_total' => 26,
            'lahan_tani' => 174.16,
            'penerima_bansos' => 5556,
            'kpi_cards' => [
                0 => [
                    'id' => 'pop_riau',
                    'name' => 'Jumlah Penduduk Riau Silip',
                    'short_name' => 'Penduduk Riau Silip',
                    'value' => 30680,
                    'unit' => 'Jiwa',
                    'yoy_change' => 1.06,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 30680,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 30262,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 29300,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 28990,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 28680,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 28380,
                        ],
                    ],
                    'digits' => 0,
                ],
                1 => [
                    'id' => 'density_riau',
                    'name' => 'Kepadatan Penduduk',
                    'short_name' => 'Kepadatan Wilayah',
                    'value' => 59,
                    'unit' => 'Jiwa/Km²',
                    'yoy_change' => 1.78,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 59,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 58,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 56,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 55,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 55,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 54,
                        ],
                    ],
                    'digits' => 0,
                ],
                2 => [
                    'id' => 'area_riau',
                    'name' => 'Luas Wilayah Kecamatan',
                    'short_name' => 'Luas Wilayah',
                    'value' => 521.8,
                    'unit' => 'Km²',
                    'yoy_change' => 0.0,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 521.8,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 521.8,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 521.8,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 521.8,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 521.8,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 521.8,
                        ],
                    ],
                    'digits' => 2,
                ],
                3 => [
                    'id' => 'pdrb_riau',
                    'name' => 'Estimasi PDRB per Kapita',
                    'short_name' => 'PDRB per Kapita',
                    'value' => 62.1,
                    'unit' => 'Juta Rp',
                    'yoy_change' => 5.15,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 62.1,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 59.2,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 56.3,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 53.7,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 50.8,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 47.6,
                        ],
                    ],
                    'digits' => 2,
                ],
            ],
            'sector_trends' => [
                'kependudukan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 30680,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 30262,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 29300,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 28990,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 28680,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 28380,
                    ],
                ],
                'perekonomian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 62.1,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 59.2,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 56.3,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 53.7,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 50.8,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 47.6,
                    ],
                ],
                'ketenagakerjaan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 15100,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 14800,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 14600,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 14400,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 14200,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 14000,
                    ],
                ],
                'kesehatan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 7,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 7,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 7,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 6,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 6,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 5,
                    ],
                ],
                'pendidikan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 26,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 26,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 26,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 25,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 24,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 23,
                    ],
                ],
                'pertanian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 174.16,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 400,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 396,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 390,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 384,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 378,
                    ],
                ],
                'sosial' => [
                    0 => [
                        'year' => 2025,
                        'value' => 5556,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 5556,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 5660,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 5760,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 5880,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 6020,
                    ],
                ],
            ],
        ],
        6 => [
            'id' => 'puding-besar',
            'name' => 'Puding Besar',
            'capital' => 'Puding',
            'area_km2' => 373.1,
            'population' => 21250,
            'density' => 57,
            'pdrb_kapita' => 59.8,
            'angkatan_kerja' => 12650,
            'puskesmas_faskes' => 6,
            'sekolah_total' => 23,
            'lahan_tani' => 521.98,
            'penerima_bansos' => 3490,
            'kpi_cards' => [
                0 => [
                    'id' => 'pop_puding',
                    'name' => 'Jumlah Penduduk Puding Besar',
                    'short_name' => 'Penduduk Puding Besar',
                    'value' => 21250,
                    'unit' => 'Jiwa',
                    'yoy_change' => 1.08,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 21250,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 20949,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 24520,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 24260,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 24000,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 23750,
                        ],
                    ],
                    'digits' => 0,
                ],
                1 => [
                    'id' => 'density_puding',
                    'name' => 'Kepadatan Penduduk',
                    'short_name' => 'Kepadatan Wilayah',
                    'value' => 57,
                    'unit' => 'Jiwa/Km²',
                    'yoy_change' => 1.53,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 57,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 56,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 65,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 65,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 64,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 63,
                        ],
                    ],
                    'digits' => 0,
                ],
                2 => [
                    'id' => 'area_puding',
                    'name' => 'Luas Wilayah Kecamatan',
                    'short_name' => 'Luas Wilayah',
                    'value' => 373.1,
                    'unit' => 'Km²',
                    'yoy_change' => 0.0,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 373.1,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 373.1,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 373.1,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 373.1,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 373.1,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 373.1,
                        ],
                    ],
                    'digits' => 2,
                ],
                3 => [
                    'id' => 'pdrb_puding',
                    'name' => 'Estimasi PDRB per Kapita',
                    'short_name' => 'PDRB per Kapita',
                    'value' => 59.8,
                    'unit' => 'Juta Rp',
                    'yoy_change' => 5.15,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 59.8,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 57.1,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 54.3,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 51.8,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 49.0,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 45.9,
                        ],
                    ],
                    'digits' => 2,
                ],
            ],
            'sector_trends' => [
                'kependudukan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 21250,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 20949,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 24520,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 24260,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 24000,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 23750,
                    ],
                ],
                'perekonomian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 59.8,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 57.1,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 54.3,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 51.8,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 49.0,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 45.9,
                    ],
                ],
                'ketenagakerjaan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 12650,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 12400,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 12220,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 12050,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 11880,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 11700,
                    ],
                ],
                'kesehatan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 6,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 6,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 6,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 5,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 5,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 4,
                    ],
                ],
                'pendidikan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 23,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 22,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 22,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 21,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 20,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 19,
                    ],
                ],
                'pertanian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 521.98,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 1008,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 1000,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 988,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 975,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 960,
                    ],
                ],
                'sosial' => [
                    0 => [
                        'year' => 2025,
                        'value' => 3490,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 3490,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 3550,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 3620,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 3700,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 3780,
                    ],
                ],
            ],
        ],
        7 => [
            'id' => 'bakam',
            'name' => 'Bakam',
            'capital' => 'Bakam',
            'area_km2' => 482.9,
            'population' => 20010,
            'density' => 41,
            'pdrb_kapita' => 58.2,
            'angkatan_kerja' => 10050,
            'puskesmas_faskes' => 5,
            'sekolah_total' => 18,
            'lahan_tani' => 193.18,
            'penerima_bansos' => 3410,
            'kpi_cards' => [
                0 => [
                    'id' => 'pop_bakam',
                    'name' => 'Jumlah Penduduk Bakam',
                    'short_name' => 'Penduduk Bakam',
                    'value' => 20010,
                    'unit' => 'Jiwa',
                    'yoy_change' => 1.03,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 20010,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 19727,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 19260,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 19060,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 18860,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 18670,
                        ],
                    ],
                    'digits' => 0,
                ],
                1 => [
                    'id' => 'density_bakam',
                    'name' => 'Kepadatan Penduduk',
                    'short_name' => 'Kepadatan Wilayah',
                    'value' => 41,
                    'unit' => 'Jiwa/Km²',
                    'yoy_change' => 2.56,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 41,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 41,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 39,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 39,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 39,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 38,
                        ],
                    ],
                    'digits' => 0,
                ],
                2 => [
                    'id' => 'area_bakam',
                    'name' => 'Luas Wilayah Kecamatan',
                    'short_name' => 'Luas Wilayah',
                    'value' => 482.9,
                    'unit' => 'Km²',
                    'yoy_change' => 0.0,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 482.9,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 482.9,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 482.9,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 482.9,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 482.9,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 482.9,
                        ],
                    ],
                    'digits' => 2,
                ],
                3 => [
                    'id' => 'pdrb_bakam',
                    'name' => 'Estimasi PDRB per Kapita',
                    'short_name' => 'PDRB per Kapita',
                    'value' => 58.2,
                    'unit' => 'Juta Rp',
                    'yoy_change' => 5.1,
                    'trend' => [
                        0 => [
                            'year' => 2025,
                            'value' => 58.2,
                        ],
                        1 => [
                            'year' => 2024,
                            'value' => 55.6,
                        ],
                        2 => [
                            'year' => 2023,
                            'value' => 52.9,
                        ],
                        3 => [
                            'year' => 2022,
                            'value' => 50.4,
                        ],
                        4 => [
                            'year' => 2021,
                            'value' => 47.8,
                        ],
                        5 => [
                            'year' => 2020,
                            'value' => 44.9,
                        ],
                    ],
                    'digits' => 2,
                ],
            ],
            'sector_trends' => [
                'kependudukan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 20010,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 19727,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 19260,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 19060,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 18860,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 18670,
                    ],
                ],
                'perekonomian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 58.2,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 55.6,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 52.9,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 50.4,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 47.8,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 44.9,
                    ],
                ],
                'ketenagakerjaan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 10050,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 9800,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 9650,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 9500,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 9350,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 9200,
                    ],
                ],
                'kesehatan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 5,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 5,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 5,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 4,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 4,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 3,
                    ],
                ],
                'pendidikan' => [
                    0 => [
                        'year' => 2025,
                        'value' => 18,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 18,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 18,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 17,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 16,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 15,
                    ],
                ],
                'pertanian' => [
                    0 => [
                        'year' => 2025,
                        'value' => 193.18,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 250,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 248,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 245,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 242,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 238,
                    ],
                ],
                'sosial' => [
                    0 => [
                        'year' => 2025,
                        'value' => 3410,
                    ],
                    1 => [
                        'year' => 2024,
                        'value' => 3410,
                    ],
                    2 => [
                        'year' => 2023,
                        'value' => 3470,
                    ],
                    3 => [
                        'year' => 2022,
                        'value' => 3530,
                    ],
                    4 => [
                        'year' => 2021,
                        'value' => 3610,
                    ],
                    5 => [
                        'year' => 2020,
                        'value' => 3680,
                    ],
                ],
            ],
        ],
    ],
    'featured_datasets' => [
        0 => [
            'id' => 'ds-01',
            'title' => 'Statistik Kependudukan & Proyeksi Penduduk per Kecamatan Kab. Bangka 2020–2024',
            'category' => 'Kependudukan',
            'opd' => 'Dinas Kependudukan dan Pencatatan Sipil Kab. Bangka',
            'updated_at' => '15 Januari 2025',
            'url' => 'https://satudata.bangka.go.id/dataset',
        ],
        1 => [
            'id' => 'ds-02',
            'title' => 'Indikator PDRB & Pertumbuhan Ekonomi Lapangan Usaha Kab. Bangka 2020–2024',
            'category' => 'Perekonomian',
            'opd' => 'Badan Pusat Statistik (BPS) & Bappeda Kab. Bangka',
            'updated_at' => '02 Februari 2025',
            'url' => 'https://satudata.bangka.go.id/dataset',
        ],
        2 => [
            'id' => 'ds-03',
            'title' => 'Capaian Indeks Pembangunan Manusia (IPM) & Dimensi Pembentuk Kab. Bangka 2024',
            'category' => 'Pendidikan & Kesehatan',
            'opd' => 'Bappeda Kabupaten Bangka',
            'updated_at' => '10 Desember 2024',
            'url' => 'https://satudata.bangka.go.id/dataset',
        ],
    ],
];
