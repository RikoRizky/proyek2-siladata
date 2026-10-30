<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sort_order',
    ];

    public function requirements(): HasMany
    {
        return $this->hasMany(Requirement::class)->orderBy('sort_order');
    }

    public function shortLabel(): string
    {
        if (preg_match('/^(Kriteria \d+)/i', $this->name, $matches)) {
            return $matches[1];
        }

        if (stripos($this->name, 'Suplemen') !== false) {
            return 'Suplemen PS';
        }

        return Str::limit($this->name, 32);
    }

    public function subTitle(): string
    {
        if (str_contains($this->name, ': ')) {
            return Str::after($this->name, ': ');
        }

        return $this->name;
    }

    public function isSuplemen(): bool
    {
        return stripos($this->name, 'Suplemen') !== false;
    }

    public function standardCategory(): string
    {
        return $this->isSuplemen()
            ? 'Suplemen Program Studi (Infokom)'
            : '6 Kriteria Utama LAM-INFOKOM 2.1 (2025)';
    }

    /**
     * Daftar tabel data kuantitatif LKPS LAM-INFOKOM 2.1 yang relevan untuk kriteria ini.
     *
     * @return array<int, array{code: string, name: string, category: string, desc: string}>
     */
    public function lkpsTables(): array
    {
        return match ((int) $this->sort_order) {
            1 => [
                [
                    'code' => 'Tabel 1.1',
                    'name' => 'Tata Kelola, Kepemimpinan, & Sistem Penjaminan Mutu Internal (SPMI)',
                    'category' => 'Tata Kelola & SPMI',
                    'desc' => 'Struktur organisasi, implementasi SOP, ketersediaan organ pengelola, dan siklus SPMI UPPS/PS.',
                ],
                [
                    'code' => 'Tabel 1.2',
                    'name' => 'Keterlaksanaan Audit Mutu Internal (AMI) & Tindak Lanjut RTM',
                    'category' => 'Audit & Evaluasi Mutu',
                    'desc' => 'Rekap audit berkala, temuan ketidaksesuaian, dan notulen rapat tinjauan manajemen.',
                ],
            ],
            2 => [
                [
                    'code' => 'Tabel 2.1',
                    'name' => 'Data Mahasiswa: Daya Tampung, Pendaftar, & Seleksi (TS-4 s.d TS)',
                    'category' => 'Input Mahasiswa',
                    'desc' => 'Statistik animo pendaftar, rasio keketatan, pendaftar jalur afirmasi/aksesibilitas, dan registrasi baru.',
                ],
                [
                    'code' => 'Tabel 2.2',
                    'name' => 'Profil & Ekuivalensi Waktu Mengajar Penuh (EWMP) DTPR',
                    'category' => 'DTPR & EWMP',
                    'desc' => 'Daftar dosen tetap prodi (DTPR), kualifikasi S3/jabatan fungsional, dan beban kerja tridharma SKS.',
                ],
                [
                    'code' => 'Tabel 2.3',
                    'name' => 'Struktur Kurikulum Outcome-Based Education (OBE) & RPS MK Inti',
                    'category' => 'Kurikulum OBE',
                    'desc' => 'Pemetaan CPL, silabus, RPS mata kuliah inti komputasi, dan metode pembelajaran interaktif.',
                ],
                [
                    'code' => 'Tabel 2.4',
                    'name' => 'Fleksibilitas Belajar: MBKM, Rekognisi Pembelajaran Lampau (RPL), & Micro-credentials',
                    'category' => 'Fleksibilitas Kurikulum',
                    'desc' => 'Rekap mahasiswa mengikuti magang/studi independen industri, konversi SKS, dan modul sertifikasi mikro.',
                ],
                [
                    'code' => 'Tabel 2.5',
                    'name' => 'Masa Studi, IPK Lulusan, & Tracer Study (Waktu Tunggu Kerja)',
                    'category' => 'Luaran & Tracer Study',
                    'desc' => 'Rata-rata IPK, persentase kelulusan tepat waktu, masa tunggu lulusan < 6 bulan, dan relevansi bidang kerja.',
                ],
                [
                    'code' => 'Tabel 2.6',
                    'name' => 'Tingkat Kepuasan Pengguna Lulusan & Mitra Industri',
                    'category' => 'Kepuasan Pengguna',
                    'desc' => 'Survei kepuasan atasan/pengguna lulusan terhadap etika, keahlian teknis (hard skills), dan soft skills.',
                ],
            ],
            3 => [
                [
                    'code' => 'Tabel 3.1',
                    'name' => 'Sarana & Prasarana Laboratorium Riset Komputasi',
                    'category' => 'Fasilitas Riset',
                    'desc' => 'Ketersediaan laboratorium komputasi khusus, server GPU riset, dan perangkat pendukung riset DTPR.',
                ],
                [
                    'code' => 'Tabel 3.2',
                    'name' => 'Aktivitas & Alokasi Pembiayaan Penelitian DTPR & Mahasiswa',
                    'category' => 'Pendanaan Riset',
                    'desc' => 'Pendanaan riset internal institusi, hibah kementerian/DRTPM, dan kerjasama pendanaan riset industri.',
                ],
                [
                    'code' => 'Tabel 3.3',
                    'name' => 'Roadmap & Kerjasama Penelitian Nasional / Internasional',
                    'category' => 'Roadmap & Kolaborasi',
                    'desc' => 'Pohon riset/payung penelitian dosen yang melibatkan mahasiswa, MoU/MoA riset, dan mitra kolaborasi.',
                ],
                [
                    'code' => 'Tabel 3.4',
                    'name' => 'Publikasi Ilmiah Jurnal Bereputasi & Prosiding Konferensi',
                    'category' => 'Publikasi Ilmiah',
                    'desc' => 'Artikel ilmiah di jurnal internasional terindeks Scopus/WoS, jurnal nasional SINTA 1-6, dan IEEE/ACM conferences.',
                ],
                [
                    'code' => 'Tabel 3.5',
                    'name' => 'Perolehan Hak Kekayaan Intelektual (Paten / Hak Cipta Perangkat Lunak)',
                    'category' => 'HKI & Produk Riset',
                    'desc' => 'Pencatatan hak cipta software/aplikasi, paten terdaftar/granted, serta rekognisi teknologi dari DTPR.',
                ],
            ],
            4 => [
                [
                    'code' => 'Tabel 4.1',
                    'name' => 'Sarana, Prasarana, & Pembiayaan Pengabdian kepada Masyarakat (PkM)',
                    'category' => 'Pendanaan PkM',
                    'desc' => 'Alokasi anggaran PkM institusi, hibah kemitraan masyarakat, dan fasilitas pendukung penerapan teknologi.',
                ],
                [
                    'code' => 'Tabel 4.2',
                    'name' => 'Roadmap Pengabdian Berbasis Teknologi Tepat Guna (TTG) Infokom',
                    'category' => 'Roadmap TTG',
                    'desc' => 'Kesesuaian roadmap PkM dengan keahlian prodi dan kebutuhan riil masyarakat lokal/UMKM/desa binaan.',
                ],
                [
                    'code' => 'Tabel 4.3',
                    'name' => 'Tingkat Adopsi Solusi Teknologi oleh Masyarakat / Mitra DUDIKA',
                    'category' => 'Adopsi Teknologi',
                    'desc' => 'Bukti operasionalisasi produk TI/aplikasi yang digunakan dan dirasakan manfaatnya oleh mitra masyarakat.',
                ],
                [
                    'code' => 'Tabel 4.4',
                    'name' => 'Diseminasi, Publikasi Hasil PkM, & HKI Pengabdian',
                    'category' => 'Luaran PkM',
                    'desc' => 'Jurnal pengabdian kepada masyarakat, publikasi media massa, hak cipta modul panduan, dan video diseminasi.',
                ],
            ],
            5 => [
                [
                    'code' => 'Tabel 5.1',
                    'name' => 'Sistem Informasi Manajemen Terpadu (SIM Akademik, Keuangan, SDM, Sarpras, SPMI)',
                    'category' => 'SIM Terpadu',
                    'desc' => 'Aksesibilitas dan integrasi data antar modul sistem informasi operasional universitas dan prodi.',
                ],
                [
                    'code' => 'Tabel 5.2',
                    'name' => 'Kecukupan Bandwidth, Infrastruktur Jaringan, Server & Fasilitas Cloud',
                    'category' => 'Infrastruktur TI',
                    'desc' => 'Rasio bandwidth per mahasiswa, uptime jaringan kampus, sistem backup/disaster recovery, dan lisensi software.',
                ],
                [
                    'code' => 'Tabel 5.3',
                    'name' => 'Realisasi Anggaran Operasional, Pemeliharaan, & Investasi Pembelajaran',
                    'category' => 'Pengelolaan Keuangan',
                    'desc' => 'Rekapitulasi biaya operasional pendidikan per mahasiswa per tahun, belanja modal lab, dan dana pengembangan.',
                ],
                [
                    'code' => 'Tabel 5.4',
                    'name' => 'Laporan Audit Eksternal Keuangan & Audit Tata Kelola TI',
                    'category' => 'Audit & Akuntabilitas',
                    'desc' => 'Opini akuntan publik terhadap laporan keuangan (WTP), sertifikasi ISO 27001/audit keamanan siber.',
                ],
            ],
            6 => [
                [
                    'code' => 'Tabel 6.1',
                    'name' => 'Keselarasan VMTS UPPS dan Program Studi',
                    'category' => 'Keselarasan VMTS',
                    'desc' => 'Pohon penurunan visi, misi, dan tujuan dari perguruan tinggi ke UPPS hingga ke program studi komputasi.',
                ],
                [
                    'code' => 'Tabel 6.2',
                    'name' => 'Pencapaian Indikator Kinerja Utama (IKU) & Target Rencana Strategis (Renstra)',
                    'category' => 'Capaian Renstra',
                    'desc' => 'Tabel realisasi capaian IKU tahunan terhadap target Renstra 5 tahunan prodi infokom.',
                ],
                [
                    'code' => 'Tabel 6.3',
                    'name' => 'Ciri Khas Keilmuan & Profil Pembeda Lulusan Bidang Komputasi',
                    'category' => 'Diferensiasi Misi',
                    'desc' => 'Kekhasan profil lulusan prodi (mis. keunggulan logistik cerdas, data science terapan, keamanan jaringan industri).',
                ],
            ],
            default => [
                [
                    'code' => 'Tabel 7.1',
                    'name' => 'Pemetaan Body of Knowledge (BoK) Kurikulum ACM / IEEE (CS / IS / SE)',
                    'category' => 'Kurikulum Komputasi',
                    'desc' => 'Kesesuaian kurikulum prodi dengan standar kurikulum internasional bidang Computing Curricula ACM/IEEE.',
                ],
                [
                    'code' => 'Tabel 7.2',
                    'name' => 'Portofolio RPS Mata Kuliah Inti Bidang Komputasi',
                    'category' => 'RPS MK Inti',
                    'desc' => 'Koleksi RPS lengkap mata kuliah wajib komputasi dengan asesmen berbasis rubrik CPL yang terukur.',
                ],
                [
                    'code' => 'Tabel 7.3',
                    'name' => 'Pelaksanaan & Portofolio Hasil Proyek Perancangan Terintegrasi (Capstone Project)',
                    'category' => 'Capstone Project',
                    'desc' => 'Dokumentasi proyek capstone mahasiswa: tim multidisiplin, produk aplikasi utuh, buku pedoman, dan rubrik penilaian industri.',
                ],
                [
                    'code' => 'Tabel 7.4',
                    'name' => 'Sertifikasi Kompetensi Industri / Internasional Mahasiswa & Dosen',
                    'category' => 'Sertifikasi Profesi',
                    'desc' => 'Perolehan sertifikasi BNSP / vendor industri global (Cisco, AWS, Google, Oracle, Microsoft, RedHat, dll.).',
                ],
            ],
        };
    }
}
