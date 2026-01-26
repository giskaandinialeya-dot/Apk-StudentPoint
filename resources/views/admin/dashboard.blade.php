@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="min-h-screen">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8" data-aos="fade-down">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold gradient-text mb-2">Dashboard Admin</h1>
                <p class="text-gray-600 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    {{ date('l, d F Y') }} • Kelola sistem E-POIN
                </p>
            </div>
            <div class="hidden lg:block text-right text-gray-600 text-sm">
                <p>Selamat datang,</p>
                <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-2 md:gap-3 mb-6 sm:mb-8">
        @php
            $totalSiswa = \App\Models\Siswa::where('status', 'aktif')->count();
            $totalGuru = \App\Models\Guru::where('status', 'aktif')->count();
            $totalKelas = \App\Models\Kelas::where('status', 'aktif')->count();
            $totalSP = \App\Models\SuratPeringatan::where('status', 'aktif')->count();
        @endphp

        <!-- Total Siswa Card -->
        <div class="card-hover bg-white rounded-xl shadow-md p-2 sm:p-3 md:p-4 border-t-4 border-blue-500" data-aos="fade-up" data-aos-delay="0">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium truncate">Total Siswa</p>
                    <p class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $totalSiswa }}</p>
                    <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> <span class="hidden sm:inline">12% dari bulan lalu</span>
                    </p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-users text-white text-xs sm:text-sm md:text-base"></i>
                </div>
            </div>
        </div>

        <!-- Total Guru Card -->
        <div class="card-hover bg-white rounded-xl shadow-md p-2 sm:p-3 md:p-4 border-t-4 border-green-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium truncate">Total Guru</p>
                    <p class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $totalGuru }}</p>
                    <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> <span class="hidden sm:inline">5% dari bulan lalu</span>
                    </p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 flex-shrink-0 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-chalkboard-user text-white text-xs sm:text-sm md:text-base"></i>
                </div>
            </div>
        </div>

        <!-- Total Kelas Card -->
        <div class="card-hover bg-white rounded-xl shadow-md p-2 sm:p-3 md:p-4 border-t-4 border-purple-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium truncate">Total Kelas</p>
                    <p class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $totalKelas }}</p>
                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                        <i class="fas fa-circle text-purple-500"></i> <span class="hidden sm:inline">Semua aktif</span>
                    </p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 flex-shrink-0 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-school text-white text-xs sm:text-sm md:text-base"></i>
                </div>
            </div>
        </div>

        <!-- Surat Peringatan Card -->
        <div class="card-hover bg-white rounded-xl shadow-md p-2 sm:p-3 md:p-4 border-t-4 border-red-500" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    <p class="text-gray-600 text-xs sm:text-sm font-medium truncate">Surat Peringatan Aktif</p>
                    <p class="text-xl sm:text-2xl md:text-3xl font-bold text-red-600 mt-1">{{ $totalSP }}</p>
                    <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                        <i class="fas fa-bell pulse-custom"></i> <span class="hidden sm:inline">Perlu perhatian</span>
                    </p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 flex-shrink-0 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-exclamation text-white text-xs sm:text-sm md:text-base"></i>
                </div>
            </div>
        </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
            <!-- Left Column (2/3) -->
            <div class="lg:col-span-2 space-y-3 sm:space-y-4 md:space-y-6">
            <!-- Recent Violations -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 border-b border-gray-200 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-history text-red-600"></i>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900">Pelanggaran Terbaru</h3>
                    </div>
                    <span class="text-xs bg-red-100 text-red-700 px-2 sm:px-3 py-1 rounded-full font-medium flex-shrink-0">Real-time</span>
                </div>
                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @php
                        $recentViolations = \App\Models\Pelanggaran::with(['siswa', 'jenisPelanggaran'])
                            ->latest()
                            ->take(8)
                            ->get();
                    @endphp
                    @if($recentViolations->count() > 0)
                        @foreach($recentViolations as $violation)
                            <div class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 hover:bg-blue-50 transition-colors border-l-4 border-transparent hover:border-blue-500">
                                <div class="flex items-center justify-between gap-3 sm:gap-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900">{{ $violation->siswa->nama_lengkap }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">{{ $violation->jenisPelanggaran->nama }}</span>
                                            <span class="text-xs text-gray-500">{{ $violation->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 text-right">
                                        <p class="font-bold text-red-600 text-lg">+{{ $violation->jenisPelanggaran->poin }}</p>
                                        <p class="text-xs text-gray-500">poin</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="px-3 sm:px-4 md:px-6 py-8 sm:py-12 text-center text-gray-500">
                            <i class="fas fa-check-circle text-3xl text-green-500 mb-2 block"></i>
                            <p class="font-medium text-sm">Tidak ada pelanggaran</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Critical Points Students -->
            @php
                $criticalStudents = \App\Models\Siswa::where('status', 'aktif')
                    ->get()
                    ->filter(function($siswa) {
                        $poin = $siswa->pelanggarans()
                            ->where('status', 'aktif')
                            ->with('jenisPelanggaran')
                            ->get()
                            ->sum('jenisPelanggaran.poin') ?? 0;
                        return $poin >= 10;
                    })
                    ->sortByDesc(function($siswa) {
                        return $siswa->pelanggarans()
                            ->where('status', 'aktif')
                            ->with('jenisPelanggaran')
                            ->get()
                            ->sum('jenisPelanggaran.poin');
                    })
                    ->take(5);
            @endphp
            <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-gradient-to-r from-orange-50 to-red-50 px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 border-b border-gray-200 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-radiation-alt text-red-600 animate-pulse"></i>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900">⚠️ Siswa Poin Kritis</h3>
                    </div>
                    <span class="text-xs bg-red-100 text-red-700 px-2 sm:px-3 py-1 rounded-full font-medium flex-shrink-0">{{ $criticalStudents->count() ?? 0 }}</span>
                </div>
                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @if($criticalStudents->count() > 0)
                        @foreach($criticalStudents as $student)
                            @php
                                $totalPoin = $student->pelanggarans()
                                    ->where('status', 'aktif')
                                    ->with('jenisPelanggaran')
                                    ->get()
                                    ->sum('jenisPelanggaran.poin');
                                $sp = $student->suratPeringatan()->where('status', 'aktif')->first();
                            @endphp
                            <div class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 hover:bg-red-50 transition-colors border-l-4 {{ $totalPoin >= 30 ? 'border-red-600' : 'border-orange-500' }}">
                                <div class="flex items-center justify-between gap-3 sm:gap-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 text-sm sm:text-base">{{ $student->nama_lengkap }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $student->kelas->nama ?? '-' }} • {{ $student->nis }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <div class="inline-block px-2 sm:px-3 py-1 rounded-lg {{ $totalPoin >= 30 ? 'bg-red-100' : 'bg-orange-100' }}">
                                            <p class="font-bold text-xs sm:text-sm {{ $totalPoin >= 30 ? 'text-red-700' : 'text-orange-700' }}">{{ $totalPoin }} poin</p>
                                        </div>
                                        @if($sp)
                                            <p class="text-xs font-bold text-red-600 mt-2 badge-pulse">SP{{ $sp->level }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-shield-alt text-3xl text-green-500 mb-2 block"></i>
                            <p class="font-medium">Semua siswa dalam kondisi baik</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column (1/3) -->
        <div class="space-y-3 sm:space-y-4 md:space-y-6">
            <!-- Today's Summary -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-chart-line text-blue-600"></i>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900">Ringkasan Hari Ini</h3>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @php
                        $violationsToday = \App\Models\Pelanggaran::whereDate('created_at', date('Y-m-d'))->count();
                        $achievementsToday = \App\Models\Prestasi::whereDate('created_at', date('Y-m-d'))->count();
                        $spToday = \App\Models\SuratPeringatan::whereDate('created_at', date('Y-m-d'))->count();
                    @endphp

                    <div class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4">
                        <div class="flex items-center justify-between gap-2 sm:gap-3">
                            <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exclamation text-red-600 text-xs sm:text-sm"></i>
                                </div>
                                <span class="text-gray-600 font-medium text-xs sm:text-sm truncate">Pelanggaran</span>
                            </div>
                            <p class="font-bold text-lg sm:text-xl text-gray-900 flex-shrink-0">{{ $violationsToday }}</p>
                        </div>
                    </div>

                    <div class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 border-t">
                        <div class="flex items-center justify-between gap-2 sm:gap-3">
                            <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-star text-green-600 text-xs sm:text-sm"></i>
                                </div>
                                <span class="text-gray-600 font-medium text-xs sm:text-sm truncate">Prestasi</span>
                            </div>
                            <p class="font-bold text-lg sm:text-xl text-gray-900 flex-shrink-0">{{ $achievementsToday }}</p>
                        </div>
                    </div>

                    <div class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 border-t">
                        <div class="flex items-center justify-between gap-2 sm:gap-3">
                            <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-alt text-orange-600 text-xs sm:text-sm"></i>
                                </div>
                                <span class="text-gray-600 font-medium text-xs sm:text-sm truncate">Surat Peringatan</span>
                            </div>
                            <p class="font-bold text-lg sm:text-xl text-gray-900 flex-shrink-0">{{ $spToday }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students per Class -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-layer-group text-purple-600"></i>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900">Siswa Per Kelas</h3>
                    </div>
                </div>
                <div class="divide-y divide-gray-200 max-h-64 overflow-y-auto">
                    @php
                        $kelases = \App\Models\Kelas::where('status', 'aktif')
                            ->withCount(['siswas' => fn($q) => $q->where('status', 'aktif')])
                            ->get();
                    @endphp
                    @forelse($kelases as $kelas)
                        <div class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 hover:bg-purple-50 transition-colors flex justify-between items-center gap-2">
                            <span class="text-gray-900 font-medium text-sm sm:text-base truncate">{{ $kelas->nama }}</span>
                            <span class="inline-block px-2 sm:px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs sm:text-sm font-semibold flex-shrink-0">
                                {{ $kelas->siswas_count }}
                            </span>
                        </div>
                    @empty
                        <div class="px-3 sm:px-4 md:px-6 py-6 sm:py-8 text-center text-gray-500">
                            <p class="text-sm">Tidak ada kelas</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200 p-3 sm:p-4 md:p-6" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start gap-2 sm:gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                        <i class="fas fa-check text-white text-xs sm:text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-green-900 mb-2 sm:mb-3 text-sm sm:text-base">Sistem Berjalan Normal</h4>
                        <div class="text-xs sm:text-sm text-green-800 space-y-1 sm:space-y-2">
                            <p><i class="fas fa-circle text-green-600 text-xs mr-2"></i>Laravel 11</p>
                            <p><i class="fas fa-circle text-green-600 text-xs mr-2"></i>MySQL Online</p>
                            <p><i class="fas fa-circle text-green-600 text-xs mr-2"></i>Version 1.0 MVP</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Violation Types Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up">
        <div class=\"bg-gradient-to-r from-gray-50 to-gray-100 px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 border-b border-gray-200\">
            <div class=\"flex items-center gap-2\">
                <i class=\"fas fa-table text-gray-600\"></i>
                <h3 class=\"text-base sm:text-lg font-bold text-gray-900\">Daftar Jenis Pelanggaran</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs sm:text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 text-left font-bold text-gray-900">Nama Pelanggaran</th>
                        <th class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 text-left font-bold text-gray-900">Poin</th>
                        <th class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 text-left font-bold text-gray-900">Kategori</th>
                        <th class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 text-left font-bold text-gray-900">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $violationTypes = \App\Models\JenisPerlanggaran::where('status', 'aktif')->take(10)->get();
                    @endphp
                    @forelse($violationTypes as $type)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 text-gray-900 font-medium">{{ $type->nama }}</td>
                            <td class="px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4">
                                <span class="inline-block px-2 sm:px-3 py-1 bg-red-100 text-red-700 rounded-lg font-bold text-xs sm:text-sm">
                                    {{ $type->poin }} poin
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                    @if($type->kategori === 'ringan') bg-green-100 text-green-800
                                    @elseif($type->kategori === 'sedang') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($type->kategori) }}
                                </span>
                            </td>
                            <td class=\"px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4\">
                                <div class=\"inline-flex items-center gap-1 px-2 sm:px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs sm:text-sm font-medium\">
                                    <i class="fas fa-check-circle"></i>
                                    Aktif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <p><i class="fas fa-inbox text-2xl text-gray-400 mb-2 block"></i>Tidak ada data</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Add any additional admin dashboard scripts here
    console.log('Admin Dashboard loaded with AOS animations');
</script>
@endpush

    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Siswa -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Siswa</p>
                        @php
                            $totalSiswa = \App\Models\Siswa::where('status', 'aktif')->count();
                        @endphp
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSiswa }}</p>
                    </div>
                    <div class="text-blue-500 bg-blue-50 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Guru -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Guru</p>
                        @php
                            $totalGuru = \App\Models\Guru::where('status', 'aktif')->count();
                        @endphp
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalGuru }}</p>
                    </div>
                    <div class="text-green-500 bg-green-50 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.5 1.5H5.75A2.25 2.25 0 003.5 3.75v12.5A2.25 2.25 0 005.75 18.5h8.5a2.25 2.25 0 002.25-2.25V6.5m-11-4h8m-8 3h8m-8 3h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Kelas -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Kelas</p>
                        @php
                            $totalKelas = \App\Models\Kelas::where('status', 'aktif')->count();
                        @endphp
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalKelas }}</p>
                    </div>
                    <div class="text-purple-500 bg-purple-50 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Surat Peringatan Aktif -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">SP Aktif</p>
                        @php
                            $totalSP = \App\Models\SuratPeringatan::where('status', 'aktif')->count();
                        @endphp
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $totalSP }}</p>
                    </div>
                    <div class="text-red-500 bg-red-50 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Violations -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Pelanggaran Terbaru</h3>
                        <a href="#" class="text-blue-600 text-sm hover:text-blue-800">Lihat Semua →</a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @php
                            $recentViolations = \App\Models\Pelanggaran::with(['siswa', 'jenisPelanggaran'])
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp
                        @if($recentViolations->count() > 0)
                            @foreach($recentViolations as $violation)
                                <div class="px-6 py-4 hover:bg-gray-50 transition">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $violation->siswa->nama_lengkap }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $violation->jenisPelanggaran->nama }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $violation->created_at->diffForHumans() }}</p>
                                        </div>
                                        <p class="font-semibold text-red-600">+{{ $violation->jenisPelanggaran->poin }} poin</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="px-6 py-8 text-center text-gray-500">
                                Tidak ada pelanggaran
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Students with Critical Points -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">⚠️ Siswa Poin Kritis</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @php
                            $criticalStudents = \App\Models\Siswa::where('status', 'aktif')
                                ->get()
                                ->filter(function($siswa) {
                                    $poin = $siswa->pelanggarans()
                                        ->where('status', 'aktif')
                                        ->with('jenisPelanggaran')
                                        ->get()
                                        ->sum('jenisPelanggaran.poin') ?? 0;
                                    return $poin >= 10;
                                })
                                ->sortByDesc(function($siswa) {
                                    return $siswa->pelanggarans()
                                        ->where('status', 'aktif')
                                        ->with('jenisPelanggaran')
                                        ->get()
                                        ->sum('jenisPelanggaran.poin');
                                })
                                ->take(5);
                        @endphp
                        @if($criticalStudents->count() > 0)
                            @foreach($criticalStudents as $student)
                                @php
                                    $totalPoin = $student->pelanggarans()
                                        ->where('status', 'aktif')
                                        ->with('jenisPelanggaran')
                                        ->get()
                                        ->sum('jenisPelanggaran.poin');
                                @endphp
                                <div class="px-6 py-4 hover:bg-gray-50 transition">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $student->nama_lengkap }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $student->kelas->nama ?? '-' }} • {{ $student->nis }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-red-600 text-lg">{{ $totalPoin }} poin</p>
                                            @php
                                                $sp = $student->suratPeringatan()->where('status', 'aktif')->first();
                                            @endphp
                                            @if($sp)
                                                <p class="text-xs text-red-600 mt-1">SP{{ $sp->level }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="px-6 py-8 text-center text-gray-500">
                                ✓ Tidak ada siswa dengan poin kritis
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Ringkasan Hari Ini</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @php
                            $violationsToday = \App\Models\Pelanggaran::whereDate('created_at', date('Y-m-d'))->count();
                            $achievementsToday = \App\Models\Prestasi::whereDate('created_at', date('Y-m-d'))->count();
                            $spToday = \App\Models\SuratPeringatan::whereDate('created_at', date('Y-m-d'))->count();
                        @endphp
                        <div class="px-6 py-4">
                            <span class="text-gray-600">Pelanggaran Hari Ini:</span>
                            <p class="font-semibold text-gray-900 text-lg">{{ $violationsToday }}</p>
                        </div>
                        <div class="px-6 py-4">
                            <span class="text-gray-600">Prestasi Hari Ini:</span>
                            <p class="font-semibold text-gray-900 text-lg">{{ $achievementsToday }}</p>
                        </div>
                        <div class="px-6 py-4">
                            <span class="text-gray-600">SP Dihasilkan Hari Ini:</span>
                            <p class="font-semibold text-red-600 text-lg">{{ $spToday }}</p>
                        </div>
                        <div class="px-6 py-4">
                            <span class="text-gray-600">Siswa Total:</span>
                            <p class="font-semibold text-gray-900 text-lg">{{ $totalSiswa }}</p>
                        </div>
                    </div>
                </div>

                <!-- By Class -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Siswa Per Kelas</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @php
                            $kelases = \App\Models\Kelas::where('status', 'aktif')
                                ->withCount(['siswas' => fn($q) => $q->where('status', 'aktif')])
                                ->get();
                        @endphp
                        @foreach($kelases as $kelas)
                            <div class="px-6 py-3 flex justify-between items-center hover:bg-gray-50">
                                <span class="text-gray-900">{{ $kelas->nama }}</span>
                                <span class="font-semibold text-blue-600">{{ $kelas->siswas_count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Management Links -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Manajemen</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <a href="#" class="block px-6 py-3 hover:bg-gray-50 text-gray-900 font-medium">
                            👥 Kelola User
                        </a>
                        <a href="#" class="block px-6 py-3 hover:bg-gray-50 text-gray-900 font-medium">
                            🏫 Kelola Kelas
                        </a>
                        <a href="#" class="block px-6 py-3 hover:bg-gray-50 text-gray-900 font-medium">
                            📋 Jenis Pelanggaran
                        </a>
                        <a href="#" class="block px-6 py-3 hover:bg-gray-50 text-gray-900 font-medium">
                            ⚙️ Pengaturan
                        </a>
                        <a href="#" class="block px-6 py-3 hover:bg-gray-50 text-gray-900 font-medium">
                            📊 Laporan
                        </a>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <h4 class="font-semibold text-blue-900 mb-3">ℹ️ Info Sistem</h4>
                    <div class="text-sm text-blue-800 space-y-2">
                        <p>Laravel 11</p>
                        <p>Database: MySQL</p>
                        <p>Version: 1.0 MVP</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Violation Types Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Jenis Pelanggaran</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Poin</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Kategori</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $violationTypes = \App\Models\JenisPerlanggaran::where('status', 'aktif')->get();
                        @endphp
                        @foreach($violationTypes as $type)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-900">{{ $type->nama }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $type->poin }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                                        @if($type->kategori === 'ringan') bg-green-100 text-green-800
                                        @elseif($type->kategori === 'sedang') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($type->kategori) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
