<!-- Sidebar untuk ADMIN -->
<div class="space-y-2">
    <div class="px-4 py-4 mb-6">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">MENU UTAMA</h3>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 active' : 'hover:bg-gray-700' }} transition-all duration-200">
        <span class="text-lg">📊</span>
        <span class="font-medium">Dashboard</span>
        @if(request()->routeIs('admin.dashboard'))
            <span class="ml-auto">
                <i class="fas fa-check text-white"></i>
            </span>
        @endif
    </a>

    <div class="border-t border-gray-700 my-4 opacity-50"></div>

    <div class="px-4 py-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">MANAJEMEN DATA</h3>
    </div>

    <a href="{{ route('admin.siswa.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-600 active' : 'hover:bg-gray-700' }} transition-all duration-200">
        <span class="text-lg">👨‍🎓</span>
        <span>Kelola Siswa</span>
        @if(request()->routeIs('admin.siswa.*'))
            <span class="ml-auto">
                <i class="fas fa-check text-white"></i>
            </span>
        @endif
    </a>

    <a href="{{ route('admin.guru.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.guru.*') ? 'bg-blue-600 active' : 'hover:bg-gray-700' }} transition-all duration-200">
        <span class="text-lg">👨‍🏫</span>
        <span>Kelola Guru</span>
        @if(request()->routeIs('admin.guru.*'))
            <span class="ml-auto">
                <i class="fas fa-check text-white"></i>
            </span>
        @endif
    </a>

    <a href="{{ route('admin.kelas.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-600 active' : 'hover:bg-gray-700' }} transition-all duration-200">
        <span class="text-lg">🏫</span>
        <span>Kelola Kelas</span>
        @if(request()->routeIs('admin.kelas.*'))
            <span class="ml-auto">
                <i class="fas fa-check text-white"></i>
            </span>
        @endif
    </a>

    <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.jenis-pelanggaran.*') ? 'bg-blue-600 active' : 'hover:bg-gray-700' }} transition-all duration-200">
        <span class="text-lg">⚠️</span>
        <span>Jenis Pelanggaran</span>
        @if(request()->routeIs('admin.jenis-pelanggaran.*'))
            <span class="ml-auto">
                <i class="fas fa-check text-white"></i>
            </span>
        @endif
    </a>

    <div class="border-t border-gray-700 my-4 opacity-50"></div>

    <div class="px-4 py-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">FITUR SEGERA HADIR</h3>
    </div>

    <div class="border-t border-gray-700 my-4 opacity-50"></div>

    <div class="px-4 py-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">PENGATURAN</h3>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">⚙️</span>
        <span>Setting Sekolah</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>

    <div class="menu-item flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 text-sm opacity-60 cursor-not-allowed">
        <span class="text-lg">📈</span>
        <span>Laporan Keseluruhan</span>
        <span class="ml-auto text-xs bg-gray-600 px-2 py-1 rounded">Coming</span>
    </div>
</div>

