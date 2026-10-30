<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'description',
        'sort_order',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Mengambil metadata siklus mutu PPEPP berdasarkan sort_order (1 s.d 5).
     *
     * @return array{
     *     code: string,
     *     name: string,
     *     subtext: string,
     *     badge_class: string,
     *     border_class: string,
     *     dot_class: string,
     *     accent_color: string,
     *     step_number: int
     * }
     */
    public function ppeppStage(): array
    {
        return match ((int) $this->sort_order) {
            1 => [
                'code'         => 'P1',
                'name'         => 'Penetapan',
                'subtext'      => 'Standar, SK, Peraturan & Roadmap',
                'badge_class'  => 'bg-sky-50 text-sky-700 border-sky-200/80 ring-sky-500/10',
                'border_class' => 'border-sky-200',
                'dot_class'    => 'bg-sky-500',
                'accent_color' => '#0284c7',
                'step_number'  => 1,
            ],
            2 => [
                'code'         => 'P2',
                'name'         => 'Pelaksanaan',
                'subtext'      => 'Laporan Kegiatan, MoA & Eksekusi',
                'badge_class'  => 'bg-violet-50 text-violet-700 border-violet-200/80 ring-violet-500/10',
                'border_class' => 'border-violet-200',
                'dot_class'    => 'bg-violet-500',
                'accent_color' => '#7c3aed',
                'step_number'  => 2,
            ],
            3 => [
                'code'         => 'E',
                'name'         => 'Evaluasi',
                'subtext'      => 'Audit Mutu, Tracer & Survei Kepuasan',
                'badge_class'  => 'bg-amber-50 text-amber-800 border-amber-200/80 ring-amber-500/10',
                'border_class' => 'border-amber-200',
                'dot_class'    => 'bg-amber-500',
                'accent_color' => '#d97706',
                'step_number'  => 3,
            ],
            4 => [
                'code'         => 'P3',
                'name'         => 'Pengendalian',
                'subtext'      => 'Rapat Tinjauan Manajemen (RTM) & Koreksi',
                'badge_class'  => 'bg-rose-50 text-rose-700 border-rose-200/80 ring-rose-500/10',
                'border_class' => 'border-rose-200',
                'dot_class'    => 'bg-rose-500',
                'accent_color' => '#e11d48',
                'step_number'  => 4,
            ],
            5 => [
                'code'         => 'P4',
                'name'         => 'Peningkatan',
                'subtext'      => 'Benchmarking & Revisi Standar Unggul',
                'badge_class'  => 'bg-emerald-50 text-emerald-700 border-emerald-200/80 ring-emerald-500/10',
                'border_class' => 'border-emerald-200',
                'dot_class'    => 'bg-emerald-500',
                'accent_color' => '#059669',
                'step_number'  => 5,
            ],
            default => [
                'code'         => 'D',
                'name'         => 'Dokumen Pendukung',
                'subtext'      => 'Kelengkapan Berkas Akreditasi',
                'badge_class'  => 'bg-slate-50 text-slate-700 border-slate-200 ring-slate-500/10',
                'border_class' => 'border-slate-200',
                'dot_class'    => 'bg-slate-500',
                'accent_color' => '#64748b',
                'step_number'  => (int) $this->sort_order,
            ],
        };
    }

    /**
     * Mengambil judul inti tanpa awalan 'Penetapan: ', 'Pelaksanaan: ', dst jika ada.
     */
    public function titleWithoutStage(): string
    {
        if (preg_match('/^(Penetapan|Pelaksanaan|Evaluasi|Pengendalian|Peningkatan):\s*(.+)$/i', $this->title, $matches)) {
            return $matches[2];
        }

        return $this->title;
    }
}
