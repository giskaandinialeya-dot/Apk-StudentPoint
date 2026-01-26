<!-- Sidebar untuk GURU -->
<div class="space-y-2">
    <div class="px-4 py-4 mb-6">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">MENU GURU</h3>
    </div>

    <a href="{{ route('guru.dashboard') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('guru.dashboard') ? 'bg-blue-600 active' : 'hover:bg-gray-700' }} transition-all duration-200">
        <span class="text-lg">📊</span>
        <span class="font-medium">Dashboard</span>
        @if(request()->routeIs('guru.dashboard'))
            <span class="ml-auto"><i class="fas fa-check text-white"></i></span>
        @endif
    </a>

    <a href="{{ route('guru.pelanggaran.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('guru.pelanggaran.*') ? 'bg-blue-600 active' : 'hover:bg-gray-700' }} transition-all duration-200">
        <span class="text-lg">⚠️</span>
        <span class="font-medium">Input Pelanggaran</span>
        @if(request()->routeIs('guru.pelanggaran.*'))
            <span class="ml-auto"><i class="fas fa-check text-white"></i></span>
        @endif
    </a>

    <a href="{{ route('guru.prestasi.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('guru.prestasi.*') ? 'bg-blue-600 active' : 'hover:bg-gray-700' }} transition-all duration-200">
        <span class="text-lg">⭐</span>
        <span class="font-medium">Input Prestasi</span>
        @if(request()->routeIs('guru.prestasi.*'))
            <span class="ml-auto"><i class="fas fa-check text-white"></i></span>
        @endif
    </a>

    <div class="border-t border-gray-700 my-4 opacity-50"></div>

    <div class="px-4 py-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">FITUR SEGERA HADIR</h3>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">📋</span>
        <span>Absensi Harian</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">🕐</span>
        <span>Absensi Per Jam</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">📝</span>
        <span>Ujian CBT</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">❓</span>
        <span>Bank Soal</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">🎯</span>
        <span>Input Nilai</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">📊</span>
        <span>Rapor Siswa</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>
</div>

