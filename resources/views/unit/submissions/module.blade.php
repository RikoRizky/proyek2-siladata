<x-app-layout>
    @php
        $uploadedCount = $module->requirements->filter(fn ($req) => $req->submissions->first() && $req->submissions->first()->status !== \App\Enums\SubmissionStatus::Pending)->count();
        $approvedCount = $module->requirements->filter(fn ($req) => $req->submissions->first() && $req->submissions->first()->status === \App\Enums\SubmissionStatus::Approved)->count();
        $revisionCount = $module->requirements->filter(fn ($req) => $req->submissions->first() && $req->submissions->first()->status === \App\Enums\SubmissionStatus::Revision)->count();
        $pendingCount  = $module->requirements->filter(fn ($req) => $req->submissions->first() && $req->submissions->first()->status === \App\Enums\SubmissionStatus::Uploaded)->count();
        $totalCount    = $module->requirements->count();
        $progressPercent = $totalCount > 0 ? round(($uploadedCount / $totalCount) * 100) : 0;

        $allModules = \App\Models\Module::query()->orderBy('sort_order')->get();
    @endphp

    <x-slot name="header">
        <div class="space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-extrabold uppercase tracking-wider {{ $module->isSuplemen() ? 'bg-amber-100 text-amber-900 border border-amber-200' : 'bg-violet-100 text-violet-800 border border-violet-200' }}">
                        <span class="h-2 w-2 rounded-full {{ $module->isSuplemen() ? 'bg-amber-500' : 'bg-violet-600' }}"></span>
                        {{ $module->standardCategory() }}
                    </span>
                    <span class="text-xs font-semibold text-slate-400">·</span>
                    <span class="text-xs font-semibold text-slate-500">Siklus PPEPP</span>
                </div>

                {{-- Status ringkasan badge --}}
                <div class="flex flex-wrap items-center gap-2">
                    @if ($revisionCount > 0)
                        <span class="inline-flex items-center gap-1 rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700 animate-pulse">
                            <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                            {{ $revisionCount }} Perlu Revisi
                        </span>
                    @endif
                    @if ($approvedCount === $totalCount && $totalCount > 0)
                        <span class="inline-flex items-center gap-1 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                            ✓ Semua Berkas Sesuai
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-end justify-between gap-4">
                <div class="min-w-0 max-w-3xl">
                    <h1 class="text-2xl font-black tracking-tight text-slate-900 sm:text-3xl" data-module-title>
                        {{ $module->name }}
                    </h1>
                    @if ($module->description)
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">
                            {{ $module->description }}
                        </p>
                    @endif
                </div>

                {{-- Card progress kelengkapan --}}
                <div class="rounded-2xl border border-violet-200/80 bg-gradient-to-br from-violet-50/90 to-purple-50/60 p-4 shadow-sm text-right shrink-0">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-violet-700">Kelengkapan LED &amp; Bukti</p>
                    <div class="mt-1 flex items-baseline justify-end gap-2">
                        <span class="text-2xl font-black tabular-nums text-violet-950">{{ $uploadedCount }}/{{ $totalCount }}</span>
                        <span class="text-xs font-bold text-violet-600">({{ $progressPercent }}%)</span>
                    </div>
                    <div class="mt-2 h-1.5 w-32 overflow-hidden rounded-full bg-violet-200/60">
                        <div class="h-full rounded-full bg-violet-600 transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Quick module switcher pills --}}
    <div class="mb-6 flex items-center gap-1.5 overflow-x-auto pb-2 scrollbar-thin">
        @foreach ($allModules as $itemMod)
            @php
                $isActive = $itemMod->id === $module->id;
            @endphp
            <a
                href="{{ route('unit.submissions.module', $itemMod) }}"
                class="inline-flex shrink-0 items-center gap-1.5 rounded-xl px-3.5 py-2 text-xs font-bold transition {{ $isActive ? 'bg-violet-700 text-white shadow-md shadow-violet-500/20' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-violet-50 hover:text-violet-700 hover:border-violet-200' }}"
                title="{{ $itemMod->name }}"
            >
                @if ($itemMod->isSuplemen())
                    <span class="h-1.5 w-1.5 rounded-full {{ $isActive ? 'bg-amber-300' : 'bg-amber-500' }}"></span>
                @else
                    <span class="h-1.5 w-1.5 rounded-full {{ $isActive ? 'bg-violet-300' : 'bg-slate-400' }}"></span>
                @endif
                <span>{{ $itemMod->shortLabel() }}</span>
            </a>
        @endforeach
    </div>

    @if (session('upload_partial_failure'))
        <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50/90 px-4 py-3 text-sm text-amber-950 ring-1 ring-amber-500/15">
            <p class="font-semibold">Beberapa berkas gagal diunggah</p>
            <p class="mt-1">Berkas yang valid sudah tersimpan. Periksa bagian yang ditandai merah di bawah, lalu unggah ulang hanya berkas yang bermasalah.</p>
        </div>
    @endif

    @if ($errors->has('files'))
        <div class="mb-6 rounded-2xl border border-red-100 bg-red-50/90 px-4 py-3 text-sm font-medium text-red-900 ring-1 ring-red-500/10">
            {{ $errors->first('files') }}
        </div>
    @endif

    {{-- ── FORM PPEPP SUBMISSION ────────────────────────────────────────────────── --}}
    <div class="ui-card overflow-hidden">
        @include('unit.submissions._module-form', ['module' => $module])
    </div>

    @include('unit.submissions._module-modals', ['module' => $module])

    <script>
        const uploadStatus = sessionStorage.getItem('upload_status');
        if (uploadStatus) {
            sessionStorage.removeItem('upload_status');
            const alert = document.createElement('div');
            alert.className = 'ui-alert-success mb-6';
            alert.setAttribute('role', 'status');
            alert.innerHTML = '<span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white text-xs font-bold">✓</span><span>' + uploadStatus + '</span>';
            document.querySelector('main')?.prepend(alert);
        }
    </script>
</x-app-layout>
