@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="w-full overflow-x-hidden">
    <div class="min-h-screen overflow-x-hidden">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8" data-aos="fade-down">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold gradient-text mb-2">Riwayat Absensi</h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-history"></i>
                        Lihat semua riwayat absensi Anda
                    </p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-3 sm:p-4 md:p-6 mb-6 sm:mb-8 overflow-x-hidden" data-aos="fade-up">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-filter text-blue-600"></i>
                Filter Absensi
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="filterStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="hadir">✅ Hadir</option>
                        <option value="sakit">🤒 Sakit</option>
                        <option value="izin">📝 Izin</option>
                        <option value="alfa">❌ Alfa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <input type="month" id="filterMonth" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ now()->format('Y-m') }}">
                </div>
                <div class="flex items-end">
                    <button onclick="resetFilter()" class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-medium">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Absensi List -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden" data-aos="fade-up">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-list-check text-gray-600"></i>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900">Daftar Absensi</h3>
                </div>
                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-semibold">{{ $absentis->count() }} Catatan</span>
            </div>

            <div class="divide-y divide-gray-200">
                @if($absentis->count() > 0)
                    @foreach($absentis as $absensi)
                        <div class="px-4 sm:px-6 py-4 hover:bg-blue-50 transition-colors border-l-4 {{ 
                            $absensi->status === 'hadir' ? 'border-green-500' : 
                            ($absensi->status === 'sakit' ? 'border-yellow-500' : 
                            ($absensi->status === 'izin' ? 'border-blue-500' : 'border-red-500'))
                        }}">
                            <div class="flex items-center justify-between gap-4 flex-wrap">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-2xl">
                                            @if($absensi->status === 'hadir')
                                                ✅
                                            @elseif($absensi->status === 'sakit')
                                                🤒
                                            @elseif($absensi->status === 'izin')
                                                📝
                                            @else
                                                ❌
                                            @endif
                                        </span>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ ucfirst($absensi->status) }}</p>
                                            <p class="text-xs sm:text-sm text-gray-600">{{ $absensi->tanggal->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                    @if($absensi->keterangan)
                                        <p class="text-sm text-gray-600 mt-1 pl-10">
                                            <i class="fas fa-comment-dots text-gray-400 mr-2"></i>
                                            {{ $absensi->keterangan }}
                                        </p>
                                    @endif
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-xs sm:text-sm text-gray-500">
                                        {{ $absensi->tanggal->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    @if($absentis->hasPages())
                        <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $absentis->render() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-12 text-center">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-3 block"></i>
                        <p class="text-lg font-medium text-gray-900">Belum ada riwayat absensi</p>
                        <p class="text-gray-600 mt-2">Mulai input absensi Anda hari ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6 sm:mt-8">
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<script>
    // Filter functionality
    function applyFilter() {
        const status = document.getElementById('filterStatus').value;
        const month = document.getElementById('filterMonth').value;
        
        let url = new URL(window.location.href);
        if (status) url.searchParams.set('status', status);
        if (month) url.searchParams.set('month', month);
        
        window.location.href = url.toString();
    }

    function resetFilter() {
        let url = new URL(window.location.href);
        url.search = '';
        window.location.href = url.toString();
    }

    // Auto-apply filter on change
    document.getElementById('filterStatus').addEventListener('change', applyFilter);
    document.getElementById('filterMonth').addEventListener('change', applyFilter);
</script>
@endsection
