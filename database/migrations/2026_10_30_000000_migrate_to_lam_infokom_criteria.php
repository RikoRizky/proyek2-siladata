<?php

use App\Models\Module;
use App\Models\Requirement;
use App\Models\Submission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Data master 6 Kriteria Utama LAM-INFOKOM 2.1 (Tahun 2025) plus Suplemen Program Studi.
     */
    protected array $criteriaData = [
        1 => [
            'name' => 'Kriteria 1: Budaya Mutu',
            'description' => 'Sistem tata kelola internal UPPS/PT, SOP administrasi/keuangan/SDM, dan fungsi penjaminan mutu SPMI.',
            'requirements' => [
                1 => [
                    'title' => 'Penetapan: Standar Tata Kelola & Sistem Penjaminan Mutu Internal (SPMI)',
                    'description' => 'Dokumen penetapan standar tata pamong, pedoman SPMI, kode etik, tupoksi organ pengelola, dan kebijakan resmi penjaminan mutu UPPS/PS.',
                ],
                2 => [
                    'title' => 'Pelaksanaan: Implementasi Tata Pamong, SOP Administrasi/Keuangan/SDM, & Siklus SPMI',
                    'description' => 'Bukti pelaksanaan operasional harian, penerapan SOP administrasi/keuangan/SDM, berita acara rapat tata pamong, dan bukti terlaksananya siklus SPMI.',
                ],
                3 => [
                    'title' => 'Evaluasi: Audit Mutu Internal (AMI) & Evaluasi Ketercapaian Standar Tata Kelola',
                    'description' => 'Laporan hasil AMI tahunan, survei kepuasan pemangku kepentingan terhadap layanan tata kelola dan SDM, serta analisis gap ketercapaian SPMI.',
                ],
                4 => [
                    'title' => 'Pengendalian: Rapat Tinjauan Manajemen (RTM) & Tindakan Korektif Tata Kelola',
                    'description' => 'Notulen & risalah RTM, dokumen tindakan korektif dan pencegahan (CAPA), serta rekap penanganan temuan audit tata pamong.',
                ],
                5 => [
                    'title' => 'Peningkatan: Peningkatan Standar Mutu Berkelanjutan & Benchmarking Tata Kelola',
                    'description' => 'Bukti pembaruan standar mutu lebih tinggi (benchmarking), inovasi mekanisme tata kelola, dan sertifikasi sistem mutu (ISO/akreditasi internasional).',
                ],
            ],
        ],
        2 => [
            'name' => 'Kriteria 2: Relevansi Pendidikan',
            'description' => 'Penerimaan mahasiswa (akses/afirmasi), kurikulum Outcome-Based Education (OBE), fleksibilitas belajar (RPL/micro-credentials), dan mutu lulusan/tracer study.',
            'requirements' => [
                1 => [
                    'title' => 'Penetapan: Standar Penerimaan Mahasiswa, Kurikulum OBE, & Kelulusan',
                    'description' => 'Kebijakan seleksi mahasiswa baru (akses/afirmasi), pedoman kurikulum berbasis OBE, pemetaan CPL, aturan RPL & micro-credentials, serta standar kelulusan.',
                ],
                2 => [
                    'title' => 'Pelaksanaan: Pembelajaran OBE, Fleksibilitas Belajar, & Layanan Mahasiswa',
                    'description' => 'Bukti implementasi kurikulum OBE (RPS, asesmen CPL), pelaksanaan program MBKM/RPL/micro-credentials, serta bimbingan akademik dan kemahasiswaan.',
                ],
                3 => [
                    'title' => 'Evaluasi: Evaluasi Ketercapaian CPL, Masa Studi, & Tracer Study Lulusan',
                    'description' => 'Laporan portofolio asesmen CPL berkala, evaluasi IPK & masa studi, laporan tracer study (waktu tunggu, relevansi bidang kerja), dan survei kepuasan pengguna lulusan.',
                ],
                4 => [
                    'title' => 'Pengendalian: Pengendalian Mutu Pembelajaran & Tindak Lanjut Evaluasi Lulusan',
                    'description' => 'Tindakan korektif terhadap kendala capaian CPL, tindak lanjut masukan tracer study/mitra industri, dan penyesuaian proses perkuliahan.',
                ],
                5 => [
                    'title' => 'Peningkatan: Rekonstruksi Kurikulum OBE Berkelanjutan & Peningkatan Kompetensi Lulusan',
                    'description' => 'Bukti pembaruan kurikulum berbasis masukan asosiasi profesi komputasi/industri, sertifikasi kompetensi lulusan, dan peningkatan capaian mutu pendidikan.',
                ],
            ],
        ],
        3 => [
            'name' => 'Kriteria 3: Relevansi Penelitian',
            'description' => 'Sarpras riset, pembiayaan, roadmap penelitian DTPR & mahasiswa, kolaborasi riset, publikasi jurnal, dan HKI.',
            'requirements' => [
                1 => [
                    'title' => 'Penetapan: Roadmap Penelitian DTPR & Mahasiswa, Standar Sarpras & Pendanaan Riset',
                    'description' => 'Dokumen roadmap penelitian berjangka prodi/UPPS, pedoman skema hibah riset, standar sarana lab penelitian, serta pedoman keterlibatan mahasiswa dalam riset.',
                ],
                2 => [
                    'title' => 'Pelaksanaan: Kegiatan Riset Kolaboratif, Realisasi Pendanaan, & Penulisan Luaran',
                    'description' => 'Kontrak/laporan pelaksanaan penelitian dosen dan mahasiswa, bukti MoU/MoA kolaborasi riset nasional/internasional, dan utilisasi fasilitas lab riset.',
                ],
                3 => [
                    'title' => 'Evaluasi: Evaluasi Ketercapaian Roadmap Penelitian, Publikasi Jurnal, & HKI',
                    'description' => 'Laporan evaluasi luaran riset (publikasi jurnal terakreditasi/internasional bereputasi, prosiding, sitasi, paten/hak cipta), serta rasio produktivitas riset DTPR.',
                ],
                4 => [
                    'title' => 'Pengendalian: Pengendalian Mutu Penelitian & Mitigasi Keterlambatan Luaran',
                    'description' => 'Monitoring berkala kemajuan riset, rekap kendala publikasi/HKI, evaluasi kepatuhan terhadap roadmap penelitian, dan corrective actions penjaminan mutu riset.',
                ],
                5 => [
                    'title' => 'Peningkatan: Peningkatan Kerjasama Riset Internasional & Hilirisasi Hasil Penelitian',
                    'description' => 'Peningkatan target publikasi pada jurnal bereputasi tinggi, komersialisasi/hilirisasi prototipe riset bidang teknologi informasi, dan perluasan jejaring riset.',
                ],
            ],
        ],
        4 => [
            'name' => 'Kriteria 4: Relevansi Pengabdian kepada Masyarakat',
            'description' => 'Sarpras PkM, pembiayaan, roadmap PkM teknologi tepat guna, adopsi masyarakat/DUDIKA, diseminasi, dan HKI PkM.',
            'requirements' => [
                1 => [
                    'title' => 'Penetapan: Roadmap PkM Teknologi Tepat Guna, Standar Sarpras & Pendanaan PkM',
                    'description' => 'Roadmap PkM berbasis penyelesaian masalah masyarakat/DUDIKA, pedoman pendanaan PkM, panduan penerapan teknologi tepat guna (TTG) infokom, dan pelibatan mahasiswa.',
                ],
                2 => [
                    'title' => 'Pelaksanaan: Implementasi PkM Bersama Mitra/DUDIKA & Diseminasi Solusi Digital',
                    'description' => 'Bukti pelaksanaan program PkM lapangan, pelatihan/pendampingan teknologi digital, MoA/surat tugas pengabdian, dan implementasi teknologi di masyarakat mitra.',
                ],
                3 => [
                    'title' => 'Evaluasi: Evaluasi Dampak/Adopsi Teknologi oleh Mitra, Publikasi, & HKI PkM',
                    'description' => 'Laporan kepuasan mitra dan tingkat adopsi solusi teknologi infokom oleh masyarakat/DUDIKA, artikel jurnal pengabdian, hak cipta modul, dan evaluasi dampak.',
                ],
                4 => [
                    'title' => 'Pengendalian: Pengendalian Keberlanjutan PkM & Penanganan Kendala Mitra',
                    'description' => 'Tindak lanjut hasil evaluasi kepuasan mitra, perbaikan sistem pendampingan, serta penanganan kendala operasional penerapan teknologi oleh masyarakat mitra.',
                ],
                5 => [
                    'title' => 'Peningkatan: Pengembangan Kemitraan Strategis Berkelanjutan & Replikasi Solusi TTG',
                    'description' => 'Peningkatan skala kemitraan dengan DUDIKA/pemerintah daerah, replikasi produk PkM ke wilayah binaan lebih luas, dan pembaruan standar capaian PkM.',
                ],
            ],
        ],
        5 => [
            'name' => 'Kriteria 5: Akuntabilitas',
            'description' => 'Sistem informasi tata kelola otonom yang transparan (SIM Akademik, Keuangan, SDM, Sarpras, SPMI), audit mutu, dan kecukupan sarpras pembelajaran.',
            'requirements' => [
                1 => [
                    'title' => 'Penetapan: Standar SIM Terpadu, Tata Kelola Otonom, & Alokasi Anggaran Sarpras',
                    'description' => 'Kebijakan operasional SIM terintegrasi, standar kecukupan bandwidth & keamanan data, aturan tata kelola keuangan otonom, dan standar fasilitas pembelajaran.',
                ],
                2 => [
                    'title' => 'Pelaksanaan: Operasionalisasi SIM Terpadu, Pemeliharaan Lab Komputer, & Pengelolaan Dana',
                    'description' => 'Bukti ketersediaan dan utilisasi SIM (Akademik, SDM, Keuangan, Sarpras, SPMI), log kinerja server/jaringan, serta realisasi anggaran belanja operasional & investasi.',
                ],
                3 => [
                    'title' => 'Evaluasi: Audit Tata Kelola TI, Audit Laporan Keuangan, & Survei Kepuasan Sarpras',
                    'description' => 'Laporan audit sistem informasi/infrastruktur, laporan keuangan teraudit, serta hasil survei kepuasan mahasiswa & dosen terhadap keandalan lab komputer & sarpras.',
                ],
                4 => [
                    'title' => 'Pengendalian: Mitigasi Risiko TI, Penanganan Temuan Audit Keuangan & Fasilitas',
                    'description' => 'Tindak lanjut rekomendasi audit keuangan dan audit sistem informasi, disaster recovery plan, penanganan downtime sistem, serta perbaikan sarana perkuliahan.',
                ],
                5 => [
                    'title' => 'Peningkatan: Modernisasi Infrastruktur Digital, Keamanan Siber, & Transparansi Tata Kelola',
                    'description' => 'Peningkatan kapasitas server/cloud computing, penguatan standar keamanan informasi (ISO 27001), perluasan transparansi publik, dan efisiensi anggaran.',
                ],
            ],
        ],
        6 => [
            'name' => 'Kriteria 6: Diferensiasi Misi',
            'description' => 'Keselarasan Visi, Misi, Tujuan, dan Strategi (VMTS) UPPS & PS, rencana strategis (Renstra), serta ciri khas keilmuan program studi.',
            'requirements' => [
                1 => [
                    'title' => 'Penetapan: Standar Keselarasan VMTS UPPS-PS, Dokumen Renstra, & Peta Ciri Khas PS',
                    'description' => 'SK penetapan VMTS keilmuan infokom, dokumen Rencana Strategis (Renstra) 5 tahunan, penetapan indikator kinerja utama (IKU), dan rumusan diferensiasi keilmuan program studi.',
                ],
                2 => [
                    'title' => 'Pelaksanaan: Implementasi Rencana Operasional (Renop) & Sosialisasi Diferensiasi Misi',
                    'description' => 'Bukti pelaksanaan program kerja tahunan selaras Renstra, dokumentasi sosialisasi VMTS kepada pemangku kepentingan internal & eksternal, dan perwujudan ciri khas keilmuan.',
                ],
                3 => [
                    'title' => 'Evaluasi: Pengukuran Ketercapaian IKU/IKT Renstra & Efektivitas Diferensiasi Keilmuan',
                    'description' => 'Laporan berkala ketercapaian target IKU dan IKT Renstra, analisis keunggulan komparatif program studi dibanding institusi lain, dan survei pemahaman visi-misi.',
                ],
                4 => [
                    'title' => 'Pengendalian: Evaluasi Deviasi Target Renstra & Penyelarasan Rencana Aksi',
                    'description' => 'Risalah rapat evaluasi capaian strategis tahunan, perumusan rekomendasi percepatan target indikator yang belum tercapai, dan penyesuaian rencana kerja tindak lanjut.',
                ],
                5 => [
                    'title' => 'Peningkatan: Pemutakhiran Renstra Berkelanjutan & Penguatan Reputasi Keilmuan Spesifik',
                    'description' => 'Revisi/reorientasi target Renstra berbasis perkembangan tren global teknologi infokom, rekognisi keunggulan keilmuan khas prodi di tingkat nasional maupun internasional.',
                ],
            ],
        ],
        7 => [
            'name' => 'Suplemen: Program Studi',
            'description' => 'Sesuai rumpun keilmuan informatika dan komputer, mencakup RPS MK Inti, pemetaan kurikulum ACM/IEEE, dan Capstone Project.',
            'requirements' => [
                1 => [
                    'title' => 'Penetapan: Standar Kurikulum Bidang Komputasi (ACM/IEEE) & Panduan Capstone Project',
                    'description' => 'Pedoman kurikulum berbasis panduan kurikulum internasional (ACM/IEEE CS/IS/SE) dan buku panduan tugas akhir berbasis proyek perancangan komprehensif (Capstone Project).',
                ],
                2 => [
                    'title' => 'Pelaksanaan: Implementasi RPS Mata Kuliah Inti, Praktikum Laboratorium, & Capstone Project',
                    'description' => 'Kumpulan RPS lengkap mata kuliah inti komputasi (Algoritma, Basis Data, Jaringan, Rekayasa Perangkat Lunak, AI, dll.), modul praktikum, dan dokumentasi bimbingan capstone.',
                ],
                3 => [
                    'title' => 'Evaluasi: Asesmen Body of Knowledge (BoK) Komputasi & Portofolio Hasil Capstone Project',
                    'description' => 'Laporan pemetaan capaian materi terhadap BoK kurikulum internasional, rubrik asesmen capstone project, portofolio karya perangkat lunak/aplikasi mahasiswa, dan evaluasi mitra penguji.',
                ],
                4 => [
                    'title' => 'Pengendalian: Tindak Lanjut Asesmen Capstone & Penyesuaian Materi MK Inti Komputasi',
                    'description' => 'Tindakan korektif materi perkuliahan berdasarkan hasil penilaian karya capstone, penyelarasan beban tugas proyek, dan feedback dari praktisi industri penguji.',
                ],
                5 => [
                    'title' => 'Peningkatan: Pemutakhiran Silabus MK Komputasi Terkini & Sertifikasi Kompetensi Internasional',
                    'description' => 'Pembaruan materi silabus dengan teknologi komputasi mutakhir (Cloud native, AI generatif, Cybersecurity terkini) dan fasilitasi sertifikasi profesi internasional mahasiswa/dosen.',
                ],
            ],
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function () {
            // 1. Update atau insert modul 1 sampai 7 beserta requirements-nya
            foreach ($this->criteriaData as $sortOrder => $cData) {
                $module = Module::query()->where('sort_order', $sortOrder)->first();

                if ($module) {
                    $module->update([
                        'name' => $cData['name'],
                        'description' => $cData['description'],
                    ]);
                } else {
                    $module = Module::query()->create([
                        'name' => $cData['name'],
                        'description' => $cData['description'],
                        'sort_order' => $sortOrder,
                    ]);
                }

                // Update / create requirements (1 s.d 5 PPEPP) tanpa menghapus ID yang sudah ada
                foreach ($cData['requirements'] as $reqSort => $rData) {
                    $req = Requirement::query()
                        ->where('module_id', $module->id)
                        ->where('sort_order', $reqSort)
                        ->first();

                    if ($req) {
                        $req->update([
                            'title' => $rData['title'],
                            'description' => $rData['description'],
                        ]);
                    } else {
                        Requirement::query()->create([
                            'module_id' => $module->id,
                            'title' => $rData['title'],
                            'description' => $rData['description'],
                            'sort_order' => $reqSort,
                        ]);
                    }
                }
            }

            // 2. Migrasi riwayat berkas dari Modul lama (Modul 8 & 9) jika ada ke Modul baru
            // Modul 8 lama (Pengabdian) -> Modul 4 baru (PkM)
            $oldM8 = Module::query()->where('sort_order', 8)->first();
            $newM4 = Module::query()->where('sort_order', 4)->first();
            if ($oldM8 && $newM4) {
                $this->transferSubmissionsBetweenModules($oldM8, $newM4);
            }

            // Modul 9 lama (Luaran & Capaian) -> Modul 2 baru (Relevansi Pendidikan / CPL & Tracer)
            $oldM9 = Module::query()->where('sort_order', 9)->first();
            $newM2 = Module::query()->where('sort_order', 2)->first();
            if ($oldM9 && $newM2) {
                $this->transferSubmissionsBetweenModules($oldM9, $newM2);
            }

            // 3. Bersihkan modul > 7 yang sudah kosong (tidak ada submission yang tertinggal)
            $excessModules = Module::query()->where('sort_order', '>', 7)->get();
            foreach ($excessModules as $exMod) {
                $reqIds = Requirement::query()->where('module_id', $exMod->id)->pluck('id');
                $hasSubmissions = Submission::query()->whereIn('requirement_id', $reqIds)->exists();

                if (! $hasSubmissions) {
                    Requirement::query()->where('module_id', $exMod->id)->delete();
                    $exMod->delete();
                }
            }
        });
    }

    /**
     * Memindahkan data submission dari modul sumber ke modul target berdasarkan PPEPP sort_order.
     */
    protected function transferSubmissionsBetweenModules(Module $sourceModule, Module $targetModule): void
    {
        $sourceReqs = Requirement::query()->where('module_id', $sourceModule->id)->get()->keyBy('sort_order');
        $targetReqs = Requirement::query()->where('module_id', $targetModule->id)->get()->keyBy('sort_order');

        foreach ($sourceReqs as $sortOrder => $sReq) {
            $tReq = $targetReqs->get($sortOrder);
            if (! $tReq) {
                continue;
            }

            // Ambil semua submission dari requirement sumber
            $submissions = Submission::query()->where('requirement_id', $sReq->id)->get();
            foreach ($submissions as $sub) {
                // Cek apakah target sudah memiliki submission untuk user & version ini
                $existingInTarget = Submission::query()
                    ->where('requirement_id', $tReq->id)
                    ->where('user_id', $sub->user_id)
                    ->where('version', $sub->version)
                    ->exists();

                if (! $existingInTarget) {
                    $sub->update(['requirement_id' => $tReq->id]);
                } else {
                    // Beri versi berikutnya agar tidak konflik dengan composite unique key
                    $maxVersion = Submission::query()
                        ->where('requirement_id', $tReq->id)
                        ->where('user_id', $sub->user_id)
                        ->max('version') ?? 1;

                    $sub->update([
                        'requirement_id' => $tReq->id,
                        'version' => $maxVersion + 1,
                        'is_latest' => false,
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations (revert back to 9 BAN-PT standard if needed).
     */
    public function down(): void
    {
        // Revert dapat dilakukan jika pengembang ingin mengembalikan struktur awal 9 kriteria
    }
};

