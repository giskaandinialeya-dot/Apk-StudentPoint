@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-4xl font-bold gradient-text">Manajemen Siswa</h1>
            <a href="{{ route('admin.siswa.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                <i class="fas fa-plus mr-2"></i>Tambah Siswa
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" placeholder="Cari nama atau NIS..." value="{{ request('search') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <select name="kelas_id" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas_list as $k)
                        <option value="{{ $k->id }}" @selected(request('kelas_id') == $k->id)>{{ $k->nama }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected(request('status') == 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(request('status') == 'nonaktif')>Nonaktif</option>
                </select>
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-50 to-blue-100 border-b-2 border-blue-300">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">NIS</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Kelas</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Email</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($siswas as $siswa)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $siswa->nis }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ $siswa->nama_lengkap }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $siswa->kelas->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $siswa->user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $siswa->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($siswa->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.siswa.edit', $siswa) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.siswa.destroy', $siswa) }}" class="inline" onclick="return confirm('Hapus siswa ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>Tidak ada siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $siswas->links() }}
        </div>
    </div>
</div>
@endsection
