@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="w-full">
    <div class="min-h-screen">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8" data-aos="fade-down">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold gradient-text mb-2">Dashboard Siswa</h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-calendar-alt"></i>
                        {{ date('l, d F Y') }} • Pantau prestasi dan pelanggaran Anda
                    </p>
                </div>
                <div class="hidden lg:block">
                    <div class="text-right">
                        <p class="text-gray-600 text-sm">Kelas:</p>
                        <p class="font-bold text-lg text-gray-900">{{ $siswa->kelas->nama ?? 'Belum Dikonfirmasi' }}</p>
                    </div>
                </div>
            </div>
        </div>

        @php
            $totalPelanggaran = $siswa->total_poin_pelanggaran ?? 0;
            $totalPrestasi = $siswa->total_poin_prestasi ?? 0;
            $saldo = $totalPrestasi - $totalPelanggaran;
        @endphp

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8 w-full">
            <!-- Saldo Poin -->
            <div class="transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white rounded-xl shadow-md p-3 sm:p-4 border-t-4 {{ $saldo >= 0 ? 'border-green-500' : 'border-red-500' }}" data-aos="fade-up">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-600 text-xs font-bold uppercase tracking-wider">Saldo Poin</p>
                        <p class="text-2xl sm:text-3xl font-extrabold {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1 break-words">{{ $saldo }}</p>
                        <p class="text-xs {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center gap-1 font-medium">
                            <i class="fas {{ $saldo >= 0 ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                            <span class="hidden sm:inline">{{ $saldo >= 0 ? 'Baik' : 'Perlu Perhatian' }}</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 flex-shrink-0 {{ $saldo >= 0 ? 'bg-gradient-to-br from-green-500 to-green-600' : 'bg-gradient-to-br from-red-500 to-red-600' }} rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-coins text-white text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Poin Pelanggaran -->
            <div class="transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white rounded-xl shadow-md p-3 sm:p-4 border-t-4 border-red-500" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-600 text-xs font-bold uppercase tracking-wider">Pelanggaran</p>
                        <p class="text-2xl sm:text-3xl font-extrabold text-red-600 mt-1">{{ $totalPelanggaran }}</p>
                        <p class="text-xs text-red-600 mt-2 flex items-center gap-1 font-medium">
                            <i class="fas fa-arrow-up"></i> <span class="hidden sm:inline">{{ $recentPelanggarans->count() }} baru</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 flex-shrink-0 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-exclamation text-white text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Poin Prestasi -->
            <div class="transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white rounded-xl shadow-md p-3 sm:p-4 border-t-4 border-green-500" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-600 text-xs font-bold uppercase tracking-wider">Prestasi</p>
                        <p class="text-2xl sm:text-3xl font-extrabold text-green-600 mt-1">{{ $totalPrestasi }}</p>
                        <p class="text-xs text-green-600 mt-2 flex items-center gap-1 font-medium">
                            <i class="fas fa-star"></i> <span class="hidden sm:inline">{{ $recentPrestasis->count() }} baru</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 flex-shrink-0 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-star text-white text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Status Kehadiran -->
            <div class="transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white rounded-xl shadow-md p-3 sm:p-4 border-t-4 border-blue-500" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-600 text-xs font-bold uppercase tracking-wider">Status Hari Ini</p>
                        <p class="text-2xl sm:text-3xl font-extrabold text-blue-600 mt-1">
                            @if($statusHariIni === 'hadir')
                                <i class="fas fa-check-circle"></i>
                            @elseif($statusHariIni === 'sakit')
                                <i class="fas fa-heartbeat"></i>
                            @elseif($statusHariIni === 'izin')
                                <i class="fas fa-file-alt"></i>
                            @else
                                <i class="fas fa-question-circle"></i>
                            @endif
                        </p>
                        <p class="text-xs text-blue-600 mt-2 truncate font-medium">
                            {{ ucfirst($statusHariIni === null || $statusHariIni === '' ? 'belum absen' : $statusHariIni) }}
                        </p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-clipboard-check text-white text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Bulan -->
            <div class="transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white rounded-xl shadow-md p-3 sm:p-4 border-t-4 border-purple-500" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-600 text-xs font-bold uppercase tracking-wider">Hadir Bulan Ini</p>
                        <p class="text-2xl sm:text-3xl font-extrabold text-purple-600 mt-1">{{ $rekapBulanIni['hadir'] }}</p>
                        <p class="text-xs text-purple-600 mt-2 flex items-center gap-1 truncate font-medium">
                            <i class="fas fa-calendar-check flex-shrink-0"></i> <span class="hidden sm:inline">hari</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 flex-shrink-0 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-pie text-white text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mb-6 sm:mb-8" data-aos="fade-up">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-bolt text-blue-600"></i>
                Menu Cepat
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 w-full">
                <!-- Input Absensi -->
                <button onclick="showAbsensiModal()" class="transform transition-all duration-300 hover:scale-105 active:scale-95 group bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl p-4 transition-all border-2 border-purple-200 hover:border-purple-400 text-center cursor-pointer hover:shadow-lg">
                    <div class="text-3xl sm:text-4xl mb-2 group-hover:rotate-12 transition-transform inline-block">✓</div>
                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">Input Absensi</h4>
                    <p class="text-xs text-gray-600 mt-1">Sekarang</p>
                </button>

                <!-- Lihat Riwayat Absensi -->
                <a href="{{ route('siswa.absensi.riwayat') }}" class="transform transition-all duration-300 hover:scale-105 active:scale-95 group bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl p-4 transition-all border-2 border-blue-200 hover:border-blue-400 text-center hover:shadow-lg block">
                    <div class="text-3xl sm:text-4xl mb-2 group-hover:rotate-12 transition-transform inline-block">📋</div>
                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">Riwayat Absensi</h4>
                    <p class="text-xs text-gray-600 mt-1">Lengkap</p>
                </a>

                <!-- Lihat Profil -->
                <a href="{{ route('siswa.profil.show') }}" class="transform transition-all duration-300 hover:scale-105 active:scale-95 group bg-gradient-to-br from-indigo-50 to-indigo-100 hover:from-indigo-100 hover:to-indigo-200 rounded-xl p-4 transition-all border-2 border-indigo-200 hover:border-indigo-400 text-center hover:shadow-lg block">
                    <div class="text-3xl sm:text-4xl mb-2 group-hover:rotate-12 transition-transform inline-block">👤</div>
                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">Profil Saya</h4>
                    <p class="text-xs text-gray-600 mt-1">Lihat Detail</p>
                </a>

                <!-- Edit Profil -->
                <a href="{{ route('siswa.profil.edit') }}" class="transform transition-all duration-300 hover:scale-105 active:scale-95 group bg-gradient-to-br from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 rounded-xl p-4 transition-all border-2 border-orange-200 hover:border-orange-400 text-center hover:shadow-lg block">
                    <div class="text-3xl sm:text-4xl mb-2 group-hover:rotate-12 transition-transform inline-block">✏️</div>
                    <h4 class="font-bold text-gray-900 text-sm sm:text-base">Edit Profil</h4>
                    <p class="text-xs text-gray-600 mt-1">Perbarui Data</p>
                </a>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 w-full">
            <!-- Left Column - Activity & Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300" data-aos="fade-up">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-history text-gray-600"></i>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900">Aktivitas Terbaru</h3>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 sm:px-3 py-1 rounded-full font-medium flex-shrink-0">Real-time</span>
                    </div>
                    <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                        @php
                            $activities = collect()
                                ->concat($recentPelanggarans->map(fn($p) => ['type' => 'pelanggaran', 'icon' => '⚠️', 'text' => $p->jenisPelanggaran->nama . ' (' . $p->jenisPelanggaran->poin . ' poin)', 'date' => $p->tanggal]))
                                ->concat($recentPrestasis->map(fn($p) => ['type' => 'prestasi', 'icon' => '⭐', 'text' => $p->nama_prestasi . ' (' . $p->poin . ' poin)', 'date' => $p->tanggal]))
                                ->sortByDesc('date')
                                ->take(10);
                        @endphp
                        @if($activities->count() > 0)
                            @foreach($activities as $activity)
                                <div class="px-4 sm:px-6 py-3 sm:py-4 hover:bg-blue-50 transition-colors border-l-4 {{ $activity['type'] === 'pelanggaran' ? 'border-red-500' : 'border-green-500' }}">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $activity['text'] }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $activity['date']->format('d M Y') }}</p>
                                        </div>
                                        <span class="text-2xl flex-shrink-0">{{ $activity['icon'] }}</span>
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

                <!-- Pelanggaran List Section -->
                <div id="pelanggaran" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300" data-aos="fade-up">
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                            Pelanggaran Terbaru
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @if($recentPelanggarans->count() > 0)
                            @foreach($recentPelanggarans as $pelanggaran)
                                <div class="px-4 sm:px-6 py-3 sm:py-4 hover:bg-red-50 transition-colors">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <p class="font-semibold text-gray-900">{{ $pelanggaran->jenisPelanggaran->nama }}</p>
                                                <span class="px-2 py-1 text-xs rounded-full font-semibold 
                                                    {{ $pelanggaran->jenisPelanggaran->kategori === 'ringan' ? 'bg-yellow-100 text-yellow-800' : ($pelanggaran->jenisPelanggaran->kategori === 'sedang' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($pelanggaran->jenisPelanggaran->kategori) }}
                                                </span>
                                                <span class="ml-auto font-bold text-red-600">-{{ $pelanggaran->jenisPelanggaran->poin }} poin</span>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $pelanggaran->deskripsi ?? 'Tidak ada keterangan' }}</p>
                                            <p class="text-xs text-gray-500 mt-2">{{ $pelanggaran->tanggal->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-smile text-3xl text-green-400 mb-2 block"></i>
                                <p class="font-medium">Tidak ada pelanggaran</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Prestasi List Section -->
                <div id="prestasi" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300" data-aos="fade-up">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-star text-green-600"></i>
                            Prestasi Terbaru
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @if($recentPrestasis->count() > 0)
                            @foreach($recentPrestasis as $prestasi)
                                <div class="px-4 sm:px-6 py-3 sm:py-4 hover:bg-green-50 transition-colors">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900">{{ $prestasi->nama_prestasi }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $prestasi->deskripsi ?? 'Prestasi mencapai' }}</p>
                                            <p class="text-xs text-gray-500 mt-2">{{ $prestasi->tanggal->format('d M Y') }}</p>
                                        </div>
                                        <span class="font-bold text-green-600 text-lg">+{{ $prestasi->poin }} poin</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="px-4 sm:px-6 py-8 sm:py-12 text-center text-gray-500">
                                <i class="fas fa-smile text-3xl text-gray-400 mb-2 block"></i>
                                <p class="font-medium text-sm">Belum ada prestasi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Summary -->
            <div class="space-y-6">
                <!-- Monthly Summary -->
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 hover:shadow-lg transition-shadow duration-300" data-aos="fade-up">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-purple-600"></i>
                        Ringkasan Bulan Ini
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg gap-2 hover:bg-green-100 transition-colors cursor-default">
                            <span class="text-gray-700 font-medium text-sm">Hadir</span>
                            <span class="font-bold text-green-600 text-sm sm:text-base flex-shrink-0">{{ $rekapBulanIni['hadir'] }} hari</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg gap-2 hover:bg-yellow-100 transition-colors cursor-default">
                            <span class="text-gray-700 font-medium text-sm">Sakit</span>
                            <span class="font-bold text-yellow-600 text-sm sm:text-base flex-shrink-0">{{ $rekapBulanIni['sakit'] }} hari</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg gap-2 hover:bg-blue-100 transition-colors cursor-default">
                            <span class="text-gray-700 font-medium text-sm">Izin</span>
                            <span class="font-bold text-blue-600 text-sm sm:text-base flex-shrink-0">{{ $rekapBulanIni['izin'] }} hari</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg gap-2 hover:bg-red-100 transition-colors cursor-default">
                            <span class="text-gray-700 font-medium text-sm">Alfa</span>
                            <span class="font-bold text-red-600 text-sm sm:text-base flex-shrink-0">{{ $rekapBulanIni['alfa'] }} hari</span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kelas -->
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 hover:shadow-lg transition-shadow duration-300" data-aos="fade-up">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-school text-blue-600"></i>
                        Informasi Kelas
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                            <p class="text-gray-600 font-medium">Kelas</p>
                            <p class="text-gray-900 font-semibold">{{ $siswa->kelas->nama ?? '-' }}</p>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                            <p class="text-gray-600 font-medium">NIS</p>
                            <p class="text-gray-900 font-semibold">{{ $siswa->nis }}</p>
                        </div>
                        <div class="pb-2 border-b border-gray-100">
                            <p class="text-gray-600 font-medium mb-1">Wali Kelas</p>
                            <p class="text-gray-900 font-semibold">{{ $siswa->kelas->guru->nama_lengkap ?? 'Belum Ditugaskan' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 font-medium mb-1">Status</p>
                            <span class="px-3 py-1 {{ $siswa->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full text-xs font-semibold inline-block">
                                {{ ucfirst($siswa->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200 p-4 hover:shadow-lg transition-all duration-300" data-aos="fade-up">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-lightbulb text-white text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-blue-900 mb-1 text-sm">Tips</h4>
                            <p class="text-sm text-blue-800">
                                @if($saldo >= 50)
                                    🌟 Luar biasa! Terus pertahankan prestasi Anda!
                                @elseif($saldo >= 0)
                                    ✓ Terus tingkatkan prestasi dan kurangi pelanggaran
                                @elseif($saldo >= -10)
                                    ⚠️ Perbaiki perilaku Anda segera untuk meningkatkan poin
                                @else
                                    🚨 Segera perbaiki perilaku dan tingkatkan prestasi Anda
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Absensi Modal -->
<div id="absensiModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="absensiModalContent">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-900">Input Absensi</h2>
            <button onclick="closeAbsensiModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <p class="text-gray-600 mb-6 flex items-center gap-2">
            <i class="fas fa-calendar-check text-purple-600"></i>
            {{ now()->format('l, d F Y') }}
        </p>
        
        <div id="absensiMessage" class="mb-4 p-4 rounded-lg hidden text-sm font-medium"></div>

        <form id="absensiForm" class="space-y-4">
            @csrf
            
            <!-- Status Selection -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-3">Pilih Status Absensi</label>
                <div class="space-y-3">
                    <label class="group flex items-center gap-3 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-green-50 hover:border-green-500 transition-all">
                        <input type="radio" name="status" value="hadir" class="w-5 h-5 text-green-600 focus:ring-green-500" required>
                        <div class="flex-1">
                            <span class="font-bold text-gray-900 group-hover:text-green-700">Hadir</span>
                            <p class="text-xs text-gray-500 group-hover:text-green-600">Saya hadir di sekolah hari ini</p>
                        </div>
                        <i class="fas fa-check-circle text-gray-300 group-hover:text-green-500 text-xl transition-colors"></i>
                    </label>

                    <label class="group flex items-center gap-3 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-yellow-50 hover:border-yellow-500 transition-all">
                        <input type="radio" name="status" value="sakit" class="w-5 h-5 text-yellow-600 focus:ring-yellow-500" required>
                        <div class="flex-1">
                            <span class="font-bold text-gray-900 group-hover:text-yellow-700">Sakit</span>
                            <p class="text-xs text-gray-500 group-hover:text-yellow-600">Saya sedang sakit (Upload surat jika ada)</p>
                        </div>
                        <i class="fas fa-heartbeat text-gray-300 group-hover:text-yellow-500 text-xl transition-colors"></i>
                    </label>

                    <label class="group flex items-center gap-3 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-500 transition-all">
                        <input type="radio" name="status" value="izin" class="w-5 h-5 text-blue-600 focus:ring-blue-500" required>
                        <div class="flex-1">
                            <span class="font-bold text-gray-900 group-hover:text-blue-700">Izin</span>
                            <p class="text-xs text-gray-500 group-hover:text-blue-600">Saya memiliki keperluan mendesak</p>
                        </div>
                        <i class="fas fa-file-alt text-gray-300 group-hover:text-blue-500 text-xl transition-colors"></i>
                    </label>
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-2">Keterangan (Opsional)</label>
                <textarea name="keterangan" placeholder="Contoh: Sakit demam tinggi sejak kemarin sore" rows="2" maxlength="255"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all resize-none"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeAbsensiModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-bold transition-colors">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-4 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Absensi
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function showAbsensiModal() {
        const modal = document.getElementById('absensiModal');
        const content = document.getElementById('absensiModalContent');
        
        modal.classList.remove('hidden');
        // Small delay to allow display:flex to apply before adding opacity class
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeAbsensiModal() {
        const modal = document.getElementById('absensiModal');
        const content = document.getElementById('absensiModalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('absensiForm').reset();
            document.getElementById('absensiMessage').classList.add('hidden');
        }, 300); // Wait for transition
    }

    document.getElementById('absensiForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const status = document.querySelector('input[name="status"]:checked').value;
        const keterangan = document.querySelector('textarea[name="keterangan"]').value;
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        // Loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';

        try {
            const response = await fetch('{{ route("siswa.absensi.input-hari-ini") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status, keterangan })
            });

            const data = await response.json();
            const messageDiv = document.getElementById('absensiMessage');

            if (data.success) {
                messageDiv.classList.remove('hidden', 'bg-red-50', 'border', 'border-red-300', 'text-red-700');
                messageDiv.classList.add('bg-green-50', 'border', 'border-green-300', 'text-green-700');
                messageDiv.innerHTML = '<i class="fas fa-check-circle mr-2"></i>' + data.message;

                // Close modal after 1.5 seconds
                setTimeout(() => {
                    closeAbsensiModal();
                    location.reload();
                }, 1500);
            } else {
                messageDiv.classList.remove('hidden', 'bg-green-50', 'border-green-300', 'text-green-700');
                messageDiv.classList.add('bg-red-50', 'border', 'border-red-300', 'text-red-700');
                messageDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>' + data.message;
                
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        } catch (error) {
            console.error('Error:', error);
            const messageDiv = document.getElementById('absensiMessage');
            messageDiv.classList.remove('hidden', 'bg-green-50', 'border-green-300', 'text-green-700');
            messageDiv.classList.add('bg-red-50', 'border', 'border-red-300', 'text-red-700');
            messageDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Terjadi kesalahan: ' + error.message;
            
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });

    // Close modal when clicking outside
    document.getElementById('absensiModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAbsensiModal();
        }
    });
</script>
@endpush
@endsection
