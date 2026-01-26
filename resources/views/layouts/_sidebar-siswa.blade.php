<!-- Sidebar untuk SISWA -->
<div class="space-y-2">
    <div class="px-4 py-4 mb-6">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">MENU SISWA</h3>
    </div>

    <a href="{{ route('siswa.dashboard') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-600 active' : 'hover:bg-gray-700' }} transition-all duration-200">
        <span class="text-lg">📊</span>
        <span class="font-medium">Dashboard</span>
        @if(request()->routeIs('siswa.dashboard'))
            <span class="ml-auto"><i class="fas fa-check text-white"></i></span>
        @endif
    </a>

    <div class="border-t border-gray-700 my-4 opacity-50"></div>

    <div class="px-4 py-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">FITUR SEGERA HADIR</h3>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">⚠️</span>
        <span>Riwayat Pelanggaran</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">⭐</span>
        <span>Riwayat Prestasi</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">📋</span>
        <span>Absensi Saya</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">🎯</span>
        <span>Hasil Ujian & Nilai</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">📄</span>
        <span>Rapor Saya</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>
</div>

        <span>📊</span>
        <span>e-Rapor Saya</span>
    </a>

    <a href="{{ route('siswa.profil.show') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('siswa.profil.*') ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
        <span>👤</span>
        <span>Profil Saya</span>
    </a>
</div>
