<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Module;
use App\Models\Perti;
use App\Models\Prodi;
use App\Models\Requirement;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Data demo: admin, perguruan tinggi, program studi, modul, dan persyaratan
 * berdasarkan standar 6 Kriteria Utama LAM-INFOKOM 2.1 (Tahun 2025) plus Suplemen Program Studi.
 */
class AccreditationDemoSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ─────────────────────────────────────────
        User::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'              => 'Administrator',
                'password'          => Hash::make('Admin123'),
                'role'              => UserRole::Admin,
                'email_verified_at' => now(),
            ]
        );

        // ── Perguruan Tinggi ───────────────────────────────
        $pertiUser = User::query()->updateOrCreate(
            ['email' => 'ulbi@gmail.com'],
            [
                'name'              => 'Universitas Logistik & Bisnis Internasional',
                'password'          => Hash::make('Ulbi1234'),
                'role'              => UserRole::Perti,
                'email_verified_at' => now(),
            ]
        );

        // Buat/update profil perti di tabel pertis
        $pertiProfile = Perti::query()->updateOrCreate(
            ['user_id' => $pertiUser->id],
            [
                'kode_pt' => '041104',
                'alamat'  => 'Bandung, Jawa Barat',
            ]
        );

        // ── Program Studi 1: Informatika ───────────────────
        $prodiUserA = User::query()->updateOrCreate(
            ['email' => 'informatika@gmail.com'],
            [
                'name'              => 'Program Studi Informatika',
                'password'          => Hash::make('Informatika123'),
                'role'              => UserRole::Prodi,
                'email_verified_at' => now(),
            ]
        );

        Prodi::query()->updateOrCreate(
            ['user_id' => $prodiUserA->id],
            [
                'perti_id'   => $pertiProfile->id,
                'kode_prodi' => 'IF001',
            ]
        );

        // ── Program Studi 2: Logistik ──────────────────────
        $prodiUserB = User::query()->updateOrCreate(
            ['email' => 'logistik@gmail.com'],
            [
                'name'              => 'Program Studi Logistik',
                'password'          => Hash::make('Logistik123'),
                'role'              => UserRole::Prodi,
                'email_verified_at' => now(),
            ]
        );

        Prodi::query()->updateOrCreate(
            ['user_id' => $prodiUserB->id],
            [
                'perti_id'   => $pertiProfile->id,
                'kode_prodi' => 'LG001',
            ]
        );

        $this->seedKriteriaLamInfokom();
    }

    /**
     * Master 6 Kriteria Utama LAM-INFOKOM 2.1 (Tahun 2025) plus Suplemen Program Studi.
     * Masing-masing memiliki 5 sub-bagian PPEPP (Penetapan, Pelaksanaan, Evaluasi, Pengendalian, Peningkatan).
     */
    private function seedKriteriaLamInfokom(): void
    {
        // ── Kriteria 1: Budaya Mutu ────────────────────────────────
        $m1 = Module::query()->updateOrCreate(
            ['sort_order' => 1],
            [
                'name' => 'Kriteria 1: Budaya Mutu',
                'description' => 'Sistem tata kelola internal UPPS/PT, SOP administrasi/keuangan/SDM, dan fungsi penjaminan mutu SPMI.',
            ]
        );

        $this->seedRequirements($m1->id, [
            [
                'title' => 'Penetapan: Standar Tata Kelola & Sistem Penjaminan Mutu Internal (SPMI)',
                'description' => 'Dokumen penetapan standar tata pamong, pedoman SPMI, kode etik, tupoksi organ pengelola, dan kebijakan resmi penjaminan mutu UPPS/PS.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pelaksanaan: Implementasi Tata Pamong, SOP Administrasi/Keuangan/SDM, & Siklus SPMI',
                'description' => 'Bukti pelaksanaan operasional harian, penerapan SOP administrasi/keuangan/SDM, berita acara rapat tata pamong, dan bukti terlaksananya siklus SPMI.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Evaluasi: Audit Mutu Internal (AMI) & Evaluasi Ketercapaian Standar Tata Kelola',
                'description' => 'Laporan hasil AMI tahunan, survei kepuasan pemangku kepentingan terhadap layanan tata kelola dan SDM, serta analisis gap ketercapaian SPMI.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Pengendalian: Rapat Tinjauan Manajemen (RTM) & Tindakan Korektif Tata Kelola',
                'description' => 'Notulen & risalah RTM, dokumen tindakan korektif dan pencegahan (CAPA), serta rekap penanganan temuan audit tata pamong.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Peningkatan: Peningkatan Standar Mutu Berkelanjutan & Benchmarking Tata Kelola',
                'description' => 'Bukti pembaruan standar mutu lebih tinggi (benchmarking), inovasi mekanisme tata kelola, dan sertifikasi sistem mutu (ISO/akreditasi internasional).',
                'sort_order' => 5,
            ],
        ]);

        // ── Kriteria 2: Relevansi Pendidikan ───────────────────────
        $m2 = Module::query()->updateOrCreate(
            ['sort_order' => 2],
            [
                'name' => 'Kriteria 2: Relevansi Pendidikan',
                'description' => 'Penerimaan mahasiswa (akses/afirmasi), kurikulum Outcome-Based Education (OBE), fleksibilitas belajar (RPL/micro-credentials), dan mutu lulusan/tracer study.',
            ]
        );

        $this->seedRequirements($m2->id, [
            [
                'title' => 'Penetapan: Standar Penerimaan Mahasiswa, Kurikulum OBE, & Kelulusan',
                'description' => 'Kebijakan seleksi mahasiswa baru (akses/afirmasi), pedoman kurikulum berbasis OBE, pemetaan CPL, aturan RPL & micro-credentials, serta standar kelulusan.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pelaksanaan: Pembelajaran OBE, Fleksibilitas Belajar, & Layanan Mahasiswa',
                'description' => 'Bukti implementasi kurikulum OBE (RPS, asesmen CPL), pelaksanaan program MBKM/RPL/micro-credentials, serta bimbingan akademik dan kemahasiswaan.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Evaluasi: Evaluasi Ketercapaian CPL, Masa Studi, & Tracer Study Lulusan',
                'description' => 'Laporan portofolio asesmen CPL berkala, evaluasi IPK & masa studi, laporan tracer study (waktu tunggu, relevansi bidang kerja), dan survei kepuasan pengguna lulusan.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Pengendalian: Pengendalian Mutu Pembelajaran & Tindak Lanjut Evaluasi Lulusan',
                'description' => 'Tindakan korektif terhadap kendala capaian CPL, tindak lanjut masukan tracer study/mitra industri, dan penyesuaian proses perkuliahan.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Peningkatan: Rekonstruksi Kurikulum OBE Berkelanjutan & Peningkatan Kompetensi Lulusan',
                'description' => 'Bukti pembaruan kurikulum berbasis masukan asosiasi profesi komputasi/industri, sertifikasi kompetensi lulusan, dan peningkatan capaian mutu pendidikan.',
                'sort_order' => 5,
            ],
        ]);

        // ── Kriteria 3: Relevansi Penelitian ───────────────────────
        $m3 = Module::query()->updateOrCreate(
            ['sort_order' => 3],
            [
                'name' => 'Kriteria 3: Relevansi Penelitian',
                'description' => 'Sarpras riset, pembiayaan, roadmap penelitian DTPR & mahasiswa, kolaborasi riset, publikasi jurnal, dan HKI.',
            ]
        );

        $this->seedRequirements($m3->id, [
            [
                'title' => 'Penetapan: Roadmap Penelitian DTPR & Mahasiswa, Standar Sarpras & Pendanaan Riset',
                'description' => 'Dokumen roadmap penelitian berjangka prodi/UPPS, pedoman skema hibah riset, standar sarana lab penelitian, serta pedoman keterlibatan mahasiswa dalam riset.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pelaksanaan: Kegiatan Riset Kolaboratif, Realisasi Pendanaan, & Penulisan Luaran',
                'description' => 'Kontrak/laporan pelaksanaan penelitian dosen dan mahasiswa, bukti MoU/MoA kolaborasi riset nasional/internasional, dan utilisasi fasilitas lab riset.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Evaluasi: Evaluasi Ketercapaian Roadmap Penelitian, Publikasi Jurnal, & HKI',
                'description' => 'Laporan evaluasi luaran riset (publikasi jurnal terakreditasi/internasional bereputasi, prosiding, sitasi, paten/hak cipta), serta rasio produktivitas riset DTPR.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Pengendalian: Pengendalian Mutu Penelitian & Mitigasi Keterlambatan Luaran',
                'description' => 'Monitoring berkala kemajuan riset, rekap kendala publikasi/HKI, evaluasi kepatuhan terhadap roadmap penelitian, dan corrective actions penjaminan mutu riset.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Peningkatan: Peningkatan Kerjasama Riset Internasional & Hilirisasi Hasil Penelitian',
                'description' => 'Peningkatan target publikasi pada jurnal bereputasi tinggi, komersialisasi/hilirisasi prototipe riset bidang teknologi informasi, dan perluasan jejaring riset.',
                'sort_order' => 5,
            ],
        ]);

        // ── Kriteria 4: Relevansi Pengabdian kepada Masyarakat ───────
        $m4 = Module::query()->updateOrCreate(
            ['sort_order' => 4],
            [
                'name' => 'Kriteria 4: Relevansi Pengabdian kepada Masyarakat',
                'description' => 'Sarpras PkM, pembiayaan, roadmap PkM teknologi tepat guna, adopsi masyarakat/DUDIKA, diseminasi, dan HKI PkM.',
            ]
        );

        $this->seedRequirements($m4->id, [
            [
                'title' => 'Penetapan: Roadmap PkM Teknologi Tepat Guna, Standar Sarpras & Pendanaan PkM',
                'description' => 'Roadmap PkM berbasis penyelesaian masalah masyarakat/DUDIKA, pedoman pendanaan PkM, panduan penerapan teknologi tepat guna (TTG) infokom, dan pelibatan mahasiswa.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pelaksanaan: Implementasi PkM Bersama Mitra/DUDIKA & Diseminasi Solusi Digital',
                'description' => 'Bukti pelaksanaan program PkM lapangan, pelatihan/pendampingan teknologi digital, MoA/surat tugas pengabdian, dan implementasi teknologi di masyarakat mitra.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Evaluasi: Evaluasi Dampak/Adopsi Teknologi oleh Mitra, Publikasi, & HKI PkM',
                'description' => 'Laporan kepuasan mitra dan tingkat adopsi solusi teknologi infokom oleh masyarakat/DUDIKA, artikel jurnal pengabdian, hak cipta modul, dan evaluasi dampak.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Pengendalian: Pengendalian Keberlanjutan PkM & Penanganan Kendala Mitra',
                'description' => 'Tindak lanjut hasil evaluasi kepuasan mitra, perbaikan sistem pendampingan, serta penanganan kendala operasional penerapan teknologi oleh masyarakat mitra.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Peningkatan: Pengembangan Kemitraan Strategis Berkelanjutan & Replikasi Solusi TTG',
                'description' => 'Peningkatan skala kemitraan dengan DUDIKA/pemerintah daerah, replikasi produk PkM ke wilayah binaan lebih luas, dan pembaruan standar capaian PkM.',
                'sort_order' => 5,
            ],
        ]);

        // ── Kriteria 5: Akuntabilitas ──────────────────────────────
        $m5 = Module::query()->updateOrCreate(
            ['sort_order' => 5],
            [
                'name' => 'Kriteria 5: Akuntabilitas',
                'description' => 'Sistem informasi tata kelola otonom yang transparan (SIM Akademik, Keuangan, SDM, Sarpras, SPMI), audit mutu, dan kecukupan sarpras pembelajaran.',
            ]
        );

        $this->seedRequirements($m5->id, [
            [
                'title' => 'Penetapan: Standar SIM Terpadu, Tata Kelola Otonom, & Alokasi Anggaran Sarpras',
                'description' => 'Kebijakan operasional SIM terintegrasi, standar kecukupan bandwidth & keamanan data, aturan tata kelola keuangan otonom, dan standar fasilitas pembelajaran.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pelaksanaan: Operasionalisasi SIM Terpadu, Pemeliharaan Lab Komputer, & Pengelolaan Dana',
                'description' => 'Bukti ketersediaan dan utilisasi SIM (Akademik, SDM, Keuangan, Sarpras, SPMI), log kinerja server/jaringan, serta realisasi anggaran belanja operasional & investasi.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Evaluasi: Audit Tata Kelola TI, Audit Laporan Keuangan, & Survei Kepuasan Sarpras',
                'description' => 'Laporan audit sistem informasi/infrastruktur, laporan keuangan teraudit, serta hasil survei kepuasan mahasiswa & dosen terhadap keandalan lab komputer & sarpras.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Pengendalian: Mitigasi Risiko TI, Penanganan Temuan Audit Keuangan & Fasilitas',
                'description' => 'Tindak lanjut rekomendasi audit keuangan dan audit sistem informasi, disaster recovery plan, penanganan downtime sistem, serta perbaikan sarana perkuliahan.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Peningkatan: Modernisasi Infrastruktur Digital, Keamanan Siber, & Transparansi Tata Kelola',
                'description' => 'Peningkatan kapasitas server/cloud computing, penguatan standar keamanan informasi (ISO 27001), perluasan transparansi publik, dan efisiensi anggaran.',
                'sort_order' => 5,
            ],
        ]);

        // ── Kriteria 6: Diferensiasi Misi ──────────────────────────
        $m6 = Module::query()->updateOrCreate(
            ['sort_order' => 6],
            [
                'name' => 'Kriteria 6: Diferensiasi Misi',
                'description' => 'Keselarasan Visi, Misi, Tujuan, dan Strategi (VMTS) UPPS & PS, rencana strategis (Renstra), serta ciri khas keilmuan program studi.',
            ]
        );

        $this->seedRequirements($m6->id, [
            [
                'title' => 'Penetapan: Standar Keselarasan VMTS UPPS-PS, Dokumen Renstra, & Peta Ciri Khas PS',
                'description' => 'SK penetapan VMTS keilmuan infokom, dokumen Rencana Strategis (Renstra) 5 tahunan, penetapan indikator kinerja utama (IKU), dan rumusan diferensiasi keilmuan program studi.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pelaksanaan: Implementasi Rencana Operasional (Renop) & Sosialisasi Diferensiasi Misi',
                'description' => 'Bukti pelaksanaan program kerja tahunan selaras Renstra, dokumentasi sosialisasi VMTS kepada pemangku kepentingan internal & eksternal, dan perwujudan ciri khas keilmuan.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Evaluasi: Pengukuran Ketercapaian IKU/IKT Renstra & Efektivitas Diferensiasi Keilmuan',
                'description' => 'Laporan berkala ketercapaian target IKU dan IKT Renstra, analisis keunggulan komparatif program studi dibanding institusi lain, dan survei pemahaman visi-misi.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Pengendalian: Evaluasi Deviasi Target Renstra & Penyelarasan Rencana Aksi',
                'description' => 'Risalah rapat evaluasi capaian strategis tahunan, perumusan rekomendasi percepatan target indikator yang belum tercapai, dan penyesuaian rencana kerja tindak lanjut.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Peningkatan: Pemutakhiran Renstra Berkelanjutan & Penguatan Reputasi Keilmuan Spesifik',
                'description' => 'Revisi/reorientasi target Renstra berbasis perkembangan tren global teknologi infokom, rekognisi keunggulan keilmuan khas prodi di tingkat nasional maupun internasional.',
                'sort_order' => 5,
            ],
        ]);

        // ── Suplemen: Program Studi ────────────────────────────────
        $m7 = Module::query()->updateOrCreate(
            ['sort_order' => 7],
            [
                'name' => 'Suplemen: Program Studi',
                'description' => 'Sesuai rumpun keilmuan informatika dan komputer, mencakup RPS MK Inti, pemetaan kurikulum ACM/IEEE, dan Capstone Project.',
            ]
        );

        $this->seedRequirements($m7->id, [
            [
                'title' => 'Penetapan: Standar Kurikulum Bidang Komputasi (ACM/IEEE) & Panduan Capstone Project',
                'description' => 'Pedoman kurikulum berbasis panduan kurikulum internasional (ACM/IEEE CS/IS/SE) dan buku panduan tugas akhir berbasis proyek perancangan komprehensif (Capstone Project).',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pelaksanaan: Implementasi RPS Mata Kuliah Inti, Praktikum Laboratorium, & Capstone Project',
                'description' => 'Kumpulan RPS lengkap mata kuliah inti komputasi (Algoritma, Basis Data, Jaringan, Rekayasa Perangkat Lunak, AI, dll.), modul praktikum, dan dokumentasi bimbingan capstone.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Evaluasi: Asesmen Body of Knowledge (BoK) Komputasi & Portofolio Hasil Capstone Project',
                'description' => 'Laporan pemetaan capaian materi terhadap BoK kurikulum internasional, rubrik asesmen capstone project, portofolio karya perangkat lunak/aplikasi mahasiswa, dan evaluasi mitra penguji.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Pengendalian: Tindak Lanjut Asesmen Capstone & Penyesuaian Materi MK Inti Komputasi',
                'description' => 'Tindakan korektif materi perkuliahan berdasarkan hasil penilaian karya capstone, penyelarasan beban tugas proyek, dan feedback dari praktisi industri penguji.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Peningkatan: Pemutakhiran Silabus MK Komputasi Terkini & Sertifikasi Kompetensi Internasional',
                'description' => 'Pembaruan materi silabus dengan teknologi komputasi mutakhir (Cloud native, AI generatif, Cybersecurity terkini) dan fasilitasi sertifikasi profesi internasional mahasiswa/dosen.',
                'sort_order' => 5,
            ],
        ]);

        // Bersihkan modul sort_order > 7 jika ada yang tidak lagi memiliki berkas
        $excessModules = Module::query()->where('sort_order', '>', 7)->get();
        foreach ($excessModules as $exMod) {
            $reqIds = Requirement::query()->where('module_id', $exMod->id)->pluck('id');
            $hasSubmissions = Submission::query()->whereIn('requirement_id', $reqIds)->exists();

            if (! $hasSubmissions) {
                Requirement::query()->where('module_id', $exMod->id)->delete();
                $exMod->delete();
            }
        }
    }

    private function seedRequirements(int $moduleId, array $rows): void
    {
        foreach ($rows as $row) {
            Requirement::query()->updateOrCreate(
                [
                    'module_id'  => $moduleId,
                    'sort_order' => $row['sort_order'],
                ],
                [
                    'title'       => $row['title'],
                    'description' => $row['description'] ?? null,
                ]
            );
        }
    }
}
