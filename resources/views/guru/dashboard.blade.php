@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-12" data-aos="fade-down">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold gradient-text mb-2">Dashboard Guru</h1>
                <p class="text-gray-600 flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    {{ date('l, d F Y') }} • Kelola pelanggaran & prestasi siswa
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="text-right">
                    <p class="text-gray-600 text-sm">Wali Kelas:</p>
                    <p class="font-bold text-lg text-gray-900">{{ $kelas->nama ?? 'Belum Ditugaskan' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Siswa -->
        <div class="card-hover bg-white rounded-xl shadow-md p-6 border-t-4 border-blue-500" data-aos="fade-up">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Siswa</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">{{ $jumlahSiswa ?? 0 }}</p>
                    <p class="text-xs text-blue-600 mt-2 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i> Di kelas Anda
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pelanggaran Hari Ini -->
        <div class="card-hover bg-white rounded-xl shadow-md p-6 border-t-4 border-red-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Pelanggaran Hari Ini</p>
                    <p class="text-4xl font-bold text-red-600 mt-2">{{ $pelanggaran_hari_ini ?? 0 }}</p>
                    <p class="text-xs text-red-600 mt-2 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i> Perlu perhatian
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-exclamation text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Prestasi Hari Ini -->
        <div class="card-hover bg-white rounded-xl shadow-md p-6 border-t-4 border-green-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Prestasi Hari Ini</p>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $prestasi_hari_ini ?? 0 }}</p>
                    <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                        <i class="fas fa-star"></i> Pencapaian
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Kehadiran -->
        <div class="card-hover bg-white rounded-xl shadow-md p-6 border-t-4 border-purple-500" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Kehadiran Hari Ini</p>
                    <p class="text-4xl font-bold text-purple-600 mt-2">{{ $persen_kehadiran ?? 0 }}%</p>
                    <p class="text-xs text-purple-600 mt-2 flex items-center gap-1">
                        <i class="fas fa-chart-pie"></i> Tingkat Kehadiran
                    </p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-clipboard-check text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6" data-aos="fade-up">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-bolt text-blue-600"></i>
                    Aksi Cepat
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('guru.pelanggaran.index') }}" class="group bg-gradient-to-br from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 rounded-lg p-4 transition-all border-2 border-red-200 hover:border-red-400">
                        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform inline-block">⚠️</div>
                        <h4 class="font-semibold text-gray-900">Input Pelanggaran</h4>
                        <p class="text-xs text-gray-600 mt-1">Catat pelanggaran siswa</p>
                    </a>
                    <a href="{{ route('guru.prestasi.index') }}" class="group bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-lg p-4 transition-all border-2 border-green-200 hover:border-green-400">
                        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform inline-block">⭐</div>
                        <h4 class="font-semibold text-gray-900">Input Prestasi</h4>
                        <p class="text-xs text-gray-600 mt-1">Catat prestasi siswa</p>
                    </a>
                    <a href="{{ route('guru.absensi.bulk-today') }}" class="group bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-lg p-4 transition-all border-2 border-blue-200 hover:border-blue-400">
                        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform inline-block">✓</div>
                        <h4 class="font-semibold text-gray-900">Input Absensi</h4>
                        <p class="text-xs text-gray-600 mt-1">Catat absensi harian</p>
                    </a>
                    <a href="{{ route('guru.absensi.index') }}" class="group bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-lg p-4 transition-all border-2 border-purple-200 hover:border-purple-400">
                        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform inline-block">📋</div>
                        <h4 class="font-semibold text-gray-900">Riwayat Absensi</h4>
                        <p class="text-xs text-gray-600 mt-1">Lihat riwayat absensi</p>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-history text-gray-600"></i>
                        <h3 class="text-lg font-bold text-gray-900">Aktivitas Terbaru</h3>
                    </div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium">Real-time</span>
                </div>
                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @if(isset($recent_activity) && $recent_activity->count() > 0)
                        @foreach($recent_activity as $activity)
                            <div class="px-6 py-4 hover:bg-blue-50 transition-colors border-l-4 {{ $activity['type'] === 'pelanggaran' ? 'border-red-500' : 'border-green-500' }}">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $activity['siswa'] }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $activity['deskripsi'] }}</p>
                                        <p class="text-xs text-gray-500 mt-2">{{ $activity['tanggal'] }}</p>
                                    </div>
                                    <span class="text-2xl flex-shrink-0">
                                        {{ $activity['type'] === 'pelanggaran' ? '⚠️' : '⭐' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-3xl text-gray-400 mb-2 block"></i>
                            <p class="font-medium">Belum ada aktivitas</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Critical Students -->
            @if(isset($siswa_kritis) && $siswa_kritis->count() > 0)
            <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-radiation-alt text-red-600 animate-pulse"></i>
                        <h3 class="text-lg font-bold text-gray-900">⚠️ Siswa Poin Kritis</h3>
                    </div>
                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-medium">{{ $siswa_kritis->count() }}</span>
                </div>
                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @foreach($siswa_kritis as $siswa)
                        <div class="px-6 py-4 hover:bg-red-50 transition-colors border-l-4 border-red-600">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $siswa['nama'] }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $siswa['kelas'] }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <div class="inline-block px-3 py-1 bg-red-100 rounded-lg">
                                        <p class="font-bold text-red-700">{{ $siswa['poin_pelanggaran'] }}</p>
                                        <p class="text-xs text-red-600">poin</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Class Overview -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-chalkboard-user text-blue-600"></i>
                        <h3 class="text-lg font-bold text-gray-900">Wali Kelas</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    @if(isset($kelas))
                        <div class="text-center">
                            <p class="text-gray-600 text-sm">Kelas Anda</p>
                            <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ $kelas->nama }}</h2>
                            <p class="text-gray-600 mt-4">
                                <i class="fas fa-users"></i>
                                <strong>{{ $jumlahSiswa ?? 0 }}</strong> siswa
                            </p>
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-500">
                            <i class="fas fa-inbox text-2xl mb-2 block text-gray-400"></i>
                            <p class="font-medium">Belum ada kelas</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Points Distribution -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-chart-pie text-purple-600"></i>
                        <h3 class="text-lg font-bold text-gray-900">Distribusi Poin</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-600 font-medium">Pelanggaran</span>
                            <span class="font-bold text-red-600">{{ $total_poin_pelanggaran ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full transition-all" style="width: {{ min(($total_poin_pelanggaran ?? 0) / 10 * 100, 100) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-600 font-medium">Prestasi</span>
                            <span class="font-bold text-green-600">{{ $total_poin_prestasi ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all" style="width: {{ min(($total_poin_prestasi ?? 0) / 10 * 100, 100) }}%"></div>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 font-medium">Saldo Bersih</span>
                            <span class="font-bold text-lg {{ ($total_poin_prestasi ?? 0) - ($total_poin_pelanggaran ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ ($total_poin_prestasi ?? 0) - ($total_poin_pelanggaran ?? 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips & Info -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200 p-6" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                        <i class="fas fa-lightbulb text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-2">Tips Penggunaan</h4>
                        <ul class="text-sm text-blue-800 space-y-2">
                            <li><i class="fas fa-check text-blue-600"></i> Catat pelanggaran segera</li>
                            <li><i class="fas fa-check text-blue-600"></i> Akui prestasi siswa</li>
                            <li><i class="fas fa-check text-blue-600"></i> Monitor poin harian</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Additional guru dashboard scripts
    console.log('Guru Dashboard loaded');
</script>
@endpush
@endsection
